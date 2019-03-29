<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use common\models\Product;
use common\models\Order;
use common\models\OrderToProduct;


/**
 * This is the model class for table "user".
 *
 * @property string $id
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $phone
 * @property string $name
 * @property string $subscribe
 * @property string $active
 * @property string $password
 * @property integer $registration_confirmed
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $active_ip
 * @property integer $blocked
 * @property integer $active_at
 * @property integer $block_amount
 */

class User extends \yii\db\ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 1;
    
    /**
     * statuses values
     */
    public static $statuses = array(
        0 => 'Disabled',
        1 => 'Active',
    );
    
    /**
     * user's products activity names
     */
    public static $productActivityNames = array(
        'buyed_all_active' => 'All Products Active',
        'buyed_all_not_active' => 'All Products Expired',
        'buyed_active' => 'One Product Active',
        'buyed_not_active' => 'One Product Expired',
        'nothing_buyed' => 'Leads',
    );
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function afterSave($insert, $changedAttributes)
    {
        $r = true;

        return parent::afterSave($insert, $changedAttributes);
    }
    
    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        $this->password = Yii::$app->security->generatePasswordHash($password);
        if ($this->active == 1) {
            $this->blocked = 0;
        }
        return parent::beforeSave($insert);
    }
    
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }
    
    public function delete()
    {
        parent::delete();
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email', 'name'], 'required'],
            [['email'], 'email'],
            [['email'], 'unique'],
            [['subscribe', 'active', 'registration_confirmed', 'created_at', 'updated_at', 'active_ip', 'blocked', 'active_at', 'block_amount'], 'integer'],
            [['auth_key'], 'string', 'max' => 32],
            [['password_hash', 'password_reset_token', 'email', 'phone', 'name'], 'string', 'max' => 255],
            [['password'], 'string', 'max' => 50],
            [['password_reset_token'], 'unique'],
            ['active', 'in', 'range' => array_keys(self::$statuses)],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'email' => 'Email',
            'phone' => 'Phone',
            'name' => 'Name',
            'subscribe' => 'Subscribe',
            'active' => 'Active',
            'password' => 'Password',
            'registration_confirmed' => 'Registration Confirmed',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
    
   /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'active' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by Email
     *
     * @param string $email
     * @return static|null
     */
    public static function findByEmail($email, $active = self::STATUS_ACTIVE)
    {
        $filter = ['email' => $email];
        if ($active) {
            $filter['active'] = $active;
        }
        return static::findOne($filter);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'active' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }
    
    /**
     * Get Status Name
     * @return string
     */
    public function getStatusName()
    {
        return self::$statuses[$this->active];
    }
    
    /**
     * Get groups of users by products activity
     * @return array
     */
    static public function getSubscribedGroups()
    {
        $groups = array(
            'buyed_all_active' => array(),
            'buyed_all_not_active' => array(),
            'buyed_active' => array(),
            'buyed_not_active' => array(),
            'nothing_buyed' => array(),
        );
        $products_ids = Product::find()->select('id')->where(['status' => 1])->asArray()->column();
        $users = self::find()
            ->select('user.id, user.name, user.email, user.phone,'
                    . 'GROUP_CONCAT(order.id) active_orders, '
                    . 'GROUP_CONCAT(o2.id) not_active_orders, '
                    . 'COUNT(order_to_product.product_id) active_products, '
                    . 'GROUP_CONCAT(op2.product_id) not_active_products, '
                    . 'GROUP_CONCAT(order_to_product.product_id) active_products')
            ->leftJoin('order', '`order`.`user_id` = `user`.`id` AND (order.created_at + 31536000) > UNIX_TIMESTAMP()')
            ->leftJoin('order_to_product', '`order_to_product`.`order_id` = `order`.`id`')
            
            ->leftJoin('order as o2', 'o2.`user_id` = `user`.`id` AND (o2.created_at + 31536000) < UNIX_TIMESTAMP()')
            ->leftJoin('order_to_product op2', 'op2.`order_id` = o2.`id`')
            ->where(['user.subscribe' => 1])
            ->groupBy(['user.id'])
            ->asArray()
            ->all();

        foreach($users as $u) {
            $active_products = explode(',',$u['active_products']);
            
            
            $all_active = count(array_diff($products_ids, array_unique($active_products))) == 0;

            $not_active_products = explode(',',$u['not_active_products']);
            $all_not_active = count(array_diff($products_ids, array_unique($not_active_products))) == 0;
            if (empty($u['active_orders']) && empty($u['not_active_orders'])) {
                $groups['nothing_buyed'][] = $u;
            } elseif ($all_active) {
                $groups['buyed_all_active'][] = $u;
            } elseif ($all_not_active) {
                $groups['buyed_all_not_active'][] = $u;
            } elseif (empty($active_products)) {
                $groups['buyed_not_active'][] = $u;
            } elseif (!empty($active_products)) {
                $groups['buyed_active'][] = $u;
            }
        }
        
        return $groups;
    }

    /**
     * Get array of elements by key
     * @param array $arr Array to search
     * @param string $key Key name
     * @return array
     */
    static public function getValues($arr, $key)
    {
        $r = [];
        foreach($arr as $a){
            if ($key == 'email') {
                $r[] = $a['name'].' <'.$a[$key].'>';
            } else {
                $r[] = $a[$key];
            }
        }
        
        return $r;
    }
    
    static public function getOS() 
    { 

        $user_agent = $_SERVER['HTTP_USER_AGENT'];

        $os_platform  = "Unknown OS Platform";

        $os_array     = array(
                              '/windows nt 10/i'      =>  'Windows 10',
                              '/windows nt 6.3/i'     =>  'Windows 8.1',
                              '/windows nt 6.2/i'     =>  'Windows 8',
                              '/windows nt 6.1/i'     =>  'Windows 7',
                              '/windows nt 6.0/i'     =>  'Windows Vista',
                              '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
                              '/windows nt 5.1/i'     =>  'Windows XP',
                              '/windows xp/i'         =>  'Windows XP',
                              '/windows nt 5.0/i'     =>  'Windows 2000',
                              '/windows me/i'         =>  'Windows ME',
                              '/win98/i'              =>  'Windows 98',
                              '/win95/i'              =>  'Windows 95',
                              '/win16/i'              =>  'Windows 3.11',
                              '/macintosh|mac os x/i' =>  'Mac OS X',
                              '/mac_powerpc/i'        =>  'Mac OS 9',
                              '/linux/i'              =>  'Linux',
                              '/ubuntu/i'             =>  'Ubuntu',
                              '/iphone/i'             =>  'iPhone',
                              '/ipod/i'               =>  'iPod',
                              '/ipad/i'               =>  'iPad',
                              '/android/i'            =>  'Android',
                              '/blackberry/i'         =>  'BlackBerry',
                              '/webos/i'              =>  'Mobile'
                        );

        foreach ($os_array as $regex => $value) {
            if (preg_match($regex, $user_agent)) {
                $os_platform = $value;
            }
        }

        return $os_platform;
    }

    static public function getBrowser() 
    {

        $user_agent = $_SERVER['HTTP_USER_AGENT'];

        $browser        = "Unknown Browser";

        $browser_array = array(
                                '/msie/i'      => 'Internet Explorer',
                                '/firefox/i'   => 'Firefox',
                                '/safari/i'    => 'Safari',
                                '/chrome/i'    => 'Chrome',
                                '/edge/i'      => 'Edge',
                                '/opera/i'     => 'Opera',
                                '/netscape/i'  => 'Netscape',
                                '/maxthon/i'   => 'Maxthon',
                                '/konqueror/i' => 'Konqueror',
                                '/mobile/i'    => 'Handheld Browser'
                         );

        foreach ($browser_array as $regex => $value) {
            if (preg_match($regex, $user_agent)) {
                $browser = $value;
            }
        }

        return $browser;
    }
    
    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Get Billing Information
     * @return UserBilling
     */
    public function getBilling()
    {
        return $this->hasOne(\common\models\UserBilling::className(), ['user_id' => 'id']);
    }
    
    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }
}

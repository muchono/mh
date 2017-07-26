<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "product_review".
 *
 * @property string $id
 * @property string $product_id
 * @property string $user_id
 * @property string $name
 * @property string $email
 * @property string $raiting
 * @property string $content
 * @property integer $active
 * @property date $created_at
 */
class ProductReview extends \yii\db\ActiveRecord
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 1;
    public $verifyCode;
    /**
     * statuses values
     */
    public static $statuses = array(
        0 => 'No',
        1 => 'Yes',
    );  
    
    /**
     * Base Product
     * @var Product 
     */
    private $product = null;

    /**
     * Get current product
     * @return Product
     */
    public function getProduct()
    {
        return $this->product;
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
     * Set product
     */
    public function setProduct(Product $product)
    {
        $this->product = $product;
    }    
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_review';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'name', 'email', 'content', 'raiting'], 'required'],
            [['verifyCode'], 'required', 'on' => 'front'],
            [['product_id', 'user_id', 'active'], 'integer'],
            [['content'], 'string', 'max' => 2000],
            [['raiting'], 'integer', 'max' => 5, 'min' => 1],
            [['name', 'email'], 'string', 'max' => 255],
            [['email'], 'email'],
            ['verifyCode', 'captcha', 'on' => 'front'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => 'Product ID',
            'user_id' => 'User ID',
            'name' => 'Name',
            'email' => 'Email',
            'raiting' => 'Raiting',
            'content' => 'Review',
            'active' => 'Reviewed',
            'verifyCode' => 'Verification Code',            
        ];
    }
    
    public function getAgo()
    {
        $diff = abs(time() - strtotime($this->created_at));

        $years = floor($diff / (365*60*60*24));
        $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
        $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
        
        if ($years) {
            $num = $years;
            $v = 'year';
        } elseif($months) {
            $num = $months;
            $v = 'month';
        } elseif($days) {
            $num = $days;
            $v = 'day';
        } else {
            $num = 1;
            $v = 'day';            
        }

        return $num . ' ' . $v . ($num > 1 ? 's' : '');
    }
}

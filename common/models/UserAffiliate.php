<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use common\models\UserAffiliatePay;

/**
 * This is the model class for table "userAffiliate".
 */

class UserAffiliate
{
    const GET_PARAM_NAME = 'me';
    const DEFAULT_COMISSION = 15;
    const MIN_TO_PAY = 50;
    
    /**
     * User
     * @var User
     */
    protected $user = null;
    
    /**
     * statuses values
     */
    public static $statuses = array(
        0 => 'Disabled',
        1 => 'Enabled',
    );    
    
    /**
     * Initialization
     * @param User $user
     */
    public function __construct($user) 
    {
        $this->user = $user;
    }
    
    /**
     * Add Apyment
     */
    public function addPayment($total)
    {
        $payment = new UserAffiliatePay();
        $payment->user_id = $this->user->id;
        $payment->total = (int) $total;
        return $payment->save();
    }
    
    /**
     * Get Affiliates information
     * @return array
     */
    public static function findAffiliates()
    {
        $users = User::find()->where(['affiliate' => 1, 'active' => 1])->all();
        $affiliates = [];
        foreach($users as $u) {
            $payed = $u->userAffiliate->getPaymentsAmount();
            $purchased = $u->userAffiliate->getUsersPurchasedTotal();
            $comission = floor($purchased * $u->affiliate_comission / 100  - $payed);

            $affiliates[] = [
                'user' => $u,
                'users_quantity' => count($u->userAffiliate->getUsers()),
                'comission' => $comission,
                'payed' => $payed ? $payed : 0,
                'purchased' => $purchased ? $purchased : 0,
            ];
            
        }

        usort($affiliates, (function ($a, $b) {
                if ($a['comission'] == $b['comission']) {
                    return 0;
                }
            return ($a['comission'] < $b['comission']) ? 1 : -1;
        }));
            
        return $affiliates;
    }
    
    /**
     * Set affiliate code by request
     */
    public static function setAffiliateCode()
    {
        if (!empty(Yii::$app->request->queryParams[self::GET_PARAM_NAME])) {
            Yii::$app->response->cookies->add(new \yii\web\Cookie([
                'name' => self::GET_PARAM_NAME,
                'value' => Yii::$app->request->queryParams[self::GET_PARAM_NAME],
                'expire'=> time() + 368 * 24 * 3600,
            ]));
        }
    }
    
    /**
     * Get affiliate user from cookie
     * @return int
     */
    public static function getCookieUserID() 
    {
        $v = Yii::$app->request->cookies->getValue(self::GET_PARAM_NAME, 0);
        $user_id = 0;
        
        if ($v) {
            if (false !== preg_match('/^[a-zA-Z$-]+([0-9]+)/', $v, $matches)) {
                $tmp = (int) $matches[1];
                if ($tmp) {
                    $affUser = \common\models\User::findOne($tmp);
                    if (!empty($affUser->id) && $affUser->affiliate) {
                        $user_id = $affUser->id;
                    }
                }
            }
        }
        
        return $user_id;
    }
    
    
    /**
     * Random string
     * @param type $length
     * @return string
     */
    public static function generateRandomString($length = 10) 
    {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ-$';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    } 
    
    /**
     * Generates affiliate code
     */
    public function getAffiliateCode()
    {
        return self::generateRandomString().$this->user->id;
    }

    /**
     * Get Affiliate Payments
     * @return string
     */
    public function getAffiliatePayments()
    {
        return UserAffiliatePay::find()->where(['user_id' => $this->user->id])->orderBy('id DESC')->all();
    }    
    
    public function getLink()
    {
        return self::GET_PARAM_NAME . '=' . $this->getAffiliateCode();
    }
    
    /**
     * Get Affiliate Payments
     * @return string
     */
    public function getPayments()
    {
        return UserAffiliatePay::find()->where(['user_id' => $this->user->id])->orderBy('id DESC')->all();
    }
    
    /**
     * Get Affiliate Payments Amount
     * @return string
     */
    public function getPaymentsAmount()
    {
        $p = UserAffiliatePay::find()->where(['user_id' => $this->user->id])->sum('total');
        return $p ? $p : 0;
    }    
    
    /**
     * Get Affiliate Users
     */
    public function getUsers()
    {
        return $this->user->find()->where(['driven_affiliate_id' => $this->user->id])->orderBy('name')->all();
    }
    
    /**
     * Get Affiliate Users Purchased
     */
    public function getUsersPurchasedTotal()
    {
        $r = [];
        foreach ($this->user->find()->select('id')->where(['driven_affiliate_id' => $this->user->id])->asArray()->all() as $d) {
            $r[] = $d['id'];
        }
        return Order::find()->where(['in', 'user_id', $r])->sum('total');
    }
    
    /**
     * Get Affiliate Status Name
     * @return string
     */
    public function getAffiliateStatusName()
    {
        return self::$statuses[$this->user->affiliate];
    }   

}
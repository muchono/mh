<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "order_to_product".
 *
 * @property string $id
 * @property string $order_id
 * @property string $product_id
 * @property double $price
 * @property integer $months
 * @property integer $expires
 * @property integer $five_days_notify
 * @property integer $expiration_notify
 */
class OrderToProduct extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order_to_product';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_id', 'product_id'], 'required'],
            [['order_id', 'product_id', 'months', 'expires', 'five_days_notify', 'expiration_notify', 'discount_id'], 'integer'],
            [['price', 'discount'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_id' => 'Order ID',
            'product_id' => 'Product ID',
            'price' => 'Price',
            'months' => 'Months',
            'expires' => 'Expires',
        ];
    }
    
    
    
    /**
     * Calc Expiration Date
     * @return integer
     */
    public function calcExpirationDate()
    {
        $time_from = self::getLatestExpirationDate($this->product_id, $this->user_id);
        $time = time();
        $time_from = $time_from > $time ? $time_from : $time;
        
        return strtotime("+".$this->months." years", $time_from);
    }
    
    /**
     * Get Expiration Date
     * @return integer
     */
    public function getExpirationDate()
    {
        return $this->expires;
    }
    
    /**
     * Days to expiration orders
     * @return integer
     */
    public static function getDaysToExpiration($days, $flag = '')
    {
        $sql = 'SELECT otp2.*
                FROM `order_to_product` otp1
                    LEFT JOIN `order_to_product` otp2 
                        ON otp1.user_id = otp2.user_id 
                        AND otp1.product_id = otp2.product_id 
                        AND otp2.expires = (
                            SELECT MAX(otp3.expires) 
                                FROM `order_to_product` otp3
                                WHERE otp3.user_id = otp2.user_id 
                                AND otp3.product_id = otp2.product_id
                        )
                WHERE datediff(NOW(), FROM_UNIXTIME(otp2.expires)) <= '. intval($days)
                .($flag  ? ' AND otp2.'.$flag.' = 0' : '')
                .' GROUP BY otp1.product_id, otp1.user_id';
        
        return self::findBySql($sql)->all();
    }
    
  
    /**
     * Get Latest Expiration Date
     * @return integer
     */
    static public function getLatestExpirationDate($product_id, $user_id)
    {
        return self::find()
            ->select('max(expires)')
            ->where(['product_id'=>$product_id, 'user_id'=>$user_id])
            ->scalar();
    }
    
    /**
     * Is Accessible
     * @return integer
     */
    static public function isAccessible($product_id, $user_id)
    {
        return $user_id && self::getLatestExpirationDate($product_id, $user_id) > time();
    }
    
    /**
     * Get Product
     * @return Product
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }
    
    /**
     * Get Order
     * @return Order
     */
    public function getOrder()
    {
        return $this->hasOne(Order::className(), ['id' => 'order_id']);
    }
}

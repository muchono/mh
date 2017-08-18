<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use common\models\OrderToProduct;
use common\models\User;

/**
 * This is the model class for table "order".
 *
 * @property string $id
 * @property integer $created_at
 * @property string $status
 * @property string $user_id
 * @property double $total
 * @property string $payment_method
 * @property string $payment_status
 * @property integer $transaction_id
 */
class Order extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = 1;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status', 'user_id', 'payment_method', 'payment_status'], 'required'],
            [['created_at', 'created_at', 'status', 'user_id', 'payment_status', 'transaction_id'], 'integer'],
            [['total'], 'number'],
            [['payment_method'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Order ID',
            'created_at' => 'Date',
            'status' => 'Status',
            'user_id' => 'User ID',
            'total' => 'Total',
            'payment_method' => 'Payment Method',
            'payment_status' => 'Payment Status',
            'transaction_id' => 'Transaction ID',
        ];
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
    
    /**
     * Create bt Cart information
     * @param array $params
     */
    public function createByCart($params)
    {
        if (!empty($params['items'])){
            $this->id = $params['id'];
            $this->total = $params['total'];
            $this->user_id = $params['products'][0]->user_id;
            $this->payment_method = $params['payment_method'];
            $this->payment_status = $params['payment_status'];
            $this->transaction_id = $params['transaction_id'];
            
            if (!$this->save()) {
                print_r($this->getErrors());
                exit;
            }
            
            $task_date = 0;
            foreach($params['products'] as $k=>$citem) {
                $o2p = new OrderToProduct;
                
                $o2p->order_id = $this->id;
                $o2p->product_id = $citem->product->id;
                $o2p->user_id = $this->user_id;
                $o2p->price = $params['prices'][$k];
                $o2p->months = $r['cart_items'][$k]->months;
                
                $o2p->expires = $o2p->calcExpirationDate();
                $o2p->save();
                
                $r['cart_items'][$k]->delete();
            }
            
            $user = User::findOne($this->user_id);
            $user->orders_num += 1;
            $user->update();
        }
    }
    
    /**
     * Generate Order ID
     * @return integer
     */
    static public function genID()
    {
        $last_id = Order::find()
            ->select('max(id)')
            ->scalar();
        return ($last_id ? $last_id : 15142/*any value for first order id*/) + rand(1,20);
    }
    
    /**
     * Get products
     * @return array
     */
    public function getProducts()
    {
        return $this->hasMany(Product::className(), ['id' => 'product_id'])
                    ->via('productIDs');
    }
    
    /**
     * Get related product IDs
     * @return array
     */
    public function getProductIDs()
    {
        return $this->hasMany(OrderToProduct::className(), ['order_id' => 'id']);
    }
    
    /**
     * Get user
     * @return User
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }    
}

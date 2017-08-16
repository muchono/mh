<?php

namespace common\models;

use common\models\Product;

use Yii;

/**
 * This is the model class for table "cart".
 *
 * @property string $id
 * @property string $user_id
 * @property string $product_id
 * @property string $months
 * @property string $timestamp
 */
class Cart extends \yii\db\ActiveRecord
{
    static public $months = [1,2,3];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cart';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'product_id', 'months'], 'required'],
            [['user_id', 'product_id', 'months'], 'integer'],
            [['timestamp'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'product_id' => 'Product ID',
            'months' => 'Months',
            'timestamp' => 'Timestamp',
        ];
    }
    
    /**
     * Count of cart items
     * @param integer $user_id User ID
     * @return integer
     */
    static public function getCountByUser($user_id)
    {
        return self::find()->where(['user_id' => $user_id])->count();
    }
    
    /**
     * Cart info
     * @param integer $user_id User ID
     * @return integer
     */
    static public function getInfo($user_id)
    {
        $r['count'] = self::getCountByUser($user_id);
        $items = self::find()->where(['user_id' => $user_id])->all();
        $r['products_list'] = $r['products'] = array();
        $r['amount'] = 0;
        $r['discount'] = 0;
        foreach($items as $k=>$i){
            $p = Product::findOne($i->product_id);
            if ($p->status){
                $r['products_list'][] = $p->id;
                $r['products'][$k] = $p;
                $r['prices'][$k] = $p->priceFinal * $i->months;
                $r['cart'][$k] = $i;
                $r['amount'] += $p->price * $i->months;
                $r['total'] += $r['prices'][$k];
                $r['discount'] +=  $p->price * $i->months - $r['prices'][$k];
            }
        }
       
        return $r;
    }
    
    /**
     * Is product in cart
     * @param integer $product_id
     * @param integer $user_id
     */
    static public function isAdded($product_id, $user_id = 0)
    {
        if (!$user_id){
            $user_id = Yii::$app->user->id;
        }
        
        return self::find()->where(['product_id' => $product_id, 'user_id' => $user_id])->count() != 0;
    }

}

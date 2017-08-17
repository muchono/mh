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
            [['order_id', 'product_id', 'months'], 'integer'],
            [['price'], 'number'],
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
        ];
    }
}

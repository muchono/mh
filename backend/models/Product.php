<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "product".
 *
 * @property string $id
 * @property string $title
 * @property double $price
 * @property string $status
 * @property string $orders
 */
class Product extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'price'], 'required'],
            [['price'], 'number'],
            [['status', 'orders'], 'integer'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'price' => 'Price',
            'status' => 'Status',
            'orders' => 'Orders',
        ];
    }
}

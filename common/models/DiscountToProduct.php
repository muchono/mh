<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "discount_to_product".
 *
 * @property string $id
 * @property string $discount_id
 * @property string $product_id
 */
class DiscountToProduct extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'discount_to_product';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['discount_id', 'product_id'], 'required'],
            [['discount_id', 'product_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'discount_id' => 'Discount ID',
            'product_id' => 'Product ID',
        ];
    }
}

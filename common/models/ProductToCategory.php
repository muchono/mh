<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "product_to_category".
 *
 * @property string $product_id
 * @property string $category_id
 */
class ProductToCategory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_to_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'category_id'], 'required'],
            [['product_id', 'category_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'product_id' => 'Product ID',
            'category_id' => 'Category ID',
        ];
    }
}

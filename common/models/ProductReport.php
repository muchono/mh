<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "product_report".
 *
 * @property string $id
 * @property string $product_id
 * @property string $title
 */
class ProductReport extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_report';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'title'], 'required'],
            [['id', 'product_id'], 'integer'],
            [['title'], 'string', 'max' => 255],
        ];
    }
    
    /**
     * Get product 
     * @return Product
     */
    public function getProduct()
    {
        return $this->hasOne(\common\models\Product::className(), ['id' => 'product_id']);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => 'Product ID',
            'title' => 'Title',
        ];
    }
}

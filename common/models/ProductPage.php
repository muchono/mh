<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "product_page".
 *
 * @property string $id
 * @property string $product_id
 * @property string $title
 * @property string $description
 * @property string $guide_description
 * @property string $list_description
 * @property string $feature1
 * @property string $feature2
 * @property string $feature3
 * @property string $feature4
 * @property string $feature5
 * @property string $content
 */
class ProductPage extends \yii\db\ActiveRecord
{
    /**
     * Base Product
     * @var Product 
     */
    private $product = null;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_page';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id','title','description','guide_description','list_description','content'], 'required'],
            [['product_id'], 'integer'],
            [['description', 'content'], 'string'],
            [['title'], 'string', 'max' => 255],
            [['guide_description', 'list_description', 'feature1', 'feature2', 'feature3', 'feature4', 'feature5'], 'string', 'max' => 500],
        ];
    }

    /**
     * Set product
     */
    public function setProduct(Product $product)
    {
        $this->product = $product;
    } 
    
    /**
     * Get current product
     * @return Product
     */
    public function getProduct()
    {
        return $this->product;
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
            'description' => 'Description',
            'guide_description' => 'Guide Description',
            'list_description' => 'List Description',
            'feature1' => 'Feature 1',
            'feature2' => 'Feature 2',
            'feature3' => 'Feature 3',
            'feature4' => 'Feature 4',
            'feature5' => 'Feature 5',
            'content' => 'Content',
        ];
    }
}

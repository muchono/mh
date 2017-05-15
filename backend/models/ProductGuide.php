<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "product_guide".
 *
 * @property string $id
 * @property string $product_id
 * @property string $title
 * @property string $status
 * @property string $about
 * @property string $order
 */
class ProductGuide extends \yii\db\ActiveRecord
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
        return 'product_guide';
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
    public function rules()
    {
        return [
            [['product_id', 'title', 'about'], 'required'],
            [['id', 'product_id', 'status', 'order'], 'integer'],
            [['about'], 'string'],
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
            'product_id' => 'Product ID',
            'title' => 'Title',
            'status' => 'Status',
            'about' => 'About',
            'order' => 'Order',
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
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'sortable' => [
                'class' => \kotchuprik\sortable\behaviors\Sortable::className(),
                'query' => self::find(),
            ],
        ];
    }    
}

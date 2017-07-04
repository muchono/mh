<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "product_review".
 *
 * @property string $id
 * @property string $product_id
 * @property string $user_id
 * @property string $name
 * @property string $email
 * @property string $raiting
 * @property string $content
 * @property integer $active
 */
class ProductReview extends \yii\db\ActiveRecord
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 1;
    
    /**
     * statuses values
     */
    public static $statuses = array(
        0 => 'No',
        1 => 'Yes',
    );  
    
    /**
     * Base Product
     * @var Product 
     */
    private $product = null;

    /**
     * Get current product
     * @return Product
     */
    public function getProduct()
    {
        return $this->product;
    }
    
    /**
     * Get Status Name
     * @return string
     */
    public function getStatusName()
    {
        return self::$statuses[$this->active];
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
    public static function tableName()
    {
        return 'product_review';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'active', 'name', 'email', 'content', 'raiting'], 'required'],
            [['product_id', 'user_id', 'active'], 'integer'],
            [['content'], 'string'],
            [['raiting'], 'integer', 'max' => 5, 'min' => 1],
            [['name', 'email'], 'string', 'max' => 255],
            [['email'], 'email'],
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
            'user_id' => 'User ID',
            'name' => 'Name',
            'email' => 'Email',
            'raiting' => 'Raiting',
            'content' => 'Content',
            'active' => 'Reviewed',
        ];
    }
}

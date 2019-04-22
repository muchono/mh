<?php

namespace common\models;

use Yii;
use yii\helpers\Url;

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
    
    public function getAboutCode()
    {
        $about = str_replace(array('&nbsp;'), array('####'), $this->about);
        $about = preg_replace("/<img .*>/", '<img class="img-fluid pull-center" src="'.Url::home().'img/demo_img.jpg">', $about);
        $about = preg_replace("/<a .*\>/", '<a href="#">', $about);
        
        $about = preg_replace_callback(
            '#.*?(<.+?>).*?#is',
            function ($matches) {
               $text = strip_tags($matches[0]);
               return preg_replace('/\w/i', '*', $text) . ($matches[1] ? $matches[1] : '');
            },
            $about);

        return str_replace('####', '&nbsp;', $about);
    }
    
    public function getAboutClear()
    {
        $about = preg_replace("/<img (.*)>/", '<img class="img-fluid pull-center" $1>', $this->about);
         return $about;
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
            'title' => 'Sub Title',
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

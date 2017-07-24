<?php

namespace common\models;

use Yii;
use himiklab\sortablegrid\SortableGridBehavior;
use common\models\ProductHref;
use common\models\ProductGuide;
use common\models\ProductReview;
use common\models\ProductPage;
use common\models\Discount;

/**
 * This is the model class for table "product".
 *
 * @property string $id
 * @property string $title
 * @property string $short_title
 * @property string $full_title
 * @property string $link_name
 * @property double $price
 * @property string $status
 * @property string $order
 */
class Product extends \yii\db\ActiveRecord
{
    /**
     * statuses values
     */
    public static $statuses = array(
        0 => 'Disabled',
        1 => 'Active',
    );
    
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
            [['title', 'price', 'short_title', 'full_title', 'link_name'], 'required'],
            [['price'], 'number'],
            [['status', 'order'], 'integer'],
            [['title', 'short_title', 'link_name'], 'string', 'max' => 255],
            [['full_title'], 'string', 'max' => 1000],
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
            'short_title' => 'Short Title',
            'full_title' => 'Full Title',
            'price' => 'Price',
            'status' => 'Status',
            'order' => 'Order',
            'link_name' => 'Link Name',
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if ($insert) {
            $this->status = 1;
        }
        return parent::beforeSave($insert);
    }
    
    
    /**
     * find Active
     * @return string
     */
    static public function findActive()
    {
        return self::find()->where(['status' => '1'])->orderBy('order');
    }
    
    /**
     * Get Discount
     * @return Discount
     */
    public function getDiscount()
    {
        $time = time();
         return Discount::find()
                ->innerJoin('discount_to_product', '`discount`.`id` = `discount_to_product`.`discount_id`')
                ->where(['<', 'date_from', $time])
                ->andWhere(['<', 'date_to', $time])
                ->andWhere(['product_id' => $this->id])
                ->orderBy('id DESC')
                ->one();
    }
    
    /**
     * Get Status Name
     * @return string
     */
    public function getStatusName()
    {
        return self::$statuses[$this->status];
    }
    
    /**
     * Get Hrefs
     * @return array
     */
    public function getHrefs()
    {
        return $this->hasMany(ProductHref::className(), ['product_id' => 'id']);
    }
    
    /**
     * Get Guide
     * @return array
     */
    public function getGuide()
    {
        return $this->hasMany(ProductGuide::className(), ['product_id' => 'id']);
    }
    
    /**
     * Get Page
     * @return ProductPage
     */
    public function getPage()
    {
        return ProductPage::find()->where(['product_id' => $this->id])->one();
    }
    
    /**
     * Get Reviews
     * @return array
     */
    public function getReviews()
    {
        return $this->hasMany(ProductReview::className(), ['product_id' => 'id']);
    }
    
    /**
     * Get ActiveReviews
     * @return array
     */
    public function getActiveReviews()
    {
        return $this->hasMany(ProductReview::className(), ['product_id' => 'id'])->where(['active' => 1]);
    }    
    
    /**
     * Get final price
     * @return float
     */
    public function getPriceFinal()
    {
        $price = $this->price;
        if ($this->discount){
            $price = round($price - $price * $this->discount->percent / 100);
        }
        return $price;
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

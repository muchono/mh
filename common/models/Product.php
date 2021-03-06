<?php

namespace common\models;

use Yii;
use himiklab\sortablegrid\SortableGridBehavior;
use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use common\models\ProductHref;
use common\models\ProductGuide;
use common\models\ProductReview;
use common\models\ProductPage;
use common\models\Discount;
use common\models\OrderToProduct;
use common\models\ProductReport;

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
 * @property string $questions
 * @property integer $links_available
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
            [['status', 'order', 'links_available'], 'integer'],
            [['title', 'short_title', 'link_name'], 'string', 'max' => 255],
            [['full_title'], 'string', 'max' => 1000],
            [['questions'], 'string', 'max' => 3000],
            [['categories'], 'safe'],

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
            'questions' => 'Questions',
            'links_available' => 'Show List Tab',
            'categories' => 'Post Tags',            
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function afterSave($insert, $changedAttributes)
    {
        $r = true;
        
        if ($insert){
            if (!$r){
                $this->addError('title', $mc->getErrorName());
                $r = false;
            }
        }else{
            if (!$r){
                $this->addError('title', $mc->getErrorName());
                $r = false;
            }
        }

        return parent::afterSave($insert, $changedAttributes);
    }
    
    public function delete()
    {
        parent::delete();
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
        $is_special_offer = null;
        
        if (Yii::$app->user->id) {
            $is_special_offer = Discount::isSpeacialAvailable(Yii::$app->user->id) && empty(Discount::getProductsNotInCart(Yii::$app->user->id));
        }
        if ($is_special_offer){
            $discount = Discount::findOne(Discount::SPECIAL40ID);
        } else {
            $discountQuery = Discount::find()
           ->innerJoin('discount_to_product', '`discount`.`id` = `discount_to_product`.`discount_id`')
           ->where(['status' => Discount::STATUS_ACTIVE])                 
           ->andWhere(['<', 'date_from', $time])
           ->andWhere(['>', 'date_to', $time])
           ->andWhere(['apply_code' => ''])
           ->andWhere(['product_id' => $this->id])
           ->andWhere(['!=', 'discount.id', Discount::SPECIAL40ID])
           ->orderBy('id DESC');
           
            if (Yii::$app->user->id && OrderToProduct::isAccessible($this->id, Yii::$app->user->id)) {
                $discountQuery->andWhere(['!=', 'percent', Discount::FREE]);
            }
        
           $discount = $discountQuery->one();
            
        }
        
         return $discount;
    }
    
    /**
     * Get categories
     * @return array
     */
    public function getCategories()
    {
        return $this->hasMany(PostCategory::className(), ['id' => 'category_id'])
                    ->via('productCategories');
    }
    
    /**
     * Get categories
     * @return array
     */
    public function getProductCategories()
    {
        return $this->hasMany(ProductToCategory::className(), ['product_id' => 'id']);
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
     * Get Hrefs Count
     * @return array
     */
    public function getHrefsCount()
    {
        $count = $this->getHrefs()->count();
        
        return $count ? $count : '';
    }
    
    /**
     * Get Guide
     * @return array
     */
    public function getGuide()
    {
        return $this->hasMany(ProductGuide::className(), ['product_id' => 'id'])->orderBy(['order' => SORT_ASC]);
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
     * Get Reports
     * @return array
     */
    public function getReports()
    {
        return $this->hasMany(ProductReport::className(), ['product_id' => 'id']);
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
     * Get Questions List
     * @return array
     */
    public function getQuestionsList()
    {
        $r = array();
        $this->questions = trim($this->questions);
        if ($this->questions){
            $r = explode(PHP_EOL, $this->questions);
        }
        return $r;
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
            'saveRelations' => [
                'class'     => SaveRelationsBehavior::className(),
                'relations' => ['categories']
            ],            
        ];
    }
}

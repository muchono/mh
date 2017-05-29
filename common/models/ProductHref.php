<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
//use lhs\Yii2SaveRelationsBehavior\SaveRelationsTrait;

require_once __DIR__ . DIRECTORY_SEPARATOR . '../../backend/extensions/SEOstats' . DIRECTORY_SEPARATOR . 'bootstrap.php';


/**
 * This is the model class for table "product_href".
 *
 * @property string $id
 * @property string $product_id
 * @property string $url
 * @property string $status
 * @property string $traffic
 * @property string $google_pr
 * @property string $alexa_rank
 * @property double $da_rank
 * @property string $about
 * @property string $example_url
 * @property string $type_links
 */
class ProductHref extends \yii\db\ActiveRecord
{
    /**
     * statuses values
     */
    public static $link_types = array(
        'follow' => 'Follow',
        'nofollow' => 'Nofollow',
        'redirect' => 'Redirect',
        'nolinks' => 'No Links',
    );
    
    /**
     * statuses values
     */
    public static $statuses = array(
        0 => 'Disabled',
        1 => 'Active',
    );
    
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
        return 'product_href';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'url', 'example_url','type_links', 'categories'], 'required'],
            [['product_id', 'status', 'alexa_rank'], 'integer'],
            [['da_rank'], 'number'],
            [['about'], 'string'],
            [[ 'url'], 'string', 'max' => 255],
            [['example_url', 'url'], 'url'],
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
            'product_id' => 'Product ID',
            'categories' => 'Categories',
            'url' => 'URL',
            'example_url' => 'Example URL',
            'status' => 'Status',
            'alexa_rank' => 'Alexa',
            'da_rank' => 'DA',
            'about' => 'Details',
            'type_links' => 'Type Links',
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if ($insert) {
            $seostats = new \SEOstats\SEOstats;

            $seostats->setUrl($this->url);
            
            $this->alexa_rank = \SEOstats\Services\Alexa::getGlobalRank();
            $this->da_rank = round(\SEOstats\Services\Mozscape::getDomainAuthority(), 2);
        }
        return parent::beforeSave($insert);
    }
    
    /**
     * @inheritdoc
     */    
    public function behaviors()
    {
        return [
            'saveRelations' => [
                'class'     => SaveRelationsBehavior::className(),
                'relations' => ['categories']
            ],
        ];
    }    
    
    /**
     * Get categories
     * @return array
     */
    public function getCategories()
    {
        return $this->hasMany(ProductHrefCategory::className(), ['id' => 'category_id'])
                    ->via('hREFCategories');
    }
    
    /**
     * Get categories
     * @return array
     */
    public function getHREFCategories()
    {
        return $this->hasMany(ProductHrefToCategory::className(), ['product_id' => 'id']);
    }
    
    /**
     * Get link type
     * @return string Link type name
     */
    public function getLinkType()
    {
        return self::$link_types[$this->type_links];
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
     * Get Status Name
     * @return string
     */
    public function getStatusName()
    {
        return self::$statuses[$this->status];
    }    
    /**
     * Set product
     */
    public function setProduct(Product $product)
    {
        $this->product = $product;
    }
    
    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }    
}

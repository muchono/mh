<?php

namespace backend\models;

use Yii;

require_once __DIR__ . DIRECTORY_SEPARATOR . '../extensions/SEOstats' . DIRECTORY_SEPARATOR . 'bootstrap.php';


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
 */
class ProductHref extends \yii\db\ActiveRecord
{
    /**
     *
     * @string Categories
     */
    public $categories;
    
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
            [['product_id', 'url', 'example_url','type_links','categories'], 'required'],
            [['product_id', 'status', 'alexa_rank'], 'integer'],
            [['da_rank'], 'number'],
            [['about'], 'string'],
            [['title', 'url'], 'string', 'max' => 255],
            [['example_url', 'url'], 'url'],
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
     * Get categories
     * @return array
     */
    public function getCategories()
    {
        return $this->hasMany(ProductHrefCategory::className(), ['id' => 'category_id'])
                    ->viaTable('product_href_to_category', ['product_id' => 'id']);
    }
    
    /**
     * Get current product
     * @return Product
     */
    public function getProduct()
    {
        return $this->product;
    }
    
	public function getStats()
	{
            $seostats = new \SEOstats\SEOstats;

            $seostats->setUrl('http://google.com');
            $this->alexa_rank = \SEOstats\Services\Alexa::getGlobalRank();
            $this->da_rank = round(\SEOstats\Services\Mozscape::getDomainAuthority(), 2);
            
            print $this->alexa_rank;
            print '<br/>';
            print $this->da_rank;
            //print_r($this);
	}
    
    /**
     * Set product
     */
    public function setProduct(Product $product)
    {
        $this->product = $product;
    }
}

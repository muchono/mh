<?php

namespace common\models;

use Yii;
use yii\behaviors\AttributeBehavior;
use common\models\DiscountToProduct;
use common\models\DiscountQuery;
use common\models\User;
use common\models\Cart;
use common\models\Product;
use yii\behaviors\BlameableBehavior;
use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;

/**
 * This is the model class for table "discount".
 *
 * @property string $id
 * @property integer $date_from
 * @property integer $date_to
 * @property string $title
 * @property string $status
 * @property string $percent
 * @property string $file1
 * @property string $file2
 */
class Discount extends \yii\db\ActiveRecord
{
    
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 1;
    const SPECIAL40ID = 10;
    const SPECIAL_AVAILABLE_TIME = 86400;//24 hours
    public $imageFile1;
    
    public $imageFile2;
    /**
     * statuses values
     */
    public static $statuses = array(
        0 => 'Disabled',
        1 => 'Active',
    );


    public static function find()
    {
        return new DiscountQuery(get_called_class());
    }    
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'discount';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['date_from', 'date_to', 'title', 'status', 'percent', 'products'], 'required'],
            [['file1','file2'], 'string'],
            [['status'], 'integer'],
            [['percent'], 'integer', 'max' => 100, 'min' => 1],
            [['title'], 'string', 'max' => 255],
            [['date_from', 'date_to'], 'date', 'format' => 'php:d-m-Y'],
            [['imageFile1', 'imageFile2'], 'file', 'skipOnEmpty' => !$this->isNewRecord, 'extensions' => 'png,jpg,jpeg,gif'],
            [['products'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date_from' => 'Date From',
            'date_to' => 'Date To',
            'title' => 'Title',
            'status' => 'Status',
            'percent' => 'Percent',
            'imageFile1' => 'Image 1',
            'imageFile2' => 'Image 2',
            'file1' => 'Image 1',
            'file2' => 'Image 2',
        ];
    }
    
    /**
     * @inheritdoc
     */    
    public function behaviors()
    {
        return [
            'saveRelations' => [
                'class'     => SaveRelationsBehavior::className(),
                'relations' => ['products']
            ],
        ];
    } 
    
    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        $this->date_from = strtotime($this->date_from);
        $this->date_to = strtotime($this->date_to);
        
        return true;
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
     * Check if special offer is not expired
     * @param integer $user_id
     * @return boolean
     */
    public static function isSpeacialAvailable($user_id)
    {
        $user = User::findOne($user_id);
        return (time() - $user->created_at < self::SPECIAL_AVAILABLE_TIME);
    }

    /**
     * Get all available products` IDs that are not in cart
     * @param integer $user_id
     * @return array
     */
    public static function getProductsNotInCart($user_id) {
        $cart_products = Cart::find()->select('product_id')->where(['user_id' => $user_id])->asArray()->column();
        $productsIDs = Product::find()->select('id')->where(['status' => '1'])->asArray()->column();
        return array_diff($productsIDs, $cart_products);
    }
    
    /**
     * Modify dates view
     */
    public function modifyDatesView()
    {
        $this->date_from = date('d-m-Y', $this->date_from);
        $this->date_to = date('d-m-Y', $this->date_to);
    }
    
    /**
     * Get Images Directory
     * @return string
     */
    public function getImagesRootDir()
    {
        return Yii::getAlias('@frontend') . '/web/images/discount/';
    }
    
    /**
     * Get products
     * @return array
     */
    public function getProducts()
    {
        return $this->hasMany(Product::className(), ['id' => 'product_id'])
                    ->via('productIDs');
    }
    
    /**
     * Get related product IDs
     * @return array
     */
    public function getProductIDs()
    {
        return $this->hasMany(DiscountToProduct::className(), ['discount_id' => 'id']);
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
     * Save files
     */
    public function saveFiles()
    {
        $fields_update = [];
        
        foreach ([1,2] as $i) {
            $tmp = 'file'.$i;
            $tmp2 = 'imageFile'.$i;
            if ($this->$tmp2) {
                $this->$tmp = 'discount_'.$tmp.'_' . $this->id . '.' . $this->$tmp2->extension;  
                $this->$tmp2->saveAs($this->imagesRootDir.$this->$tmp);
                $fields_update[] = $tmp;
            }
        }

        if ($fields_update)
        {
            $this->save(false, $fields_update);
        }
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

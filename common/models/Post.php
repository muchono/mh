<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;

/**
 * This is the model class for table "post".
 *
 * @property string $id
 * @property string $title
 * @property string $image
 * @property string $content
 * @property string $meta_description
 * @property string $meta_keywords
 * @property string $url_anckor
 * @property string $views
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $sent
 * @property string $active
 */
class Post extends \yii\db\ActiveRecord
{
    public $imageFile;
    public $imageFileAvatar;
     
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 1;
    
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
        return 'post';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'categories'], 'required'],
            [['content', 'image','author_bio','avatar_image'], 'string'],
            [['views', 'created_at', 'updated_at', 'sent', 'active'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['meta_description', 'meta_keywords'], 'string', 'max' => 500],
            [['url_anckor','author_name'], 'string', 'max' => 100],
            [['categories'], 'safe'],
            [['imageFile'], 'file', 'skipOnEmpty' => !$this->isNewRecord, 'extensions' => 'png,jpg,jpeg,gif'],
            [['imageFileAvatar'], 'file', 'extensions' => 'png,jpg,jpeg,gif'],
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
            'categories' => 'Tags',
            'image' => 'Image',
            'content' => 'Content',
            'meta_description' => 'Post Description',
            'meta_keywords' => 'Meta Keywords',
            'url_anckor' => 'Url Anckor',
            'views' => 'Views',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'sent' => 'Sent',
            'active' => 'Active',
            'author_name' => 'Author Name',
            'author_bio' => 'Author Bio',
            'avatar_image' => 'Load Avatar',
            'imageFileAvatar' => 'Load Avatar',
        ];
    }
    
    /**
     * @inheritdoc
     */    
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
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
        return $this->hasMany(PostCategory::className(), ['id' => 'category_id'])
                    ->via('postCategories');
    }
    
    /**
     * Get categories
     * @return array
     */
    public function getPostCategories()
    {
        return $this->hasMany(PostToCategory::className(), ['post_id' => 'id']);
    }
    
    /**
     * Get Images Directory
     * @return string
     */
    public function getImagesRootDir()
    {
        return Yii::getAlias('@frontend') . '/web/images/blog/';
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
     * Get Author Name
     * @return string
     */
    public function getAuthor()
    {
        return $this->author_name ? $this->author_name : 'MarketingHack Team';
    }    
}

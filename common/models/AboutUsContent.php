<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "about_us_content".
 *
 * @property string $id
 * @property string $title
 * @property string $image
 * @property string $content
 * @property string $href
 * @property string $author_name
 * @property string $author_bio
 */
class AboutUsContent extends \yii\db\ActiveRecord
{
    public $imageFile;    
    public static $hrefs = array(
        'type1' => 'Press About Us',
        'type2' => 'Think About Us',
    );
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'about_us_content';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'href', 'content'], 'required'],
            [['content'], 'string'],
            [['title', 'href','author_name','author_bio','image'], 'string', 'max' => 255],
            [['imageFile'], 'file', 'skipOnEmpty' => !$this->isNewRecord, 'extensions' => 'png,jpg,jpeg,gif'],            
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
            'image' => 'Image',            
            'content' => 'Content',
            'href' => 'Type',
            'author_name' => 'Author Name',
            'author_bio' => 'Author Info',
        ];
    }
    
    public function getHrefName()
    {
        return self::$hrefs[$this->href];
    }
    
    /**
     * Get Images Directory
     * @return string
     */
    public function getImagesRootDir()
    {
        return Yii::getAlias('@front_html') . '/images/aboutus/';
    }    
}

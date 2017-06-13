<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "about_us_content".
 *
 * @property string $id
 * @property string $title
 * @property string $content
 * @property string $href
 */
class AboutUsContent extends \yii\db\ActiveRecord
{
    public static $hrefs = array(
        'type1' => 'Type1',
        'type2' => 'Type2',
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
            [['title', 'href'], 'string', 'max' => 255],
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
            'content' => 'Content',
            'href' => 'Type',
        ];
    }
    
    public function getHrefName()
    {
        return self::$hrefs[$this->href];
    }
}

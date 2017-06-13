<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "pages_content".
 *
 * @property string $id
 * @property string $name
 * @property string $content
 * @property string $href
 * @property integer $static
 * @property string $submenu
 */
class PagesContent extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pages_content';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'content'], 'required'],
            [['content'], 'string'],
            [['static'], 'integer'],
            [['submenu'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'content' => 'Content',
            'href' => 'Href',
            'static' => 'Static',
            'submenu' => 'Submenu',
        ];
    }
}

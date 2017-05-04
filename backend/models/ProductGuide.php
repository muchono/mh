<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "product_guide".
 *
 * @property string $id
 * @property string $product_id
 * @property string $title
 * @property string $url
 * @property string $status
 * @property string $traffic
 * @property string $google_pr
 * @property string $alexa_rank
 * @property double $da_rank
 * @property string $about
 */
class ProductGuide extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_guide';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'product_id', 'title', 'url'], 'required'],
            [['id', 'product_id', 'status', 'traffic', 'google_pr', 'alexa_rank'], 'integer'],
            [['da_rank'], 'number'],
            [['about'], 'string'],
            [['title', 'url'], 'string', 'max' => 255],
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
            'title' => 'Title',
            'url' => 'Url',
            'status' => 'Status',
            'traffic' => 'Traffic',
            'google_pr' => 'Google Pr',
            'alexa_rank' => 'Alexa Rank',
            'da_rank' => 'Da Rank',
            'about' => 'About',
        ];
    }
}

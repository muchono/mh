<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "faq_to_category".
 *
 * @property string $faq_id
 * @property string $category_id
 * @property string $id
 */
class FaqToCategory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'faq_to_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['faq_id', 'category_id'], 'required'],
            [['faq_id', 'category_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'faq_id' => 'Faq ID',
            'category_id' => 'Category ID',
            'id' => 'ID',
        ];
    }
}

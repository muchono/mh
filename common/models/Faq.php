<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;

/**
 * This is the model class for table "faq".
 *
 * @property string $id
 * @property string $title
 * @property string $answer
 * @property integer $popular_question
 * @property integer $order
 */
class Faq extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'faq';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'answer', 'categories'], 'required'],
            [['answer'], 'string'],
            [['popular_question', 'order'], 'integer'],
            [['title'], 'string', 'max' => 255],
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
            'categories' => 'Categories',            
            'title' => 'Title',
            'answer' => 'Answer',
            'popular_question' => 'Popular Question',
            'order' => 'Order',
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
        return $this->hasMany(FaqCategory::className(), ['id' => 'category_id'])
                    ->via('faqCategories');
    }
    
    /**
     * Get categories
     * @return array
     */
    public function getFaqCategories()
    {
        return $this->hasMany(FaqToCategory::className(), ['faq_id' => 'id']);
    }
}

<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "user_mark".
 *
 * @property string $id
 * @property string $user_id
 * @property string $href_id
 */
class UserMark extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_mark';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'href_id'], 'required'],
            [['user_id', 'href_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'href_id' => 'Href ID',
        ];
    }
}

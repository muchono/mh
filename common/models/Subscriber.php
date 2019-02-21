<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "subscriber".
 *
 * @property string $id
 * @property string $name
 * @property string $email
 * @property string $created_at
 * @property string $ip
 * @property integer $active
 */
class Subscriber extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'subscriber';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email', 'ip'], 'required'],
            [['name'], 'string'],
            [['created_at', 'ip', 'active'], 'integer'],
            [['email'], 'email'],
            ['email', 'unique', 'message'=>'Email subscribed.'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'email' => 'Email',
            'created_at' => 'Created At',
            'ip' => 'Ip',
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function afterSave($insert, $changedAttributes)
    {
        $r = true;
        
        return parent::afterSave($insert, $changedAttributes);
    }
    
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }    
}

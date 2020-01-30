<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "user_affiliate_pay".
 *
 * @property string $id
 * @property string $user_id
 * @property double $total
 * @property string $created_at
 */
class UserAffiliatePay extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_affiliate_pay';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'total'], 'required'],
            [['user_id'], 'integer'],
            [['total'], 'number'],
            [['created_at'], 'safe'],
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
            'total' => 'Total($)',
            'created_at' => 'Date',
        ];
    }
}

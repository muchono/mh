<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "login_case".
 *
 * @property string $id
 * @property string $auth_key
 * @property string $user_id
 * @property string $case
 * @property integer $created_at
 */
class LoginCase extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'login_case';
    }

    /**
     * Add login case
     * @param integer $user_id
     * @param string $case
     * @return \frontend\models\LoginCase
     */
    public static function addCase($user_id, $case)
    {
        $lc = new LoginCase();
        $lc->auth_key = time().Yii::$app->security->generateRandomString();
        $lc->user_id = $user_id;
        $lc->case = $case;
        $lc->created_at = time();
        
        $lc->save();
        
        return $lc;
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['auth_key', 'user_id', 'created_at'], 'required'],
            [['user_id', 'created_at'], 'integer'],
            [['auth_key'], 'string', 'max' => 50],
            [['case'], 'string', 'max' => 500],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'auth_key' => 'Auth Key',
            'user_id' => 'User ID',
            'case' => 'Case',
            'created_at' => 'Created At',
        ];
    }
}

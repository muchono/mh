<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "forgot_link".
 *
 * @property string $id
 * @property string $auth_key
 * @property string $user_id
 * @property string $active
 * @property integer $created_at
 */
class ForgotLink extends \yii\db\ActiveRecord
{
    CONST LIFE_TIME = 3600; //lifetime in seconds
    
    /**
     * Create Link
     * @param integer $user_id User ID
     * @return \app\models\ForgotLink
     */
    static public function create($user_id)
    {
        $link = new ForgotLink;
        $link->user_id = (int) $user_id;
        $link->created_at = time();
        $link->auth_key = sha1($this->created_at.$this->user_id, true);
        $link->save();
        
        return $link;
    }
    
    /**
     * If available
     * @return type
     */
    public function isAvailable()
    {
        return $this->active && (time() - $this->created_at) < self::LIFE_TIME;
    }
    
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'forgot_link';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['auth_key', 'user_id', 'created_at'], 'required'],
            [['user_id', 'active', 'created_at'], 'integer'],
            [['auth_key'], 'string', 'max' => 32],
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
            'active' => 'Active',
            'created_at' => 'Created At',
        ];
    }
}

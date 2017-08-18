<?php
namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\base\InvalidParamException;
use common\models\User;

/**
 * Password reset form
 */
class ChangePasswordForm extends Model
{
    public $old_password;
    public $new_password;
    public $confirm_password;

    /**
     * @var \common\models\User
     */
    private $_user;

    /**
     * Creates a form model.
     *
     * @param array $config name-value pairs that will be used to initialize the object properties
     */
    public function __construct($config = [])
    {
        $this->_user = User::findOne(Yii::$app->user->id);

        parent::__construct($config);
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'old_password' => 'Old Password',
            'new_password' => 'New Password',
            'confirm_password' => 'Confirm New Password',
        ];
    }
    
    public function validatorCheckOld($attribute, $params, $validator)
    {
        if ($this->$attribute && !$this->_user->validatePassword($this->$attribute)) {
            $this->addError($attribute, 'Old Password is incorrect.');
        }
    }
    
    public function validatorConfirmPassword($attribute, $params, $validator)
    {
        if ($this->$attribute != $this->new_password) {
            $this->addError($attribute, 'Confirm New Password is incorrect.');
        }
    }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['old_password','new_password','confirm_password'], 'required'],
            [['old_password'], 'validatorCheckOld'],
            [['confirm_password'], 'validatorConfirmPassword'],
            ['new_password', 'string', 'min' => 7],
        ];
    }

    /**
     * Save password.
     *
     * @return bool if password was reset.
     */
    public function savePassword()
    {
        $user = $this->_user;
        $user->setPassword($this->new_password);
        return $user->save(false);
    }
}

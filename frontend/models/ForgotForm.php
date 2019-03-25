<?php
namespace frontend\models;

use Yii;
use yii\base\Model;

use common\models\User;

/**
 * Login form
 */
class ForgotForm extends Model
{
    public $email;
    public $verifyForgotCode;
    private $_user;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // email and password are both required
            [['verifyForgotCode'], 'required'],
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],            
            ['email', 'validateEmail'],
            
            ['verifyForgotCode', 'captcha'],            
        ];
    }

    /**
     * Validates 
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validateEmail($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user) {
                $this->addError($attribute, 'Incorrect email.');
            } elseif (!$user->active) {
                $this->addError($attribute, 'Account deactivated.');
            }
        }
    }
    
    /**
     * Finds user by [[email]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === null) {
            $this->_user = User::findByEmail($this->email);
        }

        return $this->_user;
    }
    
}
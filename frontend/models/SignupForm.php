<?php
namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\helpers\Url;

use common\models\User;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $name;
    public $email;
    public $password;
    public $user = null;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['name', 'trim'],
            ['name', 'required'],
            ['name', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
        
        $this->user = new User();
        $this->user->name = $this->name;
        $this->user->email = $this->email;
        
        //temporary
        $this->user->active = $this->user->registration_confirmed = 1;
        
        $this->user->setPassword($this->password);
        $this->user->generateAuthKey();
        
        return $this->user->save() ? $this->user : null;
    }
    
    /**
     * Sends an email to the specified email address using the information collected by this model.
     * @return bool whether the email was sent
     */
    public function sendEmail()
    {
        $link = Url::to(['site/registration', 'code' => md5($this->user->created_at)], true);
        $body = 'Please confirm your registration by the following link:<br/>';
        $body .= '<a href="'.$link.'">'.$link.'</a>';
        
        return Yii::$app->mailer->compose()
            ->setTo($this->email)
            ->setFrom(Yii::$app->params['adminEmail'])
            ->setSubject('Registration confirmation')
            ->setTextBody($body)
            ->send();
    }
}

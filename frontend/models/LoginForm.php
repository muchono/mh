<?php
namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\helpers\Url;

use common\models\User;

/**
 * Login form
 */
class LoginForm extends Model
{
    const MAX_BLOCK_ATTEMPTS = 3;

    public $email;
    public $password;
    public $rememberMe = true;

    private $_user;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // email and password are both required
            [['email', 'password'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect email or password.');
            } elseif (!$user->registration_confirmed) {
                $this->addError($attribute, 'Registration has not finished.');
            }elseif ($user->blocked) {
                if ($user->block_amount <= self::MAX_BLOCK_ATTEMPTS) {
                    $this->addError($attribute, 'Account was blocked. Check your e-mail for details.');
                } else {
                    $this->addError($attribute, 'Account was blocked. Contact our support.');
                }
            }elseif (!$user->active) {
                $this->addError($attribute, 'Account deactivated.');
            }elseif($user->active_at 
                    && ip2long(Yii::$app->request->userIP) != $user->active_ip
                    && (time() - $user->active_at) < 24 * 3600 /* 24 hours */) {
                $user->active = 0;
                $user->blocked = time();
                $user->block_amount++;
                $user->save();
                
                if ($user->block_amount <= self::MAX_BLOCK_ATTEMPTS) {
                    $body = Yii::$app->controller->renderPartial('@app/views/mails/suspicious_activity_in_account.php', [
                        'user' => $user,
                        'link' => Url::to(['site/unblock', ['key' => md5($user->blocked), 'u' => $user->id]], true),
                        'ip' => Yii::$app->request->userIP,
                        'os' => User::getOs(),
                        'browser' => User::getBrowser(),
                    ]);
                    //send to user
                    Yii::$app->mailer->compose()
                                ->setTo($user->email)
                                ->setFrom(Yii::$app->params['adminEmail'])
                                ->setSubject('Suspicious activity in your account')
                                ->setHtmlBody($body)
                                ->send();

                    $this->addError($attribute, 'Suspicious activity. Account was blocked. Check your e-mail for details.');
                } else {
                    $this->addError($attribute, 'Account is blocked. Contact our support.');
                }
            }
        }
    }

    /**
     * Logs in a user using the provided email and password.
     *
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            $user = $this->getUser();
            $user->active_ip = ip2long(Yii::$app->request->userIP);
            $user->active_at = time();
            $user->save();
            return Yii::$app->user->login($user, $this->rememberMe ? 3600 * 24 * 30 : 0);
        } else {
            return false;
        }
    }

    /**
     * Finds user by [[email]]
     *
     * @return User|null
     */
    protected function getUser()
    {
        if ($this->_user === null) {
            $this->_user = User::findByEmail($this->email, '');
        }

        return $this->_user;
    }
}
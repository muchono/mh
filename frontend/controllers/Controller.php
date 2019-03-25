<?php

namespace frontend\controllers;

use Yii;
use yii\helpers\Url;
use common\models\Discount;
use common\models\User;
use frontend\models\SignupForm;
use frontend\models\LoginForm;
use frontend\models\ForgotForm;


use common\models\Cart;

class Controller extends \yii\web\Controller
{
    public function beforeAction($action)
    {
        $this->view->params['head_offer'] = Yii::$app->session->get('head_offer_closed') ? null : Discount::find()->latest();
        $this->view->params['cart_items'] = !Yii::$app->user->isGuest ? Cart::getCountByUser(Yii::$app->user->id) : 0;
        $this->actionSignup();
        $this->actionLogin();
        $this->actionForgot();
        
        $link = ForgotLink::create(5);
        
        print $link->auth_key;
        exit;
        
        return parent::beforeAction($action);
    }  
    
    static public function isSubscribed()
    {
        return Yii::$app->session['subscribed'];
    }
    
    
    /**
     * Forgot
     *
     * @return mixed
     */
    public function actionForgot()
    {
        $model = new ForgotForm();
        if (Yii::$app->request->post('forgot')) {
            if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                $user = $model->getUser();
                $forgotLink = ForgotLink::create($user->id);

                $body = Yii::$app->controller->renderPartial('@app/views/mails/.php', [
                    'link' => Url::to(['site/forgot', ['key' => $forgotLink->auth_key, 'u' => $user->id]], true),
                ]);
                //send to user
                Yii::$app->mailer->compose()
                            ->setTo($user->email)
                            ->setFrom(Yii::$app->params['adminEmail'])
                            ->setSubject('MarketingHack Account Operation')
                            ->setTextBody($body)
                            ->send();                
                echo 'The instructions were sent to your e-mail!';
                exit;
            }
        }
        
        $this->view->params['user_forgot'] = $model;
    }
    
    /**
     * Login
     *
     * @return mixed
     */
    public function actionLogin()
    {
        $model = new LoginForm();
        if (Yii::$app->request->post('login')) {
            if ($model->load(Yii::$app->request->post()) && $model->login()) {
                echo 'Redirecting <script>location.reload();</script>';
                exit;
            }
        }
        
        $this->view->params['user_login'] = $model;
    }

    
    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();

        if (Yii::$app->request->post('register') && $model->load(Yii::$app->request->post())) {
            
            if ($user = $model->signup()) {
                $model->sendEmail();
                echo '<script>location.replace("'.Url::to(['result/reg-finish', 'email' => $model->email]).'");</script>';
                exit;
                /**
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }**/
            }
        } 

        $this->view->params['user'] = $model;
    }

}

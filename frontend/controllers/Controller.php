<?php

namespace frontend\controllers;

use Yii;
use yii\helpers\Url;
use common\models\Discount;
use common\models\User;
use frontend\models\SignupForm;
use frontend\models\LoginForm;
use common\models\Cart;

use common\models\MailchimpMirror;

class Controller extends \yii\web\Controller
{
    public function beforeAction($action)
    {
        $this->view->params['head_offer'] = Yii::$app->session->get('head_offer_closed') ? null : Discount::find()->latest();
        $this->view->params['cart_items'] = !Yii::$app->user->isGuest ? Cart::getCountByUser(Yii::$app->user->id) : 0;
        $this->actionSignup();
        $this->actionLogin();
        
        return parent::beforeAction($action);
    }  
    
    static public function isSubscribed()
    {
        return Yii::$app->session['subscribed'];
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
                //$model->sendEmail();
                
                $mc = new MailchimpMirror();
                $mc->userAdd($user);
                
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

<?php

namespace frontend\controllers;

use Yii;
use yii\helpers\Url;
use yii\web\View;
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
        $this->view->params['head_offer'] = Yii::$app->session->get('head_offer_closed') ? null : Discount::findShowable()->latest();
        $this->view->params['offer_menu'] = Discount::findShowable()->count();
        $this->view->params['cart_items'] = !Yii::$app->user->isGuest ? Cart::getCountByUser(Yii::$app->user->id) : 0;
            
        $this->actionSignup();
        $this->actionLogin();
        $this->actionForgot();

        if (!Yii::$app->user->isGuest) {
            $user = User::findOne(Yii::$app->user->id);
            $user->active_at = time();
            $user->save();
        }

        $this->view->registerJs(
            "var WEB_PATH = '".URL::base(true)."/'",
            View::POS_HEAD,
            'global-script'
         );
        
        
        if (!empty(Yii::$app->params['meta'][$action->controller->id.'/'.$action->id])) {
            $meta = Yii::$app->params['meta'][$action->controller->id.'/'.$action->id];
            if (!empty($meta['title'])) {
                $this->view->title = $meta['title'];
            }
            if (!empty($meta['keywords'])) {
                \Yii::$app->view->registerMetaTag([
                    'name' => 'keywords',
                    'content' => $meta['title']
                ]);                
            }
            if (!empty($meta['description'])) {
                \Yii::$app->view->registerMetaTag([
                    'name' => 'description',
                    'content' => $meta['description']
                ]);                
            }            
        }        
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
                $user->generatePasswordResetToken();
                $user->save();
                
                $body = Yii::$app->controller->renderPartial('@app/views/mails/password_reset.php', [
                    'link' => Url::to(['site/restore', 'key' => $user->password_reset_token, 'u' => $user->id], true),
                ]);
                //send to user
                Yii::$app->mailer->compose()
                            ->setTo($user->email)
                            ->setFrom(Yii::$app->params['adminEmail'])
                            ->setSubject('Password Reset - MarketingHack.net')
                            ->setHtmlBody($body)
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
                echo 'Redirecting <script>location.replace("'.Url::to(['content/']).'");</script>';
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

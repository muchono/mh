<?php

namespace frontend\controllers;

use Yii;
use common\models\Discount;
use frontend\models\SignupForm;

class Controller extends \yii\web\Controller
{
    public function beforeAction($action)
    {
        $this->view->params['head_offer'] = Yii::$app->session->get('head_offer_closed') ? null : Discount::find()->latest();
        $this->actionSignup();
        
        return parent::beforeAction($action);
    }  
    
    static public function isSubscribed()
    {
        return Yii::$app->session['subscribed'];
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
                /**
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }**/
            }
        }

        $this->view->params['user'] = $model;
    }

}

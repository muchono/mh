<?php

namespace frontend\controllers;

use Yii;


class ResultController extends \frontend\controllers\Controller
{
    public $layout = 'result';
    
    public function actionRegFinish()
    {
        return $this->render('regfinish',[
            'email' => Yii::$app->request->get('email'),
        ]);
    }
}

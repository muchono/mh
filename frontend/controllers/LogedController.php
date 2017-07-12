<?php

namespace frontend\controllers;
use common\models\Product;
use common\models\ProductHref;
use common\models\ProductGuide;

class LogedController extends \yii\web\Controller
{
    public $layout = 'logged';
    
    public function beforeAction($action)
    {
        
        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        $user_id = 1;
        $this->view->params['products'] = Product::findActive()->all();      
        $this->view->params['selectd_product'] = $this->view->params['products'][0];
        return $this->render('index');
    }

}

<?php

namespace frontend\controllers;

use Yii;
use common\models\Cart;
use common\models\Product;
use yii\filters\AccessControl;

class CheckoutController extends \frontend\controllers\Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],                    
                ],
            ],             
        ];
    }
    
    /**
     * Displays homepage.
     * @return mixed
     */
    public function actionIndex()
    {
        $cartInfo = Cart::getInfo(Yii::$app->user->id);
        $products = Product::findActive()->all();
        return $this->render('index', array(
            'products' => $products,
            'cartInfo' => $cartInfo,
        ));
    }
}

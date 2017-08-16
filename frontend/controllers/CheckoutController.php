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
        $products = Product::findActive()->andWhere(['not in', 'id', $cartInfo['products_list']])->all();
        return $this->render('index', array(
            'products' => $products,
            'cartInfo' => $cartInfo,
        ));
    }
    
    /**
     * Get Cart Items
     *
     * @return mixed
     */
    public function actionGetList()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        
        $r = array('success' => 1);
        $cartInfo = Cart::getInfo(Yii::$app->user->id);
        $r['items_amount'] = $cartInfo['amount'];
        $r['content'] = $this->renderPartial('_items',[
           'cartInfo' => $cartInfo,
        ]);
        return $r;
    }    
}

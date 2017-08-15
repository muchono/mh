<?php

namespace frontend\controllers;

use Yii;
use common\models\Cart;
use common\models\Product;
use yii\filters\AccessControl;

class CartController extends \frontend\controllers\Controller
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
                        'actions' => ['add'],
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],                    
                ],
            ],             
        ];
    }
    
    public function actionAdd()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $r = ['result' => 0, 'show_signup' => 0];
        
        if (Yii::$app->user->isGuest){
            $r['show_signup'] = 1;
        } elseif (Yii::$app->request->isAjax 
               && Yii::$app->request->post('product_id')) {
                $product = Product::findOne(Yii::$app->request->post('product_id'));
             if ($product && $product->status){
                $months = in_array(Yii::$app->request->post('months'), Cart::$months) ? Yii::$app->request->post('months') : 1;
                $cart = new Cart;
                $cart->product_id = $product->id;
                $cart->months = $months;
                $cart->user_id = Yii::$app->user->id;
                
                if (Cart::isAdded($product->id, Yii::$app->user->id)
                        || $cart->save()) {
                    $r['result'] = 1;
                    $r['cart_items_count'] = Cart::getCountByUser(Yii::$app->user->id);
                }
            }
        }
        return $r;
    }
    
    /**
     * Displays homepage.
     *
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
    /**
     * Delete Item
     *
     * @return mixed
     */
    public function actionDeleteItem()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        
        $r = array('success' => 1);
        
        $model = Cart::find()->where(['user_id' => Yii::$app->user->id, 'product_id' => Yii::$app->request->post('product_id')])->one();
        if ($model){
            $model->delete();
        }
        return $r;
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
        $r['items_count'] = $cartInfo['count'];
        $r['content'] = $this->renderPartial('_items',[
           'cartInfo' => $cartInfo,
        ]);
        return $r;
    }
    
    /**
     * Set item months
     *
     * @return mixed
     */
    public function actionSetMonths()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        
        $r = array('success' => 1);
        
        $model = Cart::find()->where(['user_id' => Yii::$app->user->id, 'product_id' => Yii::$app->request->post('product_id')])->one();
        if ($model && in_array(Yii::$app->request->post('months'), Cart::$months)){
            $model->months = Yii::$app->request->post('months');
            $model->save();
        }
        
        return $r;
    }
}

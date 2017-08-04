<?php

namespace frontend\controllers;

use Yii;
use common\models\Cart;
use common\models\Product;

class CartController extends \frontend\controllers\Controller
{
    public function actionAdd()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $r = ['result' => 0, 'show_signup' => 0];
        
        if (Yii::$app->user->isGuest){
            $r['show_signup'] = 1;
        } elseif (Yii::$app->request->isAjax 
               && Yii::$app->request->post('product_id')) {
            if ($product = Product::findOne(Yii::$app->request->post('product_id'))){
                $months = in_array(Yii::$app->request->post('months'), [1,2,3]) ? Yii::$app->request->post('months') : 1;
                $cart = new Cart;
                $cart->product_id = $product->id;
                $cart->months = $months;
                $cart->user_id = Yii::$app->user->id;
                if ($cart->save()){
                    $r['result'] = 1;
                    $r['cart_items_count'] = Cart::getCountByUser(Yii::$app->user->id);
                }
            }
        }
        return $r;
    }
}

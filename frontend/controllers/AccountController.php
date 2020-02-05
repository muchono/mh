<?php
namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

use common\models\OrderToProduct;
use common\models\Order;
use common\models\User;
use common\models\UserBilling;

use frontend\models\ChangePasswordForm;

/**
 * Site controller
 */
class AccountController extends \frontend\controllers\Controller
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
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    //'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $subQuery = OrderToProduct::find()
        ->select('order_to_product.product_id, max(order_to_product.expires) expires')
        ->joinWith(['order','product'])
        ->andWhere(['order.user_id' => Yii::$app->user->id])
        ->andWhere(['product.status' => 1])
        ->groupBy(['order_to_product.product_id']);

        
        $orderedProducts = OrderToProduct::find()
        ->select('order_to_product.*')
        ->innerJoin(['res' => $subQuery], 'order_to_product.`product_id` = res.`product_id` AND order_to_product.expires = res.expires')
        ->all();
        
        return $this->render('index', array(
            'orderedProducts' => $orderedProducts,
        ));
    }
    
    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionAffiliate()
    {
        return $this->render('affiliate', array(
            //'orderedProducts' => $orderedProducts,
        ));
    }    
    
    /**
     *
     * @return mixed
     */
    public function actionProfile()
    {
        $user = User::findOne(Yii::$app->user->id);
        $userBilling = $user->billing ? $user->billing : new UserBilling;
        
        $userBilling->user_id = Yii::$app->user->id;
        
        if ($userBilling->load(Yii::$app->request->post())) {

            $userBilling->subscribe_offers = intval(Yii::$app->request->post('UserBilling')['subscribe_offers']);
            $userBilling->subscribe_blog = intval(Yii::$app->request->post('UserBilling')['subscribe_blog']);
            $userBilling->save();
            
            $user->subscribe_offers = $userBilling->subscribe_offers;
            $user->subscribe_blog = $userBilling->subscribe_blog;
            $user->save();
            
        } else {
            $userBilling->subscribe_offers = $user->subscribe_offers;
            $userBilling->subscribe_blog = $user->subscribe_blog;
        }
        
        return $this->render('profile', array(
            'userBilling' => $userBilling,
            'user' => $user,
        ));
    }
    
    /**
     *
     * @return mixed
     */
    public function actionOrders()
    {
        $orders = Order::find()->where(['user_id'=>Yii::$app->user->id])->all();
        return $this->render('orders', array(
            'orders' => $orders,
            'orders_count' => count($orders),
        ));
    }    
    
    /**
     *
     * @return mixed
     */
    public function actionChange()
    {
        $changePasswordForm = new ChangePasswordForm();
        
        if ($changePasswordForm->load(Yii::$app->request->post()) && $changePasswordForm->validate()) {
            $changePasswordForm->savePassword();
            
            return $this->redirect(['change', 'success'=>'1']);
        }
        return $this->render('change', array(
            'changePasswordForm' => $changePasswordForm,
            'changed' => Yii::$app->request->get('success'),
        ));
    }     
    
    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        $user = User::findOne(Yii::$app->user->id);
        $user->active_at = 0;
        $user->save();
                
        Yii::$app->user->logout();

        return $this->goHome();
    }
}

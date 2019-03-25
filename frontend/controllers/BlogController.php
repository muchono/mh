<?php

namespace frontend\controllers;

use Yii;
use common\models\Post;
use common\models\PostCategory;
use common\models\Discount;
use common\models\Subscriber;
use common\models\User;
use yii\data\ActiveDataProvider;

class BlogController extends \frontend\controllers\Controller
{
    const MAX_SUBSCRIBERS_HOUR = 10;
    
    public function actionIndex()
    {
        $query = Post::find()->where(['active' => '1']);
        if (Yii::$app->request->get('cid') && $cmodel = PostCategory::findOne(Yii::$app->request->get('cid'))){
            $query=$query->innerJoinWith([
                'postCategories' => function ($query) use ($cmodel) {
                    $query->onCondition(['category_id' => $cmodel->id]);
                }]);
        }
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => array('pageSize' => 9),
        ]);
        return $this->render('index', array(
            'posts' => $dataProvider,
        ));        
        
        return $this->render('index');
    }
    
    public function actionPost($id)
    {
        $this->view->params['social-panel'] = true;
        
        $a = Discount::find()->active()->latest();
        $special_offer = Discount::find()->active()->latest();

        if (($model = Post::findOne($id)) !== null) {
            return $this->render('post', array(
                'model' => $model,
                'special_offer' => $special_offer,
            ));
        } else {
            return $this->redirect(['index']);
        }
    }
    
    public function actionSubscribe()
    {
        $subscriber = new Subscriber;
        $subscriber->email = !empty(Yii::$app->request->post('email')) ? Yii::$app->request->post('email') : '';
        $subscriber->ip =  ip2long(Yii::$app->request->userIP);
        $subscriber->active =  1;
        
        $countLast = Subscriber::find()
                ->where(['ip' => $subscriber->ip])
                ->andWhere(['>', 'created_at', time()-86400]) //check for week
                ->count();
        
        if ($countLast > self::MAX_SUBSCRIBERS_HOUR) {
            Yii::$app->session['subscribed'] = false;
        } elseif ($subscriber->save()) {
            Yii::$app->session['subscribed'] = true;
        }
        $r = array('errors'=>join(' ', $subscriber->getErrors('email')));
        
        echo json_encode($r);
        Yii::$app->end();
    }
    
    public function actionUnsubscribe()
    {
        if (Yii::$app->request->get('id') && Yii::$app->request->get('key')) {
            $who = substr(Yii::$app->request->get('id'), 0, 1);
            $id = substr(Yii::$app->request->get('id'), 1);
            switch($who){
                case 's': 
                    $user = Subscriber::findOne($id);
                    if (!empty($user) 
                            && Yii::$app->request->get('key') == md5($user->id.$user->created_at)) {
                        $user->active = 0;
                        $user->save();
                    }
                    break;
                case 'u': 
                    $user = User::findOne($id);
                    if (!empty($user) 
                            && Yii::$app->request->get('key') == md5($user->id.$user->created_at)) {
                        $billing = $user->billing;
                        $billing->subscribe_blog = 0;
                        $billing->save();
                    }
                    break;
            }
            $this->layout= 'result';
            
            return $this->render('success', []);            
        }
   }
    
    public function beforeAction($action)
    {
        $this->view->params['page'] ='blog';
        return parent::beforeAction($action);
    }  
    
}

<?php

namespace frontend\controllers;

use Yii;
use common\models\Post;
use common\models\PostCategory;
use common\models\Discount;
use common\models\Subscriber;
use common\models\User;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;

class BlogController extends \frontend\controllers\Controller
{
    const MAX_SUBSCRIBERS_HOUR = 10;
    
    public function actionIndex()
    {
        $query = Post::find()->where(['active' => '1'])->orderBy('id DESC');
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
        $special_offer = Discount::findActive()->latest();

        if (($model = Post::findOne($id)) !== null) {
            $this->view->title = $model->title;
            \Yii::$app->view->registerMetaTag(['name' => 'keywords', 'content' => $model->meta_keywords ]);
            \Yii::$app->view->registerMetaTag(['name' => 'description', 'content' => $model->meta_description ]);            
            
            \Yii::$app->view->registerMetaTag(['name' => 'og:locale', 'content' => "en_US" ]);
            \Yii::$app->view->registerMetaTag(['name' => 'og:type', 'content' => "article" ]);
            \Yii::$app->view->registerMetaTag(['name' => 'og:title', 'content' => $model->title ]);
            \Yii::$app->view->registerMetaTag(['name' => 'og:description', 'content' => $model->meta_description ]);
            \Yii::$app->view->registerMetaTag(['name' => 'og:url', 'content' => Yii::$app->request->absoluteUrl ]);
            \Yii::$app->view->registerMetaTag(['name' => 'og:updated_time', 'content' => date('Y-m-d H:i:s', $model->updated_at) ]);
            \Yii::$app->view->registerMetaTag(['name' => 'og:image', 'content' => Url::base(true).'/images/blog/'.$model->image ]);            
            \Yii::$app->view->registerMetaTag(['name' => 'og:site_name', 'content' => "Marketing Hack" ]);
            
            $this->view->params['social-panel-text']= urlencode($model->title);
            
            return $this->render('post', array(
                'model' => $model,
                'special_offer' => $special_offer,
            ));
        } else {
            return $this->redirect(['index']);
        }
    }
    
    public function actionUrl($url)
    {
        if (!empty($url)) {
            $model = Post::find()->where(['url_anckor' => $url])->one();
            if ($model) {
                return $this->actionPost($model->id);
            }
        }
        return $this->redirect(['index']);
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
            $type = Yii::$app->request->get('type');
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
                        switch($type) {
                            case 'blog': 
                                $user->subscribe_blog = 0;
                                break;
                            case 'offer': 
                                $user->subscribe_offers = 0;
                                break;
                        }
                        $user->save();
                        if ($billing) {
                            $billing->subscribe_offers = $user->subscribe_blog;                            
                            $billing->subscribe_blog = $user->subscribe_offers;                            
                            $billing->save();
                        }
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

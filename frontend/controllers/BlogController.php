<?php

namespace frontend\controllers;
use common\models\Post;
use common\models\Discount;

use yii\data\ActiveDataProvider;
class BlogController extends \yii\web\Controller
{
    
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Post::find()->where(['active' => '1']),
            'pagination' => array('pageSize' => 9),
        ]);
        return $this->render('index', array(
            'posts' => $dataProvider,
        ));        
        
        return $this->render('index');
    }
    
    public function actionPost($id)
    {
        $a = Discount::find()->active()->latest();
        
        if (($model = Post::findOne($id)) !== null) {
            return $this->render('post', array(
                'model' => $model,
                'special_offer' => Discount::find()->active()->latest(),
            ));
        } else {
            return $this->redirect(['index']);
        }
    }
    
    public function beforeAction($action)
    {
        $this->view->params['page'] ='blog';
        return parent::beforeAction($action);
    }    

}

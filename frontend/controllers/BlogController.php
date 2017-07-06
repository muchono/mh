<?php

namespace frontend\controllers;
use common\models\Post;
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

}

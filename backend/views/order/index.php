<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\jui\DatePicker;
use common\models\Product;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\OrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Orders';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute' => 'id',
                'headerOptions' => ['style' => 'width: 200px'],
            ],
            [
                'attribute' => 'created_at',
                'filter' => DatePicker::widget([
                    'language' => 'en',
                    //'dateFormat' => 'dd-MM-yyyy',
                    'model' => $searchModel,
                    'attribute' => 'created_at',
                    'options' => ['class' => 'form-control col-sm-4'],
                    'clientOptions' => [
                        'dateFormat' => 'dd-mm-yy',
                    ],
                ]),
                // this is meaningless
                'format' => ['date', 'php:d-m-Y'],
                'headerOptions' => ['style' => 'width:118px'],                
            ],
            [
                'attribute' => 'user_name',
                'content' => function ($model, $key, $index, $column) {
                    return Html::a($model->user->name, ['user/update', 'id' => $model->user->id], ['target' => '_blank']);
                },
                'headerOptions' => ['style' => 'width:20%'],
            ],
            [
                'attribute' => 'user_email',
                'content' => function ($model, $key, $index, $column) {
                    return $model->user->email;
                },
            ],                        
            [
                'attribute' => 'products',
                'filter' => Product::find()->select('title,id')->indexBy('id')->column(),
                'content' => function ($model, $key, $index, $column) {
                    return $this->render('_index_products', [
                        'model' => $model,
                    ]);
                },
                'headerOptions' => ['style' => 'width:35%'],                
            ],            
            'total',
            [
                'attribute' => 'Payment',
                'content' => function ($model, $key, $index, $column) {
                    return $model->payment_method;
                },
            ],
            [
                'attribute' => 'Invoice',
                'content' => function ($model, $key, $index, $column) {
                    return Html::a('<span class="glyphicon glyphicon-download-alt"></span>', ['invoice/get', 'id' => $model->id], ['target' => '_blank']);
                },

            ],                        
            //['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>

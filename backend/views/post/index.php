<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\PostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Posts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Post', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Blog Post Categories', ['post-category/index'], ['class' => 'btn btn-success']) ?>        
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute' => 'created_at',
                'filter' => yii\jui\DatePicker::widget([
                    'language' => 'en',
                    //'dateFormat' => 'dd-MM-yyyy',
                    'model' => $searchModel,
                    'attribute' => 'created_at',
                    'options' => ['class' => 'form-control'],
                    'clientOptions' => [
                        'dateFormat' => 'dd-mm-yy',
                    ],
                ]),
                // this is meaningless
                'format' => ['date', 'php:d-m-Y'],
                'headerOptions' => ['style' => 'width:118px'],                                
            ],             
            'title',

            [
                'class' => 'yii\grid\ActionColumn',
                'headerOptions' => ['style' => 'width:150px'],
                'template' => '{update} {delete}',
            ],
        ],
    ]); ?>
</div>

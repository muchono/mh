<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\FaqSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'FAQs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="faq-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create FAQ Item', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('FAQ Categories', ['faq-category/index'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'title',
            [
                'attribute' => 'categories',
                'filter' => common\models\FaqCategory::find()->select('title,id')->indexBy('id')->column(),
                'content' => function ($model, $key, $index, $column) {
                    return $this->render('_index_categories', [
                        'model' => $model,
                    ]);
                },
                'headerOptions' => ['style' => 'width:40%'],                
            ],            
            [
                'class' => 'yii\grid\ActionColumn',
                'headerOptions' => ['style' => 'width:150px'],
                'template' => '{update} {delete}',
            ],
        ],
    ]); ?>
</div>

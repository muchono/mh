<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\AboutUsContent;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\AboutUsContentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'About US';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="about-us-content-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'title',
            [
                'attribute' => 'href',
                'filter' => AboutUsContent::$hrefs,
                'content' => function ($model, $key, $index, $column) {
                    return $model->hrefName;
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

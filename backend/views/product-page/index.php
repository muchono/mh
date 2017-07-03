<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ProductPageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Product Pages';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-page-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Product Page', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'product_id',
            'title',
            'description:ntext',
            'guide_description',
            // 'list_description',
            // 'feature1',
            // 'feature2',
            // 'feature3',
            // 'feature4',
            // 'feature5',
            // 'content:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>

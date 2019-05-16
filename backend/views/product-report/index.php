<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Product Report';
$this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => ['product/index']];
$this->params['breadcrumbs'][] = ['label' => $product->title, 'url' => ['product/update', 'id' => $product->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-report-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Product Report', ['create', 'product_id' => $product->id], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'class' => 'yii\grid\SerialColumn',
                'headerOptions' => ['style' => 'width:15px'],
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

<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\ProductHref;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'List';
$this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => ['product/index']];
$this->params['breadcrumbs'][] = ['label' => $searchModel->product->title, 'url' => ['product/update', 'id' => $searchModel->getProduct()->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-href-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create', ['create', 'product_id' => $searchModel->getProduct()->id], ['class' => 'btn btn-success']) ?>
        <?= Html::a('URL Categories', ['product-href-category/index'], ['class' => 'btn btn-success', 'target' => '_blank']) ?>        
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'url:url',
            'alexa_rank',
            'da_rank',
            [
                'attribute'=>'about',
                'format'=>'html',   
                'content' => function ($model, $key, $index, $column) {
                    return wordwrap(strip_tags($model->about), 75, '<br/>');
                }    
            ],
            [
                'attribute' => 'type_links',
                'content' => function ($model, $key, $index, $column) {
                    return ProductHref::$link_types[$model->type_links];
                }
            ],             

            ['class' => 'yii\grid\ActionColumn',                
            'template' => '{update} {delete}',
                
                ],
        ],
    ]); ?>
</div>

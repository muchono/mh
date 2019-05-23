<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Reports';
?>
<div class="product-report-item-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute'=>'URL',
                'format' => 'raw',
                'value' => function ($data) {
                    return Html::a($data->href->url, $data->href->url, ['target'=>'_blank']);
                }
            ], 
            [
                'attribute'=>'Product',
                'format' => 'raw',
                'value' => function ($data) {
                    return Html::a($data->report->product->short_title, ['product/update', 'id' => $data->report->product->id], ['target'=>'_blank']);
                }
            ],
            [
                'attribute'=>'User',
                'value' => function ($data) {
                    $r=[];
                    foreach($data->getCases()->all() as $c){
                        $r[] = $c->user->email;
                    }
                    return join(',', $r);
                }
            ],                    
            [
                'attribute'=>'Report Status',
                'value' => function ($data) {
                    return $data->report->title;
                }
            ],        
            [
                'value' => function ($data) {
                    return $data->cases_count;
                }
            ],                     

           ['class' => 'yii\grid\ActionColumn',                
            'template' => '{delete}',
                
                ],
        ],
    ]); ?>
</div>

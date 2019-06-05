<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Reports';
?>
<div class="product-report-item-index">

    <h1><?= Html::encode($this->title) ?></h1>
<?php
$form = ActiveForm::begin([
    'id' => 'report-form',
    'options' => ['class' => 'form-horizontal'],
]) ?>
    
    <p>
        <?= Html::submitButton('Delete Selected', ['class' => 'btn btn-primary', 'data' => [
                'confirm' => 'Are you sure you want to delete selected items?',
                'method' => 'post',
            ]]) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'class' => 'yii\grid\CheckboxColumn',
                // you may configure additional properties here
            ],           
            [
                'attribute'=>'URL',
                'format' => 'raw',
                'value' => function ($data) {
                    return empty($data->href) ? '' : Html::a($data->href->url, $data->href->url, ['target'=>'_blank']);
                }
            ], 
            [
                'attribute'=>'Product',
                'format' => 'raw',
                'value' => function ($data) {
                    return empty($data->report) ? '' : Html::a($data->report->product->title, ['product/update', 'id' => $data->report->product->id], ['target'=>'_blank']);
                }
            ],
            [
                'attribute'=>'User',
                'value' => function ($data) {
                    $r=[];
                    foreach($data->getCases()->all() as $c){
                        if (!empty($c->user)) {
                            $r[] = $c->user->email;
                        }
                        
                    }
                    return join(',', $r);
                }
            ],                    
            [
                'attribute'=>'Report Status',
                'value' => function ($data) {
                    return empty($data->report) ? '' : $data->report->title;
                }
            ],        
            [
                'value' => function ($data) {
                    return $data->cases_count;
                }
            ],
        ],
    ]); ?>

<?php ActiveForm::end() ?>
</div>

<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ProductHrefSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'List';
$this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => ['product/index']];
$this->params['breadcrumbs'][] = ['label' => $searchModel->product->title, 'url' => ['product/update', 'id' => $searchModel->getProduct()->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-href-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('URL Categories', ['product-href-category/index'], ['class' => 'btn btn-success', 'target' => '_blank']) ?>
    </p>
    
<?php //Pjax::begin(); ?>    
<?php $form = ActiveForm::begin(); ?>
<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'class' => 'yii\grid\SerialColumn',
                'contentOptions' => ['style' => 'vertical-align: middle;'],
            ],
            [
                'content' => function ($model, $key, $index, $column) use ($form) {
                    return $this->render('_form', [
                        'model' => $model,
                        'form' => $form,
                    ]);
                }
            ],            
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{delete}',
                'contentOptions' => ['style' => 'vertical-align: middle;'],
            ],
        ],
    ]); ?>
    
    <div class="form-group">
        <?= Html::submitButton('+ Add One More', ['class' => 'btn btn-success']) ?>
        <?= Html::submitButton('SUBMIT UPDATE', ['class' => 'btn btn-primary pull-right']) ?>
    </div>
<?php ActiveForm::end(); ?>
<?php //Pjax::end(); ?>
</div>

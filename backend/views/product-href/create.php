<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
use yii\data\ArrayDataProvider;

use common\models\ProductHref;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ProductHrefSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Create Items';
$this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => ['product/index']];
$this->params['breadcrumbs'][] = ['label' => $searchModel->product->title, 'url' => ['product/update', 'id' => $searchModel->getProduct()->id]];
$this->params['breadcrumbs'][] = ['label' => 'List', 'url' => ['product-href/index', 'product_id' => $searchModel->product->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-href-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('URL Categories', ['product-href-category/index'], ['class' => 'btn btn-success', 'target' => '_blank']) ?>
    </p>
    
 
<?php $form = ActiveForm::begin([
    'enableClientValidation' => false,
    'enableAjaxValidation' => false,
]); ?>  
<?= GridView::widget([
        'id' => 'block_hrefs',
        'dataProvider' => $dataProvider,
        'summary' => "",
        'columns' => [
            [
                'class' => 'yii\grid\SerialColumn',
                'contentOptions' => ['style' => 'vertical-align: middle;'],
            ],
            [
                'content' => function ($model, $key, $index, $column) use ($form) {
                    return $this->render('_form2', [
                        'model' => $model,
                        'form' => $form,
                        'field_container' => 'new',
                        'id' => $index,
                        'dynamic' => false,
                    ]);
                }
            ],            
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{delete}',
                'buttons'  => [
                    'delete' => function ($url, $model) {
                        $r = '';

                            $r = Html::a(
                                '<span class="glyphicon glyphicon-trash"></span>',
                                '#',
                                [
                                    'class' => 'newDelete',
                                ]
                            );

                        return $r;
                    }
                ],                
                'contentOptions' => ['style' => 'vertical-align: middle;'],
            ],
        ],
    ]); ?>
    
    <div class="form-group">
        <?= Html::button('+ Add One More', ['class' => 'btn btn-success', 'id' => 'btn_add']) ?>
        <?= Html::submitButton('SUBMIT', ['class' => 'btn btn-primary pull-right']) ?>
    </div>
<?php ActiveForm::end(); ?>
</div>
<div id="hidden_template" class="hidden">
<?= GridView::widget([
        'id' => 'block_new',
        'dataProvider' => new ArrayDataProvider([
                'allModels' => array(new ProductHref()),
        ]),
        'columns' => [
            [
                'contentOptions' => ['style' => 'vertical-align: middle;'],
                'content' => function ($model, $key, $index, $column) use ($form) {
                    return '#';
                }
            ],
            [
                'content' => function ($model, $key, $index, $column) use ($form) {
                    return $this->render('_form2', [
                        'model' => $model,
                        'form' => $form,
                        'field_container' => 'new',   
                        'id' => 'IIII',
                        'dynamic' => true,
                    ]);
                }
            ],            
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{delete}',
                'buttons'  => [
                    'delete' => function ($url, $model) {
                        return Html::a(
                                '<span class="glyphicon glyphicon-trash"></span>',
                                '#',
                                [
                                    'class' => 'newDelete',
                                ]
                            );
                    }
                ],
                'contentOptions' => ['style' => 'vertical-align: middle;'],
            ],
        ],
    ]); ?>    
</div>

<?php 
$this->registerCss(".help-block {  overflow-wrap: break-word;
  word-wrap: break-word;
  hyphens: auto;}");
$this->registerJsFile(
    '@web/js/product_href.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);

?>
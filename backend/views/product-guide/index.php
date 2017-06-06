<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ProductGuideSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Guide';
$this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => ['product/index']];
$this->params['breadcrumbs'][] = ['label' => $searchModel->product->title, 'url' => ['product/update', 'id' => $searchModel->getProduct()->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-guide-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    </p>        
        <?= Html::a('Create Guide Item', ['create', 'product_id' => $searchModel->getProduct()->id], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'rowOptions' => function ($model, $key, $index, $grid) {
            return ['data-sortable-id' => $model->id];
        },    
        'columns' => [
            ['class' => \kotchuprik\sortable\grid\Column::className()],
            'title',
            [
                'attribute' => 'categories',
                'filter' => common\models\FaqCategory::find()->select('title,id')->indexBy('id')->column(),
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'headerOptions' => ['style' => 'width:150px'],
                'template' => '{update} {delete}',
                
            ],            
        ],
        'options' => [
            'data' => [
                'sortable-widget' => 1,
                'sortable-url' => \yii\helpers\Url::toRoute(['sorting']),
            ]
        ],
    ]); ?>
<?php Pjax::end(); ?></div>

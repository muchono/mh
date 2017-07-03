<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Products';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Product', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'rowOptions' => function ($model, $key, $index, $grid) {
            return ['data-sortable-id' => $model->id];
        },
               
        'columns' => [
            ['class' => \kotchuprik\sortable\grid\Column::className()],
            'title',
            'price',
            [
                'attribute'=>'status',
                'value' => function ($data) {
                    return $data->getStatusName();
                },
                'filter' => $searchModel::$statuses,
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {page} {links} {guide} {delete} ',
                'buttons' => [
                    'page' => function ($url, $model) {
                        return \yii\helpers\Html::a('<span class="glyphicon glyphicon glyphicon-file"></span>',
                            yii\helpers\Url::to(['product-page/index', 'product_id' => $model['id']]), [
                                'title' => Yii::t('yii', 'Page'),
                                'data-pjax' => 0,
                            ]);
                    },                         
                    'links' => function ($url, $model) {
                        return \yii\helpers\Html::a('<span class="glyphicon glyphicon-th-list"></span>',
                            yii\helpers\Url::to(['product-href/index', 'product_id' => $model['id']]), [
                                'title' => Yii::t('yii', 'List'),
                                'data-pjax' => 0,
                            ]);
                    },                
                    'guide' => function ($url, $model) {
                        return \yii\helpers\Html::a('<span class="glyphicon glyphicon-user"></span>',
                            yii\helpers\Url::to(['product-guide/index', 'product_id' => $model['id']]), [
                                'title' => Yii::t('yii', 'Guide'),
                                'data-pjax' => 0,
                            ]);
                    },                
                ],
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

<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\jui\DatePicker;
use common\models\Product;
use common\models\Discount;


/* @var $this yii\web\View */
/* @var $searchModel backend\models\DiscountSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Discounts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="discount-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Discount', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute' => 'date_from',
                'filter' => DatePicker::widget([
                    'language' => 'en',
                    //'dateFormat' => 'dd-MM-yyyy',
                    'model' => $searchModel,
                    'attribute' => 'date_from',
                    'options' => ['class' => 'form-control'],
                    'clientOptions' => [
                        'dateFormat' => 'dd-mm-yy',
                    ],
                ]),
                // this is meaningless
                'format' => ['date', 'php:d-m-Y'],
                'headerOptions' => ['style' => 'width:118px'],                                
            ],
            [
                'attribute' => 'date_to',
                'filter' => DatePicker::widget([
                    'language' => 'en',
                    //'dateFormat' => 'dd-MM-yyyy',
                    'model' => $searchModel,
                    'attribute' => 'date_to',
                    'options' => ['class' => 'form-control'],
                    'clientOptions' => [
                        'dateFormat' => 'dd-mm-yy',
                    ],
                ]),
                // this is meaningless
                'format' => ['date', 'php:d-m-Y'],
                'headerOptions' => ['style' => 'width:118px'],                                
            ],            
            'title',
            [
                'attribute' => 'products',
                'filter' => Product::find()->select('title,id')->indexBy('id')->column(),
                'content' => function ($model, $key, $index, $column) {
                    return $this->render('_index_products', [
                        'model' => $model,
                    ]);
                },
                'headerOptions' => ['style' => 'width:40%'],                
            ],            
            [
                'attribute'=>'percent',
                'value' => function ($data) {
                    return $data->percent.'%';
                },
            ],

            [
                'attribute'=>'status',
                'value' => function ($data) {
                    return $data->getStatusName();
                },
                'filter' => $searchModel::$statuses,
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'headerOptions' => ['style' => 'width:150px'],
                'template' => '{update} {delete}',
                'visibleButtons' => [
                    'delete' => function ($model, $key, $index) {
                                    return $model->id != Discount::SPECIAL40ID;
                    }
                ],                
                
            ],
        ],
    ]); ?>
</div>

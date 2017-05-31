<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\jui\DatePicker;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create User', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'email:email',
            'name',
            [
                'attribute'=>'active',
                'value' => function ($data) {
                    return $data->getStatusName();
                },
                'filter' => $searchModel::$statuses,
            ],
            [
                'attribute' => 'created_at',
                'filter' => DatePicker::widget([
                    'language' => 'en',
                    //'dateFormat' => 'dd-MM-yyyy',
                    'model' => $searchModel,
                    'attribute' => 'created_at',
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
                'class' => 'yii\grid\ActionColumn',
                'headerOptions' => ['style' => 'width:150px'],
                'template' => '{update} {delete}',
                
            ], 
        ],
    ]); ?>
</div>

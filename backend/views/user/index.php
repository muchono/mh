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
<?php Pjax::begin(); ?>    <?= GridView::widget([
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
                        

	
/*
 [
            'attribute' => 'updated_at',
            'value' => 'updated_at',
            },
            'filter' => \yii\jui\DatePicker::widget([
                    'model'=>$searchModel,
                    'attribute'=>'updated_at',
                    'language' => 'ru',
                    'dateFormat' => 'dd-MM-yyyy',
                ]),
            'format' => 'html',
        ],
*/
                        
            [
                'attribute' => 'created_at',
                'format' => ['date', 'php:d/m/Y'],
                'filter' => DatePicker::widget([
                    'language' => 'en',
                    'model' => $searchModel,
                    'attribute' => 'created_at',
                    'clientOptions' => [
                        'dateFormat' => 'dd/mm/yy',
                    ],
                ]),
                // this is meaningless
                'format' => ['date', 'php:d/m/Y'],
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'headerOptions' => ['style' => 'width:150px'],
                'template' => '{update} {delete}',
                
            ], 
        ],
    ]); ?>
<?php Pjax::end(); ?></div>

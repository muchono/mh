<?php
use yii\grid\GridView;
use yii\data\ArrayDataProvider;
use yii\helpers\Html;
use yii\helpers\Url;
use common\models\Order;
?>

<div class="bs-example">
    <?=GridView::widget([
        'dataProvider' => new ArrayDataProvider([
                    'allModels' => $model->userAffiliate->getUsers(),
                ]),
        'layout' => '{items}',
        'columns' => [
            [
                'attribute'=>'name',
                'format' => 'raw',
                'value' => function ($data) {
                    return Html::a($data->name, Url::to(['user/update','id'=>$data->id]),['target' =>'_blank']);
                },
            ],                          
            'email',
            [
                'label' => 'Amount Of Purchases',
                'value' =>  function ($data) {
                    $r = Order::getUserTotal($data->id);
                    return $r ? $r."$" : '-';
                }
            ]
        ],
    ]);?>
</div>
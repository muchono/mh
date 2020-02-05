<?php
use yii\grid\GridView;
use yii\data\ArrayDataProvider;
use yii\helpers\Html;
use yii\helpers\Url;

use common\models\UserAffiliate;
?>

<div class="bs-example">
    <?=GridView::widget([
        'dataProvider' => new ArrayDataProvider([
                    'allModels' => $affiliates,
                ]),
        'layout' => '{items}',
        'columns' => [
            [
                'label'=>'User Name',
                'format' => 'raw',
                'value' => function ($data) {
                    return Html::a($data['user']->name, Url::to(['user/update','id'=>$data['user']->id]),['target' =>'_blank']);
                },
            ],         
            [
                'label'=>'E-mail',
                'format' => 'raw',
                'value' => function ($data) {
                    return $data['user']->email;
                },
            ],
            [
                'label'=>'Users Quantity',
                'format' => 'raw',
                'value' => function ($data) {
                    return $data['users_quantity'];
                },
            ],                        
            [
                'label'=>'Comission Percent',
                'format' => 'raw',
                'value' => function ($data) {
                    return $data['user']->affiliate_comission;
                },
            ],
            [
                'label'=>'Comission Payed',
                'format' => 'raw',
                'value' => function ($data) {
                    return $data['payed'];
                },
            ],
            [
                'label'=>'Comission NOT Payed',
                'format' => 'raw',
                'value' => function ($data) {
                    return $data['comission'];
                },
            ],
        ],
    ]);?>
</div>
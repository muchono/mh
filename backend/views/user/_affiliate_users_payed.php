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
                    'allModels' => $model->userAffiliate->getPayments(),
                ]),
        'layout' => '{items}',
        'columns' => [
            'created_at',
            'total',
        ],
    ]);?>
</div>
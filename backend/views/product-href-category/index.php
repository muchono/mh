<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ProductHrefCategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Product URLs Categories';
$this->params['breadcrumbs'] = array();
?>
<div class="product-href-category-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'title',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}',
                ],
        ],
    ]); ?>
</div>

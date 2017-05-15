<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\ProductGuideSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Product Guides';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-guide-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Guide Item', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => \kotchuprik\sortable\grid\Column::className()],
            ['class' => 'yii\grid\SerialColumn'],
            'title',
            ['class' => 'yii\grid\ActionColumn'],
        ],
        'options' => [
            'data' => [
                'sortable-widget' => 1,
                'sortable-url' => \yii\helpers\Url::toRoute(['sorting']),
            ]
        ],    
    ]); ?>
<?php Pjax::end(); ?></div>

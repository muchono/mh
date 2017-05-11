<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\ProductHrefSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Links';
$this->params['breadcrumbs'][] = ['label' => $searchModel->product->title, 'url' => ['product/update', 'id' => $searchModel->getProduct()->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-href-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Product Link', ['create', 'product_id' => $searchModel->getProduct()->id], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Link Categories', ['product-href-category/index'], ['class' => 'btn btn-success', 'target' => '_blank']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'url:url',
            'status',
            // 'traffic',
            // 'google_pr',
            // 'alexa_rank',
            // 'da_rank',
            // 'about:ntext',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}',
            ],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>

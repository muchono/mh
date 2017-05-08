<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\ProductHref */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Product Hrefs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-href-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'product_id',
            'title',
            'url:url',
            'status',
            'traffic',
            'google_pr',
            'alexa_rank',
            'da_rank',
            'about:ntext',
        ],
    ]) ?>

</div>

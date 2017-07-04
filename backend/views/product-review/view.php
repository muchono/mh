<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\ProductReview */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Product Reviews', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-review-view">

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
            'user_id',
            'name',
            'email:email',
            'raiting',
            'content:ntext',
        ],
    ]) ?>

</div>

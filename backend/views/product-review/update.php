<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ProductReview */

$this->title = 'Update Review';
$this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => ['product/index']];
$this->params['breadcrumbs'][] = ['label' => $model->getProduct()->title, 'url' => ['product/update', 'id' => $model->getProduct()->id]];
$this->params['breadcrumbs'][] = ['label' => 'Reviews', 'url' => ['product-review/index', 'product_id' => $model->getProduct()->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-review-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

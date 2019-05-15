<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\ProductReport */

$this->title = 'Create Product Report Item';
$this->params['breadcrumbs'][] = ['label' => $product->title, 'url' => ['product/update', 'id' => $product->id]];
$this->params['breadcrumbs'][] = ['label' => 'Product Reports Items', 'url' => ['index', 'product_id' => $product->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-report-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'product' => $product,
    ]) ?>

</div>

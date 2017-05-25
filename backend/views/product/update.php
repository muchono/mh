<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\Product */

$this->title = 'Update Product: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->title;
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="product-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <p> 
        <?= Html::a('List', ['product-href/index', 'product_id' => $model->id], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Guide', ['product-guide/index', 'product_id' => $model->id], ['class' => 'btn btn-success']) ?>
    </p>
    <p></p>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

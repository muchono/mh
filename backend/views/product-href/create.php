<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\ProductHref */

$this->title = 'Add URL';
$this->params['breadcrumbs'][] = ['label' => $model->getProduct()->title, 'url' => ['product/update', 'id' => $model->getProduct()->id]];
$this->params['breadcrumbs'][] = ['label' => 'List', 'url' => ['index', 'product_id' => $model->getProduct()->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-href-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

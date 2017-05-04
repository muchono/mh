<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\ProductHref */

$this->title = 'Create Product Href';
$this->params['breadcrumbs'][] = ['label' => 'Product Hrefs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-href-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

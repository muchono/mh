<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\ProductGuide */

$this->title = 'Create Product Guide';
$this->params['breadcrumbs'][] = ['label' => 'Product Guides', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-guide-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

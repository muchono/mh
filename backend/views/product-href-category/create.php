<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\ProductHrefCategory */

$this->title = 'Create Category';
$this->params['breadcrumbs'] = [];
$this->params['breadcrumbs'][] = ['label' => 'Product URLs Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-href-category-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

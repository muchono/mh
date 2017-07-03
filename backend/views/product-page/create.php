<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\ProductPage */

$this->title = 'Create Product Page';
$this->params['breadcrumbs'][] = ['label' => 'Product Pages', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-page-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

<?php

use yii\helpers\Html;
use common\models\Product;
/* @var $this yii\web\View */
/* @var $model common\models\ProductGuide */

$this->title = 'Update Guide Item: ' . $model->title;

$this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => ['product/index']];
$this->params['breadcrumbs'][] = ['label' => Product::findOne($model->product_id)->title, 'url' => ['product/update', 'id' => $model->product_id]];
$this->params['breadcrumbs'][] = ['label' => 'Guide', 'url' => ['index','product_id' => $model->product_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="product-guide-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

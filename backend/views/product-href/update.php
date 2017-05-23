<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\models\Product;


/* @var $this yii\web\View */
/* @var $model backend\models\ProductHref */

$this->title = 'URL: ' . $model->url ;
$this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => ['product/index']];
$this->params['breadcrumbs'][] = ['label' => Product::findOne($model->product_id)->title, 'url' => ['product/update', 'id' => $model->product_id]];
$this->params['breadcrumbs'][] = ['label' => 'List', 'url' => ['index','product_id' => $model->product_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="product-href-update">

    <h1><?= Html::encode($this->title) ?></h1>

    
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

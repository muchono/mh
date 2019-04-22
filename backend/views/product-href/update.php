<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
use yii\data\ArrayDataProvider;

use common\models\ProductHref;

/* @var $this yii\web\View */
/* @var $model common\models\ProductHref */

$this->title = 'List Item';
$this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => ['product/index']];
$this->params['breadcrumbs'][] = ['label' => $model->product->title, 'url' => ['product/update', 'id' => $model->product->id]];
$this->params['breadcrumbs'][] = ['label' => 'List', 'url' => ['product-href/index', 'product_id' => $model->product->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-href-update">

    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a('URL Categories', ['product-href-category/index'], ['class' => 'btn btn-success', 'target' => '_blank']) ?>        
    </p>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

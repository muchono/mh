<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\ProductHref;
use backend\models\ProductHrefCategorySearch;


/* @var $this yii\web\View */
/* @var $model backend\models\ProductHref */
/* @var $form yii\widgets\ActiveForm */
?>
<p>
    <?= Html::a('Link Categories', ['product-href-category/index'], ['class' => 'btn btn-success', 'target' => '_blank']) ?>
</p>
<div class="product-href-form">

    <?php 
    $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'product_id')->hiddenInput(['maxlength' => true, 'value' => $model->getProduct()->id])->label(false); ?>

    <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'categories')->dropDownList(ProductHrefCategorySearch::getArray(), ['multiple'=>true,'size'=>10])?>

    <?= $form->field($model, 'type_links')->dropDownList(ProductHref::$link_types, ['size'=>4])?>
    
    <?= $form->field($model, 'about')->textarea(['rows' => 6]) ?>
    
    <?= $form->field($model, 'example_url')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'status')->dropDownList(ProductHref::$statuses)?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

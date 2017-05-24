<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\ProductHref;
use backend\models\ProductHrefCategorySearch;


/* @var $this yii\web\View */
/* @var $model backend\models\ProductHref */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-href-form">
   <div class="row">
        <?= $form->field($model, 'id')->hiddenInput(['maxlength' => true, 'value' => $model->id, 'name' => 'hrefs['.$model->id.'][id]'])->label(false); ?>
       
        <?= $form->field($model, 'product_id')->hiddenInput(['maxlength' => true, 'value' => $model->product_id, 'name' => 'hrefs['.$model->id.'][product_id]'])->label(false); ?>       
        <div class="col-md-3">
            <?= $form->field($model, 'url')->textInput(['maxlength' => true, 'name' => 'hrefs['.$model->id.'][url]']) ?>
            <?= $form->field($model, 'example_url')->textInput(['maxlength' => true, 'name' => 'hrefs['.$model->id.'][example_url]']) ?>
        </div>
        <div class="col-md-4">
        <?= $form->field($model, 'about')->textarea(['style' => 'height:108px', 'name' => 'hrefs['.$model->id.'][about]']) ?>   
        </div>
        <div class="col-md-3">
        <?= $form->field($model, 'categories')->dropDownList(ProductHrefCategorySearch::getArray(), ['multiple'=>true,'size'=>5, 'name' => 'hrefs['.$model->id.'][categories]']);?>           
        </div>
        <div class="col-md-2">
        <?= $form->field($model, 'type_links')->dropDownList(ProductHref::$link_types, ['size'=>5, 'name' => 'hrefs['.$model->id.'][type_links]'])?>
        </div>
    </div>
</div>
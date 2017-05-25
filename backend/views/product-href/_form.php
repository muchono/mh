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
        <?= $form->field($model, 'product_id')->hiddenInput(['maxlength' => true, 
            'value' => $model->product_id, 
            'name' => $field_container.'['.$id.'][product_id]'])->label(false); ?>       
        <div class="col-md-3">
            <?= $form->field($model, 'url')->textInput(['maxlength' => true, 
                'id' => 'url'.$id,
                'name' => $field_container.'['.$id.'][url]']) ?>
            <?= $form->field($model, 'example_url')->textInput(['maxlength' => true, 
                'id' => 'example_url'.$id,
                'name' => $field_container.'['.$id.'][example_url]']) ?>
        </div>
        <div class="col-md-4">
        <?= $form->field($model, 'about')->textarea(['style' => 'height:108px', 
            'id' => 'about'.$id,
            'name' => $field_container.'['.$id.'][about]']) ?>   
        </div>
        <div class="col-md-3">
        <?= $form->field($model, 'categories')->dropDownList(ProductHrefCategorySearch::getArray(), ['multiple'=>true,
            'id' => 'categories'.$id,
            'size'=>5, 'name' => $field_container.'['.$id.'][categories]']);?>           
        </div>
        <div class="col-md-2">
        <?= $form->field($model, 'type_links')->dropDownList(ProductHref::$link_types, ['size'=>5, 
            'id' => 'type_links'.$id,
            'name' => $field_container.'['.$id.'][type_links]'])?>
        </div>
    </div>
</div>
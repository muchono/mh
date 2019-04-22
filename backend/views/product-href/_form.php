<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\ProductHref;
use backend\models\ProductHrefCategorySearch;
use dosamigos\tinymce\TinyMce;

/* @var $this yii\web\View */
/* @var $model common\models\ProductHref */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-href-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'about')->widget(TinyMce::className(), [
                'options' => ['rows' => 5,
                 'cols' => 3,],
             'language' => 'en_GB',
             'clientOptions' => [
                 'forced_root_block' => "",
                 'branding' => false,
                 'menubar' => false,
                 'plugins' => [
                     "link",
                 ],
                 'toolbar' => "bold link",
             ]
             ]); ?>

    <?= $form->field($model, 'example_url')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'categories')->dropDownList(ProductHrefCategorySearch::getArray(), ['multiple'=>true, 'size'=>5]);?>  
    
        <?= $form->field($model, 'type_links')->dropDownList(ProductHref::$link_types, ['size'=>5])?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

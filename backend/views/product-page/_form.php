<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ProductPage */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-page-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'product_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'guide_description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'list_description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'feature1')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'feature2')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'feature3')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'feature4')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'feature5')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'content')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

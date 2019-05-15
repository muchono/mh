<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ProductReport */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-report-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'product_id')->hiddenInput(['value' => $model->isNewRecord ? $product->id : $model->product_id])->label(false); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

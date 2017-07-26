<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ProductReview */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-review-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <?= $form->field($model, 'product_id')->hiddenInput(['maxlength' => true, 
        'value' => $model->getProduct()->id])->label(false); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'raiting')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'active')->dropDownList($model::$statuses)?>
    
    <?= $form->field($model, 'content')->textarea(['rows' => 16 ]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

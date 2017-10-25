<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Product */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'short_title')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'full_title')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'questions')->textarea(['rows' => 6]) ?>
    
    <?= $form->field($model, 'price')->textInput() ?>
    
    <?= $form->field($model, 'link_name')->textInput(['maxlength' => true]) ?>    

    <?= $form->field($model, 'status')->dropDownList($model::$statuses)?>
    
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

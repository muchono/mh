<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use backend\models\ProductSearch;

/* @var $this yii\web\View */
/* @var $model common\models\Discount */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="discount-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <div class="row">
        <div class="col-md-2">
    <?= $form->field($model, 'date_from')->widget(\yii\jui\DatePicker::classname(), [
        'language' => 'en',
        'options' => ['class' => 'form-control', 'style'=>'width:100px'],
        'clientOptions' => [
            'dateFormat' => 'dd-mm-yy',
        ],
    ]) ?>
        </div>

        <div class="col-md-2">
    <?= $form->field($model, 'date_to')->widget(\yii\jui\DatePicker::classname(), [
        'language' => 'en',
        'options' => ['class' => 'form-control', 'style'=>'width:100px'],
        'clientOptions' => [
            'dateFormat' => 'dd-mm-yy',
        ],
    ]) ?>
        </div>
    </div>
    
    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>


    <?= $form->field($model, 'products')->dropDownList(ProductSearch::getArray(), ['multiple'=>true,
        'size'=>10]);?>           

    
    <?= $form->field($model, 'status')->dropDownList($model::$statuses)?>

    <?= $form->field($model, 'percent')->textInput(['maxlength' => true]) ?>

    <?php if (!$model->isNewRecord) {?>
        <?= Html::img(Url::to('@web/images/').$model->file1, ['style' => 'max-width:500px'])?>
    <?php }?> 
    <?= $form->field($model, 'imageFile1')->fileInput() ?>
    
    <?php if (!$model->isNewRecord) {?>
        <?= Html::img(Url::to('@web/images/').$model->file2, ['style' => 'max-width:500px'])?>
    <?php }?> 
     <?= $form->field($model, 'imageFile2')->fileInput() ?>
    
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
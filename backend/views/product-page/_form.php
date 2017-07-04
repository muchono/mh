<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\tinymce\TinyMce;

/* @var $this yii\web\View */
/* @var $model common\models\ProductPage */
/* @var $form yii\widgets\ActiveForm */
/* @var $product common\models\Product */
?>

<div class="product-page-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'product_id')->hiddenInput(['maxlength' => true, 
        'value' => $model->getProduct()->id])->label(false); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'guide_description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'list_description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'feature1')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'feature2')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'feature3')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'feature4')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'feature5')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'content')->widget(TinyMce::className(), [
        'options' => ['rows' => 26],
        'language' => 'en_GB',
        'clientOptions' => [
            'plugins' => [
                "advlist autolink lists link charmap print preview anchor",
                "searchreplace visualblocks code fullscreen",
                "insertdatetime media table contextmenu paste "
            ],
            'toolbar' => "undo redo | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link",
        ]
        ]);?> 

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

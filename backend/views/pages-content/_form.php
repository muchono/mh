<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\tinymce\TinyMce;
use yii\helpers\Url;

use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model common\models\PagesContent */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pages-content-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

   
    <?= $form->field($model, 'content')->widget(TinyMce::className(), [
    'options' => ['rows' => 26],
    'language' => 'en_GB',
    'clientOptions' => [
        'plugins' => [
            "advlist autolink lists link charmap print preview anchor image",
            "searchreplace visualblocks code fullscreen",
            "insertdatetime media table contextmenu paste"
        ],
        'toolbar' => "undo redo | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
        'paste_data_images'=> new JsExpression('true'),
        'image_advtab'=> new JsExpression('true'),
        'file_picker_callback'=> new JsExpression("function(callback, value, meta) {
            if (meta.filetype == 'image') {
                $('#upload').trigger('click');
                $('#upload').on('change', function() {
                  var file = this.files[0];
                  var reader = new FileReader();
                  reader.onload = function(e) {
                    callback(e.target.result, {
                      alt: ''
                    });
                  };
                  reader.readAsDataURL(file);
                });
            }
        }"),
    ]
    ]);?>     
    <input name="image" type="file" id="upload" class="hidden" onchange="">
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

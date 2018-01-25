<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\web\JsExpression;
use yii\helpers\Url;
use dosamigos\tinymce\TinyMce;

/* @var $this yii\web\View */
/* @var $model common\models\ProductGuide */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-guide-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'product_id')->hiddenInput(['maxlength' => true, 'value' => $model->getProduct()->id])->label(false); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->hiddenInput(['maxlength' => true, 'value' => 1])->label(false); ?>

    <?= $form->field($model, 'about')->widget(TinyMce::className(), [
    'options' => ['rows' => 26],
    'language' => 'en_GB',
    'clientOptions' => [
        'automatic_uploads'=> new JsExpression("true"),
        'plugins' => [
            "advlist autolink lists link image charmap print preview anchor",
            "searchreplace visualblocks code fullscreen",
            "insertdatetime media table contextmenu paste "
        ],
        'content_css' => [
             'css/tinymce.css',
         ],
         'setup' => new JsExpression("
             function (editor) {
               editor.addButton('block', {
                 text: 'block',
                 icon: false,
                 onclick: function () {
                 var text = '<blockquote class=\"blockquote-1\">' + editor.selection.getContent() + '</blockquote>';
                   editor.insertContent(text);
                 }
               });
             }"),        
        'toolbar' => "undo redo | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | block",
        
        'images_upload_url' => Url::to(['product-guide/upload-image'], true),
        'file_picker_types' => 'image',
        'images_upload_credentials' => new JsExpression("true"),
        'file_picker_callback' => new JsExpression("
            function(callback, value, meta) {
                var input = document.createElement('input');
                input.setAttribute('type', 'file');
                input.setAttribute('accept', 'image/*');


                input.onchange = function() {
                    var file = this.files[0];

                    var reader = new FileReader();
                    reader.readAsDataURL(file);
                    reader.onload = function () {
                      var id = 'blobid' + (new Date()).getTime();
                      var blobCache =  tinymce.activeEditor.editorUpload.blobCache;
                      var blobInfo = blobCache.create(id, file, reader.result);
                      blobCache.add(blobInfo);
                      
                        callback(blobInfo.blobUri(), { title: file.name });
                    };
                };

                input.click();
            }
        "),
        
        'images_upload_handler' => new JsExpression("function (blobInfo, success, failure) {
            var xhr, formData;

            xhr = new XMLHttpRequest();
            xhr.withCredentials = false;
            xhr.open('POST', '".Url::to(['product-guide/upload-image'], true)."');

            xhr.onload = function() {
              var json;

              if (xhr.status != 200) {
                failure('HTTP Error: ' + xhr.status);
                return;
              }

              json = JSON.parse(xhr.responseText);

              if (!json || typeof json.location != 'string') {
                failure('Invalid JSON: ' + xhr.responseText);
                return;
              }

              success(json.location);
            };

            formData = new FormData();
            formData.append('".Yii::$app->request->csrfParam."', '".Yii::$app->request->csrfToken."');
            formData.append('file', blobInfo.blob(), blobInfo.filename());
 
            xhr.send(formData);
        }
      ")

    ]
    ]);?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

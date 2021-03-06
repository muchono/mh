<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\tinymce\TinyMce;
use yii\helpers\Url;
use yii\web\JsExpression;

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
    
    <?= $form->field($model, 'link')->textInput(['maxlength' => true]) ?>

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
                "advlist autolink lists link charmap print preview anchor image",
                "searchreplace visualblocks code fullscreen",
                "insertdatetime media table contextmenu paste"
            ],
            'content_css' => [
                'css/tinymce.css',
            ],
            'setup' => new JsExpression("
                function (editor) {
                    editor.ui.registry.addButton('block', {
                        text: 'block',
                        onAction: (buttonApi) => {
                            var text = '<blockquote class=\"blockquote-1\">' + editor.selection.getContent() + '</blockquote>';
                            editor.insertContent(text);

                        }
                    });
                }"),            
            'toolbar' => "undo redo | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | block",            

            'paste_data_images'=> new JsExpression('true'),
            'image_advtab'=> new JsExpression('true'),
            'image_dimensions'=> new JsExpression('false'),
            'convert_urls'=> new JsExpression('true'),
            'relative_urls'=> new JsExpression('false'),
            'remove_script_host'=> new JsExpression('false'), 
            
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
                 xhr.open('POST', '".Url::to(['product-page/upload-image'], true)."');

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
    <input name="image" type="file" id="upload" class="hidden" onchange="">
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

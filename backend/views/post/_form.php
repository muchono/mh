<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\tinymce\TinyMce;
use yii\helpers\Url;

use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model common\models\Post */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="post-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'meta_keywords')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'url_anckor')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'active')->dropDownList($model::$statuses)?>
    
    
    <?php if (!$model->isNewRecord) {?>
        <?= Html::img(Yii::$app->urlManagerFrontend->createUrl('').'images/blog/'.$model->image, ['style' => 'max-width:500px'])?>
    <?php }?> 
    <?= $form->field($model, 'imageFile')->fileInput() ?>    

    <?= $form->field($model, 'categories')->dropDownList(backend\models\PostCategorySearch::getArray(), ['multiple'=>true,
        'size'=>5]);?>    

    <?= $form->field($model, 'meta_description')->textInput(['maxlength' => true]) ?>
    
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
        'convert_urls'=> new JsExpression('true'),
        'relative_urls'=> new JsExpression('false'),
        'remove_script_host'=> new JsExpression('false'),        
        'image_dimensions'=> new JsExpression('false'),        
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
            xhr.open('POST', '".Url::to(['post/upload-image'], true)."');

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
     
    <?= $form->field($model, 'author_name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'author_bio')->widget(TinyMce::className(), [
     'options' => ['rows' => 16],
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
    <?php if (!$model->isNewRecord) {?>
        <?= Html::img(Yii::$app->urlManagerFrontend->createUrl('').'images/blog/'.$model->avatar_image, ['style' => 'max-width:500px'])?>
    <?php }?>     
    <?= $form->field($model, 'imageFileAvatar')->fileInput() ?>

    <div class="form-group">
        <?php if ($model->isNewRecord){ ?>
        <?= Html::submitButton('Create', ['class' => 'btn btn-success']) ?>
        <?php } else {?>
        <?= Html::submitButton('Update', ['class' => 'btn btn-primary']) ?>
        <?= Html::submitButton('Send E-mail To Users', ['class' => 'btn btn-success','name' => 'send', 'value' => 1]) ?>
        <?php }?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

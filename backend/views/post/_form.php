<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\tinymce\TinyMce;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\Post */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="post-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'meta_description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'meta_keywords')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'url_anckor')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'active')->dropDownList($model::$statuses)?>
    
    
    <?php if (!$model->isNewRecord) {?>
        <?= Html::img(Yii::$app->urlManagerFrontend->createUrl('').'images/blog/'.$model->image, ['style' => 'max-width:500px'])?>
    <?php }?> 
    <?= $form->field($model, 'imageFile')->fileInput() ?>    

    <?= $form->field($model, 'categories')->dropDownList(backend\models\PostCategorySearch::getArray(), ['multiple'=>true,
        'size'=>5]);?>    
    
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

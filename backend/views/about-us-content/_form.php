<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\tinymce\TinyMce;

/* @var $this yii\web\View */
/* @var $model common\models\AboutUsContent */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="about-us-content-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
    <?php if (!$model->isNewRecord) {?>
        <?= Html::img(Yii::$app->urlManagerFrontend->createUrl('').'images/aboutus/'.$model->image, ['style' => 'max-width:500px'])?>
    <?php }?> 
    <?= $form->field($model, 'imageFile')->fileInput() ?> 
    
    <?= $form->field($model, 'author_name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'author_bio')->textInput(['maxlength' => true]) ?>

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
    
    <?= $form->field($model, 'href')->dropDownList($model::$hrefs, array('prompt'=>''));?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

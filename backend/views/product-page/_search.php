<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\ProductPageSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-page-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'product_id') ?>

    <?= $form->field($model, 'title') ?>

    <?= $form->field($model, 'description') ?>

    <?= $form->field($model, 'guide_description') ?>

    <?php // echo $form->field($model, 'list_description') ?>

    <?php // echo $form->field($model, 'feature1') ?>

    <?php // echo $form->field($model, 'feature2') ?>

    <?php // echo $form->field($model, 'feature3') ?>

    <?php // echo $form->field($model, 'feature4') ?>

    <?php // echo $form->field($model, 'feature5') ?>

    <?php // echo $form->field($model, 'content') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

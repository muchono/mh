<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\ProductHrefSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-href-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'product_id') ?>

    <?= $form->field($model, 'title') ?>

    <?= $form->field($model, 'url') ?>

    <?= $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'traffic') ?>

    <?php // echo $form->field($model, 'google_pr') ?>

    <?php // echo $form->field($model, 'alexa_rank') ?>

    <?php // echo $form->field($model, 'da_rank') ?>

    <?php // echo $form->field($model, 'about') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

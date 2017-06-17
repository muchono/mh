<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\AboutUsContent */

$this->title = 'Update';
$this->params['breadcrumbs'][] = ['label' => 'About Us Contents', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="about-us-content-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
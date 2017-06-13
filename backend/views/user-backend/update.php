<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\UserBackend */

$this->title = 'Settings';
?>
<div class="user-backend-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

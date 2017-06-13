<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\PagesContent */

$this->title = 'Create Pages Content';
$this->params['breadcrumbs'][] = ['label' => 'Pages Contents', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pages-content-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

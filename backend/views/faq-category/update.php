<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\FaqCategory */

$this->title = 'Update FAQ Category: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'FAQ Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="faq-category-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Faq */

$this->title = 'Update FAQ: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Faqs', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="faq-update">

    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a('FAQ Categories', ['faq-category/index'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

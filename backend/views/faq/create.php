<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Faq */

$this->title = 'Create FAQ';
$this->params['breadcrumbs'][] = ['label' => 'FAQs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="faq-create">

    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a('FAQ Categories', ['faq-category/index'], ['class' => 'btn btn-success', 'target' => '_blank']) ?>
    </p>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

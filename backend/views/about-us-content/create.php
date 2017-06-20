<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\AboutUsContent */

$this->title = 'Create';
$this->params['breadcrumbs'][] = ['label' => 'How It Works', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="about-us-content-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

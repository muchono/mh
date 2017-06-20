<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\PostCategory */

$this->title = 'Create Post Tag';
$this->params['breadcrumbs'][] = ['label' => 'Post Tags', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-category-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

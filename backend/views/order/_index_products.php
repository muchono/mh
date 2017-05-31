<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Order */
/* @var $form yii\widgets\ActiveForm */
?>

<?php foreach($model->products as $p) {?>
<div>
    <?= Html::a($p->title, ['product/update', 'id' => $p->id], ['target' => '_blank']) ?>
</div>
<?php }?>

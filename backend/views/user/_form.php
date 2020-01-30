<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

use yii\data\ArrayDataProvider;
use yii\bootstrap\Tabs;


/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>    
    
    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'active')->dropDownList($model::$statuses)?>
    
    <div class="form-group">
    <label class="control-label" >Password</label>
    
    <?= Html::input('text', 'password', '', ['class' => 'form-control']) ?>

    <div class="help-block"></div>
    </div>
    
    

    <?= $form->field($model, 'subscribe_offers')->checkbox() ?>
    <?= $form->field($model, 'subscribe_blog')->checkbox() ?>
    
    <hr/>
    <?= $form->field($model, 'affiliate')->dropDownList($model::$statuses)?>   
    
    <?php if ($model->affiliate) { ?>
    <?= $form->field($model, 'affiliate_payment')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'affiliate_comission')->textInput(['maxlength' => true]) ?>


    <?php 
    echo Tabs::widget([
        'items' => [
            [
                'label' => 'Common',
                'content' => $this->render('_affiliate_common_tab', ['model' => $model]),
                'active' => true
            ],
            [
                'label' => 'Users',
                'content' => $this->render('_affiliate_users_tab', ['model' => $model]),
            ],
            [
                'label' => 'Payed',
                'content' => $this->render('_affiliate_users_payed.php', ['model' => $model]),
            ],
        ],
    ]);
    ?>    
    
<?php }?> 
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php

use yii\web\View;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

?>
<section class="simple-page sm">
          <?= $this->render('_menu', [
    ]) ?>      
      
          <?php if ($changed){?>
      <div class="message-page">
        <h1 class="mp__title mp__title--success">Password changed successfully.</h1>
        <figure class="mp__img">
          <img src="<?=Url::base()?>/img/msg-success-img.jpg" alt="" class="img-fluid">
        </figure>
      </div>          
          <?php } else {?>
      
      <h2 class="title-14">Change Password:</h2>
          <?php 
      $form = ActiveForm::begin([]); ?>  
      <div class="account-info">

        <div class="account-field-row">
          <div class="account-field">
            <label for="" class="bf__label">Old Password</label>
            <?= $form->field($changePasswordForm, 'old_password')->textInput(['class' => 'bf__input'])->label(false) ?>
          </div>
        </div>
        <div class="account-field-row">
          <div class="account-field">
            <label for="" class="bf__label">New Password</label>
            <?= $form->field($changePasswordForm, 'new_password')->textInput(['class' => 'bf__input'])->label(false) ?>
            <span class="bf__info">(minimum length 7 characters)</span>
          </div>
        </div>
        <div class="account-field-row">
          <div class="account-field">
            <label for="" class="bf__label">Confirm New Password</label>
            <?= $form->field($changePasswordForm, 'confirm_password')->textInput(['class' => 'bf__input'])->label(false) ?>
            <span class="bf__info">(password and confirmation match)</span>
          </div>
        </div>
      </div>

      <div class="account-foot">
        <button class="btn-8">Update  Password</button>
      </div>
    <?php ActiveForm::end(); ?> 
      <?php } ?>
    </section>
<?php

use yii\web\View;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

?>
<section class="simple-page sm">
      <h2 class="title-14">My Account</h2>
          <?= $this->render('_menu', [
    ]) ?>
      <h2 class="title-14">Edit Profile:</h2>
      <div class="youremail">
        <div class="youremail__title">Email</div>
        <p class="youremail__text"><?=$user->email?></p>
      </div>
    <?php 
      $form = ActiveForm::begin([
     'enableClientValidation' => false,
     'enableAjaxValidation' => false,          
        ]); ?>      
      <div class="account-info">
        <div class="account-field-row">
          <div class="account-field">
            <label for="" class="bf__label">Full Name</label>
            <?= $form->field($userBilling, 'full_name')->textInput(['class' => 'bf__input'])->label(false) ?>
            <span class="bf__info">(for individuals only)</span>
          </div>
          <div class="account-field account-field--auto">
            <span class="bf__or">or</span>
          </div>
          <div class="account-field">
            <label for="" class="bf__label">Company Name</label>
            <?= $form->field($userBilling, 'company_name')->textInput(['class' => 'bf__input'])->label(false) ?>
            <span class="bf__info">(for legal entities only)</span>
          </div>
        </div>
        <div class="billing-field-row">
          <div class="billing-field">
            <label for="" class="bf__label">Email</label>
            <?= $form->field($userBilling, 'email')->textInput(['class' => 'bf__input'])->label(false) ?>            
            <span class="bf__info">(to this email you will get payment confirmation letter)</span>
          </div>
        </div>          
        <div class="account-field-row">
          <div class="account-field">
            <label for="" class="bf__label">Phone Number</label>
            <?= $form->field($userBilling, 'phone_number')->textInput(['class' => 'bf__input'])->label(false) ?>
            <span class="bf__info">(to this phone number you will get SMS code)</span>
          </div>
        </div>
        <div class="account-field-row">
          <div class="account-field">
            <label for="" class="bf__label">Country</label>
            <?= $form->field($userBilling, 'country')
              ->dropDownList(ArrayHelper::map(common\models\Countries::find()->all(), 'id', 'country_name'), ['class'=>'bf__input'])->label(false);?>
            
          </div>
        </div>
        <div class="account-field-row">
          <div class="account-field">
            <label for="" class="bf__label">Address</label>
            <?= $form->field($userBilling, 'address')->textInput(['class' => 'bf__input'])->label(false) ?>
          </div>
        </div>
        <div class="account-field-row">
          <div class="account-field">
            <label for="" class="bf__label">Postal Code</label>
            <?= $form->field($userBilling, 'zip')->textInput(['class' => 'bf__input'])->label(false) ?>
          </div>
        </div>
        <div class="account-field-row">
          <div class="account-field">
            <label for="" class="bf__label">City</label>
            <?= $form->field($userBilling, 'city')->textInput(['class' => 'bf__input'])->label(false) ?>
          </div>
        </div>
        <div class="account-cb-field-row">
          <div class="account-cb-field">
            <input type="checkbox" id="bfcb-1" class="bfcb__input" name="UserBilling[subscribe_offers]" <?=$userBilling->subscribe_offers ? 'checked' : ''?> value="1">
            <label for="bfcb-1" class="bfcb__label">Receive e-mails with free offers, special offers, discounts and new products</label>
          </div>
          <div class="account-cb-field">
              <input type="checkbox" id="bfcb-2" class="bfcb__input" name="UserBilling[subscribe_blog]"  <?=$userBilling->subscribe_blog ? 'checked' : ''?> value="1">
            <label for="bfcb-2" class="bfcb__label">Receive e-mails with MarketingHack blog’s news</label>
          </div>
        </div>
      </div>

      <div class="account-foot">
        <button class="btn-8">Save  Information</button>
      </div>        
    
          <?php ActiveForm::end(); ?> 
    </section>
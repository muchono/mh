<?php
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use yii\helpers\Url;

?>
<div class="mh-popup mfp-hide aut-popup" id="login-popup">
    <h2 class="aut-title">Log In</h2>
    <?php 
    Pjax::begin([
      // Pjax options
    ]);
    $formLogin = ActiveForm::begin([
      'options' => ['data' => ['pjax' => true]],
      ]); ?>      
    <div class="aut-fields">
      <div class="aut-field">
        <?= $formLogin->field($this->params['user_login'], 'email')->textInput(['class' => 'aut-input','placeholder' => 'Email'])->label(false) ?>
      </div>
      <div class="aut-field">
        <?= $formLogin->field($this->params['user_login'], 'password')->passwordInput(['class' => 'aut-input','placeholder' => 'Password'])->label(false) ?>
      </div>
    </div>
    <a href="" class="aut-link">Forgot your password?</a>
    <button class="btn-5">Login</button>
    <a href="#signup-popup" class="aut-link js-popups">Don't have an account?</a>
    <input type="hidden" name="login" value="existing-user"/>
    <?php ActiveForm::end(); 
    Pjax::end();?>       
  </div>

  <div class="mh-popup mfp-hide aut-popup" id="signup-popup">
    <h2 class="aut-title">Sign Up</h2>
    <a href="#login-popup" class="aut-link js-popups">Already have an account?</a>
    <?php 
    Pjax::begin([
      // Pjax options
    ]);
    $form = ActiveForm::begin([
      'options' => ['data' => ['pjax' => true]],
      ]); ?>                          
    <div class="aut-fields">
      <div class="aut-field">
        <?= $form->field($this->params['user'], 'name')->textInput(['class' => 'aut-input','placeholder' => 'Name'])->label(false) ?>
      </div>
      <div class="aut-field">
        <?= $form->field($this->params['user'], 'email')->textInput(['class' => 'aut-input','placeholder' => 'Email'])->label(false) ?>
      </div>
      <div class="aut-field">
        <?= $form->field($this->params['user'], 'password')->passwordInput(['class' => 'aut-input','placeholder' => 'Password'])->label(false) ?>
      </div>
        <input type="hidden" name="register" value="new-user"/>
    </div>
    <button class="btn-5">Register</button>
    <p class="aut-text">By clicking Register you agree <br>to our <a href="<?=Url::to(['site/terms']);?>">terms and conditions</a></p>
    <?php ActiveForm::end(); 
    Pjax::end();?>    
  </div>
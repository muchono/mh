<?php
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\captcha\Captcha;
use yii\web\View;
?>
<div class="mh-popup mfp-hide aut-popup" id="forgot-popup">
    <h2 class="aut-title">Forgot Password</h2>
    <?php 
    Pjax::begin([
      // Pjax options
    ]);
    $formForgot = ActiveForm::begin([
      'options' => ['data' => ['pjax' => true]],
      ]); ?>      
    <div class="aut-fields">
      <div class="aut-field">
        <?= $formForgot->field($this->params['user_forgot'], 'email')->textInput(['class' => 'aut-input','placeholder' => 'Email'])->label(false) ?>
      </div>
        <div class="df__field" id="captcha_block" >
        <?= $formForgot->field($this->params['user_forgot'], 'verifyForgotCode')->label(false)
              ->widget(Captcha::className(), [
            'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
            'options' => ['placeholder' => 'code', 'class' => 'df__input']
        ]) ?>    
        </div>        
    </div>
    <button class="btn-5">Submit</button>
    <a href="#signup-popup" class="aut-link js-popups" id="signup-popup-link">Don't have an account?</a>
    <input type="hidden" name="forgot" value="existing-user"/>
    <?php ActiveForm::end(); 
    Pjax::end();?>       
  </div>

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
    <a href="#forgot-popup" class="aut-link js-popups" id="forgot-popup-link">Forgot your password?</a>
    <button class="btn-5">Login</button>
    <a href="#signup-popup" class="aut-link js-popups" id="signup-popup-link">Don't have an account?</a>
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
      <div class="aut-field" id="captcha_reg_block" style="display:<?=$this->params['user']->name ? 'block' : 'none'?>">
            <?= $form->field($this->params['user'], 'verifyCode')->label(false)
                  ->widget(Captcha::className(), [
                'template' => '<div class="row"><div class="col-lg-3">{image} <div class="captcha-info-text">press to update</div></div><div class="aut-field">{input}</div></div>',
                'options' => ['placeholder' => 'code', 'class' => 'aut-input']
            ]) ?> 
      </div>        
        
        <input type="hidden" name="register" value="new-user"/>
    </div>
    <div style="margin-left:110px">
        <div class="loader hide"></div>
    </div>
    <button class="btn-5">Register</button>
    <p class="aut-text">By clicking Register you agree <br>to our <a href="<?=Url::to(['site/terms']);?>">terms and conditions</a></p>
    <?php ActiveForm::end(); 
    Pjax::end();?>    
  </div>
<?php
$this->registerJs(
    "$('#signupform-name').change(function(event){"
        . "$('#captcha_reg_block').show(); "
        . "$('#signupform-verifycode').click(); "
        . "});
    $('#signup-popup').on('pjax:beforeSend', function() {
        $('#signup-popup button').hide();
        $('.loader').show();
    });
    "
,
    View::POS_READY,
    'register-handler'
);
?>
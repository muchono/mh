<?php

use yii\helpers\Url;

use yii\widgets\ActiveForm;
use yii\captcha\Captcha;


/* @var $this yii\web\View */

$this->title = 'Support';
?>
<section class="simple-page sm">
      <div class="breadcrumbs-2">
        <ul class="breadcrumbs-2__list">
          <li class="breadcrumbs-2__item">
            <a href="<?=Url::to(['site/index'])?>" class="breadcrumbs-2__link">MarketingHack</a>
          </li>
          <li class="breadcrumbs-2__item">
            <span class="breadcrumbs-2__text">Support</span>
          </li>
        </ul>
      </div>
      <h1 class="title-17">Support</h1>
      <div class="search-questions search-questions--group">
        <?php $form = ActiveForm::begin(); ?>
        <nowrap><input type="text" name="keywords" class="search-questions__input support-questions__input" placeholder="Search for your questions"><button class="search-questions__btn">Search</button></nowrap>
        <?php ActiveForm::end(); ?>
      </div>
      <h2 class="title-15">Customers often ask:</h2>
      <ul class="ask-list">
          <?php foreach($faqs as $f){?>
        <li class="ask-list__item"><a href="<?=Url::to(['site/faq', 'id' => $f->id])?>" class="ask-list__link"><?=$f->title?></a></li>
          <?php }?>
      </ul>
      <h2 class="title-15">Ask support:</h2>
      <?php $form = ActiveForm::begin(['id' => 'support-form', 'class' => 'ask-form']); ?>
        <div class="ask-form__field">
          <label for="" class="ask-form__label">Name</label>
          <?= $form->field($model, 'name')->textInput(['class' => 'ask-form__input'])->label(false) ?>
        </div>
        <div class="ask-form__field">
          <label for="" class="ask-form__label">Email</label>
          <?= $form->field($model, 'email')->textInput(['class' => 'ask-form__input'])->label(false) ?>
        </div>
        <div class="ask-form__field">
          <label for="" class="ask-form__label">Subject</label>
        <?= $form->field($model, 'subject')
              ->dropDownList(frontend\models\SupportQuestion::$subjects, ['class'=>'ask-form__input'])->label(false);?>         
        </div>
        <div class="ask-form__field">
          <label for="" class="ask-form__label">Short question (in a few words)</label>
          <?= $form->field($model, 'short_question')->textInput(['class' => 'ask-form__input ask-form__input--full'])->label(false) ?>
        </div>
        <div class="ask-form__field">
          <label for="" class="ask-form__label">Message</label>
          <?= $form->field($model, 'message')->textArea(['class' => 'ask-form__textarea ask-form__textarea--full'])->label(false) ?>
        </div>
        <div class="ask-form__field">
            <label for="" class="ask-form__label">Verification Code</label>
                <?= $form->field($model, 'verifyCode')->label(false)
                      ->widget(Captcha::className(), [
                    'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
                    'options' => ['placeholder' => 'CAPTCHA Code', 'class' => 'ask-form__input']
                ]) ?>      
        </div>
        <div class="ask-form__foot">
          <button class="btn-2">Submit Review</button>
        </div>
        <?php ActiveForm::end(); ?>
    </section>

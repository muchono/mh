<?php

/* @var $this yii\web\View */
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\captcha\Captcha;
use yii\web\View;
use yii\widgets\Pjax;

$this->title = 'Home';
?>
<header class="home-header">
      <div class="container">
        <div class="row">
          <div class="hh__hero">
            <h1 class="hh__title"><strong>Get access to the data</strong> <br>that will change your understanding <br>of Successful Marketing</h1>
            <p class="hh__text">MarcketingHack.net contains step-by-step recommendations, cases, secrete methods and lists of proven websites. This information will allow a practicing marketers to leave far behind their competitors. </p>
          </div>
          <div class="hh__form">
            <div class="demo-form">
                <h2 class="df__title">Get a Free Demo</h2>
              <?php 
              Pjax::begin([
                // Pjax options
              ]);
              $form = ActiveForm::begin([
                'options' => ['data' => ['pjax' => true]],
                ]); ?>
                
                <div class="df__field">
                  <?= $form->field($getDemoModel, 'name')->textInput(['class' => 'df__input','placeholder' => 'Name'])->label(false) ?>
                </div>
                <div class="df__field">
                  <?= $form->field($getDemoModel, 'email')->textInput(['class' => 'df__input','placeholder' => 'E-mail'])->label(false) ?>
                </div>
                <div class="df__field" id="captcha_block" style="display:none">
                <?= $form->field($getDemoModel, 'verifyCode')->label(false)
                      ->widget(Captcha::className(), [
                    'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
                    'options' => ['placeholder' => 'code', 'class' => 'df__input']
                ]) ?>    
                </div>
                <p class="df__text">(We’ll never spam your email)</p>
                <button class="btn-1">Get Demo</button>
                <p class="df__text"><strong>It's free</strong> and no credit card required</p>
              <?php ActiveForm::end(); 
              Pjax::end();?>
            </div>
          </div>
        </div>
      </div>
    </header>
    
    <section class="bestsellers">
      <div class="container">
        <div class="bs-head">
          <h2 class="title-1">MarketngHack Bestsellers</h2>
          <p class="bs-head__text">Each product consists of <strong>Guide</strong> + <strong>Digital Subscription</strong> for 1 year.</p>
        </div>
        <div class="bs-list">
          <?php foreach($products as $p) {?>
          <div class="bs-list__item">
            <div class="product">
              <div class="pd__head">
                <div class="pd__text-1"><?=$p->short_title?></div>
                <a href="<?=Url::to(['site/product','product_id'=>$p->id])?>"><h3 class="title-2"><?=$p->title?></h3></a>
                <div class="pd__text-2"><?=$p->full_title?></div>
                <i class="icon-<?=($p->priceFinal) ? 1 : 2?>"></i>
              </div>
              <div class="pd__content">
                <ul class="list-1">
                <?php foreach($p->guide as $g) {?>
                  <li><?=$g->title?></li>
                <?php }?>
                </ul>
                <a href="<?=Url::to(['site/product','product_id'=>$p->id])?>" class="pd__more">Learn more</a>
              </div>
              <div class="pd__foot">
                <?php if (!$p->priceFinal){?>
                <div class="pd-on">
                  FREE Now
                </div>
                <?php } elseif ($p->discount){?>
                <div class="pd-off">
                  <strong><?=$p->discount->percent?><sup>%</sup></strong>
                  Discount
                </div>
                <?php } else {?>                  
                <div class="pd__foot-item">
                </div>
                <?php }?>
                  
                <div class="pd-try">
                  <?php if ($p->discount){?>
                  <span class="pd-try__price pd-try__price--discount">$<?=$p->price?></span>
                      <?php if ($p->priceFinal){?>
                  <span class="pd-try__discount-price">$<?=$p->priceFinal?></span>
                      <?php }?>
                  <?php } else {?>
                  <span class="pd-try__price">$<?=$p->priceFinal?></span>
                  <?php } ?>
                  <span class="pd-try__add">                
                    <i class="icon-3"></i>
                  </span>
                  <a href="" class="btn-sm-1">try demo</a>
                </div>
              </div>
            </div>
          </div>
          <?php }?>
        </div>
        <div class="bs-more">
          <a href="<?=Url::to(['site/products'])?>" class="btn-2">View More Bestsellers</a>
        </div>
      </div>
    </section>
    
    <section class="statistics">
      <div class="container">
        <h2 class="title-3">MarketingHack Statistics</h2>
        <div class="st-row">
          <div class="st-col">
            <strong><?=$productsCount?></strong>
            Products <br>Launched
          </div>
          <div class="st-col">
            <strong>12</strong>
            Products <br>Updates
          </div>
          <div class="st-col">
            <strong><?=$hrefsCount?></strong>
            Websites <br>for Using
          </div>
          <div class="st-col">
            <strong><?=$usersCount?></strong>
            Total <br>Users
          </div>
        </div>
      </div>
    </section>
    
    <section class="press-about-us">
      <div class="container">
        <h2 class="title-1 text-center">Press About Us</h2>
        <div class="pas-slider js-carousel" data-dots="true" data-dotsclass="dots-1" data-infinite="true" data-speed="300" data-slides="1">
          <?php foreach ($aboutUsContent as $i) { 
              if ($i->href != 'type1') continue;?>
          <div>
            <div class="pas__item">
              <div class="pas__logo">
                <img src="images/aboutus/<?=$i->image?>" class="img-fluid" alt="">
              </div>
              <div class="pas__content">
                <i class="icon-4"></i>
                <p class="pas__text"><?=$i->content?></p>
                <a href="" class="pas__link">Read more</a>
              </div>
            </div>
          </div>
          <?php }?>
        </div>
      </div>
    </section>
    
    <section class="testimonials">
      <div class="container">
        <h2 class="title-1 text-center">What People Think About Us</h2>
        <div class="tst-slider js-carousel" data-dots="true" data-dotsclass="dots-2" data-infinite="true" data-slides="3" data-speed="300" data-adaptiveheight="true">
          <?php foreach ($aboutUsContent as $i) { 
              if ($i->href != 'type2') continue;?>            
          <div>
            <div class="tst__item">
              <div class="tst__content">
                <p class="tst__text"><?=$i->content?></p>
              </div>
              <div class="tst__user">
                <img src="images/aboutus/<?=$i->image?>" class="tst__ava" alt="">
                <div class="tst__info">
                  <h3><?=$i->author_name?></h3>
                  <p><?=$i->author_bio?></p>
                </div>
              </div>
            </div>
          </div>
            <?php }?>
        </div>
      </div>
    </section>
    <section class="create-account">
      <div class="container">
        <p class="ca__text-1">Get access to actual websites lists and step-by-step guides right now! </p>
        <p class="ca__text-2">- go through the registration and get the access to demo versions of all our products.</p>
        <a href="#signup-popup" class="btn-3 js-popups">Create Your Account</a>
        <p class="ca__text-3">Registration is free <br>and will take you a few minutes.</p>
      </div>
    </section>
<?php
$this->registerJs(
    "$('#getdemoform-name').change(function(event){"
        . "$('#captcha_block').show();"
        . "})",
    View::POS_READY,
    'get-demo-handler'
);
?>
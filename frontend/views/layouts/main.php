<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use yii\web\View;

use frontend\assets\AppAsset;
use common\widgets\Alert;

use common\models\Product;



AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
  <meta charset="<?= Yii::$app->charset ?>">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <?= Html::csrfMetaTags() ?>
  <title><?= Html::encode($this->title) ?></title>

  <meta name="keywords" content="HTML5 Template" />
  <meta name="description" content="Responsive HTML5 Template">

  <!-- Favicon -->
  <!-- <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon" />
  <link rel="apple-touch-icon" href="img/apple-touch-icon.png"> -->

  <!-- Mobile Metas -->
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Web Fonts  -->
  <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900|Open+Sans:300,400,600,700|PT+Sans:400,700" rel="stylesheet">

  <!-- Vendor CSS -->
  <link rel="stylesheet" href="<?=Url::base()?>/fonts/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="<?=Url::base()?>/vendor/slick-carousel/slick/slick.css">
  <link rel="stylesheet" href="<?=Url::base()?>/vendor/magnific-popup/dist/magnific-popup.css">

  <!-- Head Libs -->
  <!-- <script src="bower_components/modernizr/modernizr.js"></script> -->    
   <?php $this->head() ?>
   <script id="mcjs">!function(c,h,i,m,p){m=c.createElement(h),p=c.getElementsByTagName(h)[0],m.async=1,m.src=i,p.parentNode.insertBefore(m,p)}(document,"script","https://chimpstatic.com/mcjs-connected/js/users/8752e8f12b6b871d82830d027/712da38dc210c72b9987101eb.js");</script>
</head>

<body>
<?php $this->beginBody() ?>
  <div class="<?=$this->params['layout_style'] ? $this->params['layout_style'] : 'simple-page-layout'?>  <?php if ($this->params['head_offer']){?>discount-line--add<?php }?>">
    <div class="top-bar">
        <?php if ($this->params['head_offer']){?>
      <div class="discount-line">
        <span><?=$this->params['head_offer']->title?></span>
        <a href="<?=Url::to(['site/product', 'link'=>$this->params['head_offer']->products[0]->page->link]);?>" class="btn-7">Check now</a>
        <a href="" class="dl__close" id="head_offer_close"><i class="icon-15"></i></a>
      </div>
        <?php }?>
      <div class="top-bar__inner">
      <a href="" class="menu-btn js-side-menu-btn">
        <span></span>
      </a>
      <div class="logo">
        <a href="<?=Url::home();?>" class="logo__link"><img src="<?=Url::base()?>/img/main-logo.png" alt="" class="img-fluid"></a>
      </div>
      <nav class="main-nav">
        <ul class="main-nav__list">
         <?php if (Yii::$app->user->isGuest){?>
          <li class="main-nav__item"><a href="<?=Url::home();?>" class="main-nav__link <?=($this->params['page'] == 'home') ? 'main-nav__link--active' : ''?>">Home</a></li>
          <li class="main-nav__item"><a href="<?=Url::to(['how-it-works/']);?>" class="main-nav__link <?=($this->params['page'] == 'hiw') ? 'main-nav__link--active' : ''?>">How It Works</a></li>
        <?php } else {?>
          <li class="main-nav__item"><a href="<?=Url::to(['content/']);?>" class="main-nav__link <?=($this->params['page'] == 'content') ? 'main-nav__link--active' : ''?>">Check Products</a></li>
        <?php }?>
          <li class="main-nav__item"><a href="<?=Url::to(['products/']);?>" class="main-nav__link <?=($this->params['page'] == 'products') ? 'main-nav__link--active' : ''?>">Products</a></li>
        <?php if ($this->params['offer_menu']){?>          
          <li class="main-nav__item"><a href="<?=Url::to(['special-offer/']);?>" class="main-nav__link <?=($this->params['page'] == 'special-offer') ? 'main-nav__link--active' : ''?>">Special Offers</a></li>
          <?php }?>
          <li class="main-nav__item"><a href="<?=Url::to(['faq/']);?>" class="main-nav__link <?=($this->params['page'] == 'faq') ? 'main-nav__link--active' : ''?>">F.A.Q.</a></li>
          <li class="main-nav__item"><a href="<?=Url::to(['support/']);?>" class="main-nav__link <?=($this->params['page'] == 'support') ? 'main-nav__link--active' : ''?>">Support</a></li>
          <!--
          <li class="main-nav__item"><a href="<?=Url::to(['blog/']);?>" class="main-nav__link <?=($this->params['page'] == 'blog') ? 'main-nav__link--active' : ''?>">Blog</a></li>-->
        </ul>
      </nav>

      <div class="user-pane">
        <?php if (Yii::$app->user->isGuest){?>
        <a href="#login-popup" class="up__btn js-popups" id="loginhref">Log In</a>
        <a href="#signup-popup" class="up__btn js-popups">Sign Up</a>
        <?php } else { ?>        
          <div class="user-pane__drop js-toggle" data-toggle="user-pane__drop--open">
            <span class="up__btn">My Account</span>
            <ul class="drop-list">
              <li class="drop-list__item">
                <a href="<?=Url::to(['account/index']);?>" class="drop-list__link">
                <i class="fa fa-shopping-basket" aria-hidden="true"></i>
                My Products</a>
              </li>
              <li class="drop-list__item">
                <a href="<?=Url::to(['account/profile']);?>" class="drop-list__link">
                <i class="fa fa-cog" aria-hidden="true" style="font-size: 16px;"></i>
                Edit Profile</a>
              </li>
              <li class="drop-list__item">
                <a href="<?=Url::to(['account/orders']);?>" class="drop-list__link">
                <i class="fa fa-file-text" aria-hidden="true"></i>
                Order History</a>
              </li>
              <li class="drop-list__item">
                <a href="<?=Url::to(['account/change']);?>" class="drop-list__link">
                <i class="fa fa-lock" aria-hidden="true" style="font-size: 15px;"></i>
                Change Password</a>
              </li>
              <li class="drop-list__item">
                <a href="<?=Url::to(['account/logout']);?>" class="drop-list__link">
                <i class="fa fa-sign-out" aria-hidden="true" style="font-size: 14px;"></i>
                Logout</a>
              </li>
            </ul>
          </div>
          <a href="<?=Url::to(['cart/index']);?>" class="up__btn up__btn--cart">
            <i class="icon-17"></i>
            <span id="cart_items"><?=$this->params['cart_items']?></span>
          </a>
        <?php }?>
      </div>
    
    </div>
    </div>

    <div class="side-menu js-side-menu">
      <div class="sm__top">
        <a href="" class="sm-btn"><i class="icon-5"></i></a>
      </div>
      <div class="sm__content">
        <h3 class="sm-title">Menu</h3>
        <ul class="sm-list-2">
         <?php if (Yii::$app->user->isGuest){?>
          <li class="sm-list-2__item">
            <a href="<?=Url::home();?>" class="sm-list-2__link">Home</a>
          </li>
          <li class="sm-list-2__item">
            <a href="<?=Url::to(['hiw/']);?>" class="sm-list-2__link">How It Works</a>
          </li>
        <?php } else {?>
          <li class="sm-list-2__item">
            <a href="<?=Url::to(['content/']);?>" class="sm-list-2__link">Check Products</a>
          </li>          
        <?php }?>
          <li class="sm-list-2__item">
            <a href="<?=Url::to(['products/']);?>" class="sm-list-2__link">Products</a>
          </li>          
        <?php if ($this->params['offer_menu']){?>          
          <li class="sm-list-2__item">
            <a href="<?=Url::to(['special-offer/']);?>" class="sm-list-2__link">Special Offers</a>
          </li>          
          <?php }?>
          <li class="sm-list-2__item">
            <a href="<?=Url::to(['faq/']);?>" class="sm-list-2__link">F.A.Q.</a>
          </li>
          <li class="sm-list-2__item">
            <a href="<?=Url::to(['support/']);?>" class="sm-list-2__link">Support</a>
          </li>
          <li class="sm-list-2__item">
            <a href="<?=Url::to(['blog/']);?>" class="sm-list-2__link">Blog</a>
          </li>
          <?php if (!Yii::$app->user->isGuest){?>
          <li class="sm-list-2__item">
            <a href="<?=Url::to(['account/change']);?>" class="sm-list-2__link">My Account</a>
          </li>
          <li class="sm-list-2__item">
            <a href="<?=Url::to(['cart/index']);?>" class="sm-list-2__link">Cart</a>
          </li>          
          <li class="sm-list-2__item">
            <a href="<?=Url::to(['account/logout']);?>" class="sm-list-2__link">Logout</a>
          </li>
           <?php }?>
        </ul>
      </div>
      <div class="sm__bottom">
        <a href="" class="sm-btn"><i class="icon-5"></i></a>
      </div>
    </div>
    <?= $content ?>

<?php if (isset($this->params['social-panel']) && $this->params['social-panel']) {?>
<div class="social-pane">
      <ul class="sp__list">
        <li class="sp__item">
            <a href="https://www.facebook.com/MarketingHackNet/" class="sp__link" target="_blank">
            <i class="fb"></i>
          </a>
        </li>
        <li class="sp__item">
          <a href="https://twitter.com/MarketingHackTw" class="sp__link" target="_blank">
            <i class="tw"></i>
          </a>
        </li>
        <li class="sp__item">
          <a href="https://www.pinterest.com/MarketingHack/" class="sp__link" target="_blank">
            <i class="pt"></i>
          </a>
        </li>
      </ul>
    </div>
<?php }?>
    <footer class="main-footer">
      <div class="mf__content">
        <div class="container">
          <div class="mfc__row">
            <div class="mf-info">
              <div class="mf-logo">
                <a href=""><img src="<?=Url::base()?>/img/main-logo.png" alt="" class="img-fluid"></a>
              </div>
              <p class="mf-copy">Copyright © <?=date('Y')?>. MarketingHack.net. All rights reserved.</p>
              <p class="mf-text">We use electronic cookies as part of our normal business operations. By using this website, we assume you are happy with this. </p>
            </div>
            <div class="mf-menu">
              <h3 class="mf-title">Company</h3>
              <nav class="mf-nav">
                <ul class="mf__list">
                  <li class="mf__item"><a href="<?=Url::to(['site/hiw']);?>" class="mf__link">How it Works</a></li>
                  <li class="mf__item"><a href="<?=Url::to(['site/products']);?>" class="mf__link">Products</a></li>
                  <li class="mf__item"><a href="<?=Url::to(['site/special-offer']);?>" class="mf__link">Special Offers</a></li>
                  <li class="mf__item"><a href="<?=Url::to(['site/faq']);?>" class="mf__link">F.A.Q.</a></li>
                  <li class="mf__item"><a href="<?=Url::to(['terms-of-use/']);?>" class="mf__link">Terms of Use</a></li>
                  <li class="mf__item"><a href="<?=Url::to(['privacy-policy/']);?>" class="mf__link">Privacy Policy</a></li>
                  <!--<li class="mf__item"><a href="<?=Url::to(['blog/']);?>" class="mf__link">Blog</a></li>-->
                </ul>
              </nav>
            </div>
            <div class="mf-products">
              <h3 class="mf-title">Products</h3>
              <ul class="mf__list">
                <?php foreach (Product::find()->where(['status' => 1])->limit(5)->all() as $p) {?>
                <li class="mf__item">
                  <a href="<?=Url::to(['site/product','link'=>$p->page->link])?>" class="mf__link"><?=$p->links_available ? $p->getHrefsCount() : ''?>  <?=$p->title?></a>
                </li>
                <?php }?>
              </ul>
            </div>
            <div class="mf-contacts">
              <h3 class="mf-title">Contact Info</h3>
              <ul class="mf__list">
                  <!--
                <li class="mf__item">
                  <a href="<?=Url::to(['site/contact']);?>" class="mf__link">Contact Us</a>
                </li>-->
                <li class="mf__item">
                  <a href="<?=Url::to(['site/support']);?>" class="mf__link">Support</a>
                </li>
                <li class="mf__item">
                  <a href="https://www.facebook.com/MarketingHackNet/" class="mf__link">Facebook</a>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <div class="mf__foot">
        <div class="container">
          <ul class="payment-list">
            <li class="payment-list__title">Secure Payment:</li>
            <li><i class="maestro-ic"></i></li>
            <li><i class="visa-ic"></i></li>
            <li><i class="ae-ic"></i></li>
            <li><i class="bitcoin-ic"></i></li>
            <li><i class="webmoney-ic"></i></li>
          </ul>
        </div>
      </div>
    </footer>
  </div>

<?= $this->renderFile('@frontend/views/layouts/_signup.php', []) ?>

<?php $this->endBody() ?>
  <!-- Vendor -->
  <script src="<?=Url::base()?>/vendor/magnific-popup/dist/jquery.magnific-popup.min.js"></script>
  <script src="<?=Url::base()?>/vendor/slick-carousel/slick/slick.min.js"></script>

  <!-- Theme Base -->
  <script src="<?=Url::base()?>/js/main.js"></script>    
  <?php
  if (Yii::$app->request->get('show_login')) {
    $this->registerJs(
        "$('#loginhref').click();",
        View::POS_READY,
        'login-button-handler'
    );  
  }
  ?>
<script>
setInterval(function(){
    $.get( "<?=Url::to(['site/some'])?>", function(data) {});
}, 300000);
</script>  
</body>
</html>
<?php $this->endPage() ?>

<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use yii\helpers\Url;

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
  <link rel="stylesheet" href="vendor/slick-carousel/slick/slick.css">
  <link rel="stylesheet" href="vendor/magnific-popup/dist/magnific-popup.css">

  <!-- Theme CSS -->
  <link rel="stylesheet" href="css/main.css">

  <!-- Head Libs -->
  <!-- <script src="bower_components/modernizr/modernizr.js"></script> -->    
   <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
  <div class="<?=$this->params['layout_style'] ? $this->params['layout_style'] : 'simple-page-layout'?>">
    <div class="top-bar">
      <a href="" class="menu-btn js-side-menu-btn">
        <span></span>
      </a>
      <div class="logo">
        <a href="" class="logo__link"><img src="img/main-logo.png" alt="" class="img-fluid"></a>
      </div>
      <nav class="main-nav">
        <ul class="main-nav__list">
          <li class="main-nav__item"><a href="<?=Url::to(['site/index']);?>" class="main-nav__link <?=($this->params['page'] == 'home') ? 'main-nav__link--active' : ''?>">Home</a></li>
          <li class="main-nav__item"><a href="<?=Url::to(['site/hiw']);?>" class="main-nav__link <?=($this->params['page'] == 'hiw') ? 'main-nav__link--active' : ''?>">How It Works</a></li>
          <li class="main-nav__item"><a href="<?=Url::to(['site/products']);?>" class="main-nav__link <?=($this->params['page'] == 'products') ? 'main-nav__link--active' : ''?>">Products</a></li>
          <li class="main-nav__item"><a href="<?=Url::to(['site/special-offer']);?>" class="main-nav__link <?=($this->params['page'] == 'special-offer') ? 'main-nav__link--active' : ''?>">Special Offers</a></li>
          <li class="main-nav__item"><a href="<?=Url::to(['site/faq']);?>" class="main-nav__link <?=($this->params['page'] == 'faq') ? 'main-nav__link--active' : ''?>">F.A.Q.</a></li>
          <li class="main-nav__item"><a href="<?=Url::to(['site/support']);?>" class="main-nav__link <?=($this->params['page'] == 'support') ? 'main-nav__link--active' : ''?>">Support</a></li>
          <li class="main-nav__item"><a href="<?=Url::to(['blog/index']);?>" class="main-nav__link <?=($this->params['page'] == 'blog') ? 'main-nav__link--active' : ''?>">Blog</a></li>
        </ul>
      </nav>
      <div class="user-pane">
        <a href="#login-popup" class="up__btn js-popups">Log In</a>
        <a href="#signup-popup" class="up__btn js-popups">Sign Up</a>
      </div>
    </div>

    <div class="side-menu js-side-menu">
      <div class="sm__top">
        <a href="" class="sm-btn"><i class="icon-5"></i></a>
      </div>
      <div class="sm__content">
        <ul class="sm-list-1">
          <li class="sm-list-1__item sm-list-1__item--unblock">
            <a href="" class="sm-list-1__link">Forum Link Building Techniques</a>
          </li>
          <li class="sm-list-1__item sm-list-1__item--unblock sm-list-1__item--active">
            <a href="" class="sm-list-1__link">Q&amp;A Link Building Techniques</a>
          </li>
          <li class="sm-list-1__item sm-list-1__item--unblock">
            <a href="" class="sm-list-1__link">Guest Posting Marcketing </a>
          </li>
          <li class="sm-list-1__item sm-list-1__item--unblock">
            <a href="" class="sm-list-1__link">Forum Link Building Techniques</a>
          </li>
          <li class="sm-list-1__item">
            <a href="" class="sm-list-1__link">Q&amp;A Link Building Techniques</a>
          </li>
          <li class="sm-list-1__item">
            <a href="" class="sm-list-1__link">Guest Posting Marcketing </a>
          </li>
          <li class="sm-list-1__item">
            <a href="" class="sm-list-1__link">Forum Link Building Techniques</a>
          </li>
        </ul>
        <h3 class="sm-title">Menu</h3>
        <ul class="sm-list-2">
          <li class="sm-list-2__item">
            <a href="" class="sm-list-2__link">Renew Subscriptions</a>
          </li>
          <li class="sm-list-2__item">
            <a href="" class="sm-list-2__link">F.A.Q.</a>
          </li>
          <li class="sm-list-2__item sm-list-2__item--active">
            <a href="" class="sm-list-2__link">Blog</a>
          </li>
          <li class="sm-list-2__item">
            <a href="" class="sm-list-2__link">My Account</a>
          </li>
          <li class="sm-list-2__item">
            <a href="" class="sm-list-2__link">Logout</a>
          </li>
        </ul>
      </div>
      <div class="sm__bottom">
        <a href="" class="sm-btn"><i class="icon-5"></i></a>
      </div>
    </div>
    <?= $content ?>
    <footer class="main-footer">
      <div class="mf__content">
        <div class="container">
          <div class="mfc__row">
            <div class="mf-info">
              <div class="mf-logo">
                <a href=""><img src="img/main-logo.png" alt="" class="img-fluid"></a>
              </div>
              <p class="mf-copy">Copyright © 2017. MarketingHack.net. All rights reserved.</p>
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
                  <li class="mf__item"><a href="<?=Url::to(['site/terms-of-use']);?>" class="mf__link">Terms of Use</a></li>
                  <li class="mf__item"><a href="<?=Url::to(['blog/index']);?>" class="mf__link">Blog</a></li>
                </ul>
              </nav>
            </div>
            <div class="mf-products">
              <h3 class="mf-title">Products</h3>
              <ul class="mf__list">
                <?php foreach (Product::find()->where(['status' => 1])->limit(5)->all() as $p) {?>
                <li class="mf__item">
                  <a href="" class="mf__link"><?=$p->title?></a>
                </li>
                <?php }?>
              </ul>
            </div>
            <div class="mf-contacts">
              <h3 class="mf-title">Contact Info</h3>
              <ul class="mf__list">
                <li class="mf__item">
                  <a href="<?=Url::to(['site/contact']);?>" class="mf__link">Contact Us</a>
                </li>
                <li class="mf__item">
                  <a href="<?=Url::to(['site/support']);?>" class="mf__link">Support</a>
                </li>
                <li class="mf__item">
                  <a href="" class="mf__link">Facebook</a>
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
            <li><a href=""><i class="maestro-ic"></i></a></li>
            <li><a href=""><i class="visa-ic"></i></a></li>
            <li><a href=""><i class="ae-ic"></i></a></li>
            <li><a href=""><i class="paypal-ic"></i></a></li>
            <li><a href=""><i class="bitcoin-ic"></i></a></li>
            <li><a href=""><i class="webmoney-ic"></i></a></li>
          </ul>
        </div>
      </div>
    </footer>
  </div>

  <div class="mh-popup mfp-hide aut-popup" id="login-popup">
    <h2 class="aut-title">Log In</h2>
    <div class="aut-fields">
      <div class="aut-field">
        <input type="email" class="aut-input" placeholder="Email">
      </div>
      <div class="aut-field">
        <input type="password" class="aut-input" placeholder="Password">
      </div>
    </div>
    <a href="" class="aut-link">Forgot your password?</a>
    <button class="btn-5">Login</button>
    <a href="#signup-popup" class="aut-link js-popups">Don't have an account?</a>
  </div>

  <div class="mh-popup mfp-hide aut-popup" id="signup-popup">
    <h2 class="aut-title">Sign Up</h2>
    <a href="#login-popup" class="aut-link js-popups">Already have an account?</a>
    <div class="aut-fields">
      <div class="aut-field">
        <input type="text" class="aut-input" placeholder="Name">
      </div>
      <div class="aut-field">
        <input type="email" class="aut-input" placeholder="Email">
      </div>
      <div class="aut-field">
        <input type="password" class="aut-input" placeholder="Password">
      </div>
    </div>
    <button class="btn-5">Register</button>
    <p class="aut-text">By clicking Register you agree <br>to our <a href="">terms and conditions</a></p>
  </div>

<?php $this->endBody() ?>
  <!-- Vendor -->
  <script src="vendor/magnific-popup/dist/jquery.magnific-popup.min.js"></script>
  <script src="vendor/slick-carousel/slick/slick.min.js"></script>

  <!-- Theme Base -->
  <script src="js/main.js"></script>    
</body>
</html>
<?php $this->endPage() ?>

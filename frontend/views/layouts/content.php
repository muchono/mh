<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use yii\helpers\Url;
use yii\web\View;

use frontend\assets\AppAsset;
use common\widgets\Alert;

use common\models\Product;
use common\models\OrderToProduct;

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

  <!-- Head Libs -->
  <!-- <script src="bower_components/modernizr/modernizr.js"></script> -->    
   <?php $this->head() ?>
  <script type="text/javascript">
      var active_product_id = <?=rand(100,1000);?>
  </script>
</head>
<body>
<?php $this->beginBody() ?>
    <div class="alter-layout">
    <div class="top-bar">
      <div class="top-bar__inner">
        <a href="" class="menu-btn js-side-menu-btn">
          <span></span>
        </a>
        <div class="logo">
          <a href="" class="logo__link"><img src="img/main-logo.png" alt="" class="img-fluid"></a>
        </div>
        <nav class="main-nav">
          <ul class="main-nav__list">
            <li class="main-nav__item"><a href="" class="main-nav__link">Home</a></li>
            <li class="main-nav__item"><a href="" class="main-nav__link">How It Works</a></li>
            <li class="main-nav__item"><a href="" class="main-nav__link">Products</a></li>
            <li class="main-nav__item"><a href="" class="main-nav__link">Special Offers</a></li>
            <li class="main-nav__item"><a href="" class="main-nav__link">F.A.Q.</a></li>
            <li class="main-nav__item"><a href="" class="main-nav__link">Support</a></li>
            <li class="main-nav__item"><a href="" class="main-nav__link">Blog</a></li>
          </ul>
        </nav>
        <div class="user-pane">
          <a href="" class="up__btn">Log In</a>
          <a href="" class="up__btn">Sign Up</a>
        </div>
      </div>
    </div>
        
    <div class="side-menu js-side-menu">
      <div class="sm__logo">
        <a href="<?=Url::to(['site/index'])?>" class="logo__link"><img src="img/main-logo.png" alt="" class="img-fluid"></a>
      </div>
      <div class="sm__top">
        <a href="" class="sm-btn"><i class="icon-5"></i></a>
      </div>
      <div class="sm__content">
        <ul class="sm-list-1">
          <?php foreach ($this->params['products'] as $p){ $acc = Yii::$app->user->id && OrderToProduct::isAccessible($p->id, Yii::$app->user->id); ?>
          <li class="sm-list-1__item <?=$this->params['selected_product']->id == $p->id ? 'sm-list-1__item--unblock sm-list-1__item--active' : ( $acc ? ' sm-list-1__item--unblock ' : 'sm-list-1__item--block')?>">
            <a href="<?=$acc ? Url::to(['content/index','product_id'=>$p->id]): '#'?>" class="sm-list-1__link"><?=$p->title?></a>
          </li>
          <?php }?>
          <!--
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
          </li>-->
        </ul>
        <h3 class="sm-title">Menu</h3>
        <ul class="sm-list-2">
          <li class="sm-list-2__item">
            <a href="" class="sm-list-2__link">Renew Subscriptions</a>
          </li>
          <li class="sm-list-2__item">
            <a href="<?=Url::to(['site/faq']);?>" class="sm-list-2__link">F.A.Q.</a>
          </li>
          <li class="sm-list-2__item">
            <a href="<?=Url::to(['blog/index']);?>" class="sm-list-2__link">Blog</a>
          </li>
          <?php if (!Yii::$app->user->isGuest){?>
          <li class="sm-list-2__item">
            <a href="<?=Url::to(['account/index']);?>" class="sm-list-2__link">My Account</a>
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

    <div class="content">
      <div class="top-line">
        <ul class="tl__menu tl__menu--center">
          <li class="tl__item"><a href="" class="tl__link">Renew&nbsp;<span>Subscriptions</span></a></li>
          <li class="tl__item"><a href="<?=Url::to(['site/faq']);?>" class="tl__link">F.A.Q.</a></li>
          <li class="tl__item"><a href="<?=Url::to(['blog/index']);?>" class="tl__link">Blog</a></li>
        </ul>
         
        <ul class="tl__menu">
            <?php if (!Yii::$app->user->isGuest){?> 
          <li class="tl__item">
            <a href="<?=Url::to(['account/index']);?>" class="tl__link"><i class="icon-8"></i> <span>My Account</span></a>
          </li>
          <li class="tl__item">
            <a href="<?=Url::to(['account/logout']);?>" class="tl__link"><i class="icon-9"></i> <span>Logout</span></a>
          </li>
          <?php }?>
        </ul>
          
      </div>

      <div class="inner-content">
        <div class="ic-head">
          <div>
            <h2 class="title-4"><?=$this->params['selected_product']->getHrefs()->count()?> Popular Forums</h2>
            <?php if (Yii::$app->user->isGuest){?>
            <p class="ic-head__text">This is demo version - full version will be available after <a href="#signup-popup" class="js-popups">purchase</a></p>
            <?php }?>
          </div>
          <div class="ic-head__get">
            <?php if ($this->params['selected_product']->priceFinal 
                    && $this->params['selected_product']->discount){?>
            <div class="ic-head-off">
              <strong><?=$this->params['selected_product']->discount->percent?><sup>%</sup></strong>
              Discount
            </div>
            <?php } ?>
            <div>
              <?php if (!$this->params['selected_product']->priceFinal){?> 
                <?php if (!$this->params['selected_product_accessible']){?> 
                    <?php if (Yii::$app->user->isGuest){?> 
                    <a href="#signup-popup" class="btn-4 js-popups">Get Free Access</a>
                    <?php } else {?>
                    <a href="#" class="btn-4 content-add-tocart" for="<?=$this->params['selected_product']->id?>">Get Free Access</a>
                    <?php }?>
                <?php }?>
              <?php } else {?>
                <?php if (!$this->params['selected_product_accessible']){?>
                <a href="#" class="btn-4 content-add-tocart" for="<?=$this->params['selected_product']->id?>">Buy now</a>
                <?php } else {?>
                <a href="#" class="btn-4 content-add-tocart" for="<?=$this->params['selected_product']->id?>">Renew</a>
                <?php } ?>
              <?php } ?>
              <div class="ic-price <?php if ($this->params['selected_product']->discount){?>ic-price--free-now<?php } ?>">
                  <span class="price__text"><?=$this->params['selected_product']->price?>$</span> 
                  <span class="free__text">
                      <?php if (!$this->params['selected_product']->priceFinal){?>
                      Free Now
                      <?php } else {?>
                      <?=$this->params['selected_product']->priceFinal?>$
                      <?php } ?>
                  </span>
              </div>
            </div>
          </div>
        </div>

        <div class="tab-container">
            <ul class="tab-list">
              <li class="tab-list__item"><span class="tab-list__link tab-list__link--active" id="tabList"><span>List</span></span></li>
              <li class="tab-list__item"><span class="tab-list__link" id="tabGuide"><span>Guide</span></span></li>
            </ul>
            <div class="tab-content"></div>
            <div class="tab-foot">
            <?php if (Yii::$app->user->isGuest){?>
            <a href="#signup-popup" class="btn-3 js-popups">Get Free Access</a>
            <?php }?>
          </div>
          <div class="loader" style="display:none">&nbsp;</div>
        </div>
      </div>
    </div>
  </div>
<?= $this->renderFile('@frontend/views/layouts/_signup.php', []) ?>
<?php $this->endBody() ?>
  <!-- Vendor -->
  <script src="vendor/magnific-popup/dist/jquery.magnific-popup.min.js"></script>
  <script src="vendor/slick-carousel/slick/slick.min.js"></script>

  <!-- Theme Base -->
  <script src="js/main.js"></script>
<?php
$this->registerJsFile(
    '@web/js/logged.js'
);
$this->registerJs(
    "Logged.construct(".$this->params['selected_product']->id.");",
    View::POS_READY,
    'my-button-handler'
);
?>  
</body>
</html>
<?php $this->endPage() ?>

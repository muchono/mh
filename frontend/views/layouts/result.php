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
</head>
<body>
<?php $this->beginBody() ?>
  <div class="message-layout">
    <div class="top-bar">
      <div class="top-bar__inner">
        <div class="logo">
          <a href="<?=Url::to(['site/index'])?>" class="logo__link"><img src="<?=Url::base()?>/img/main-logo.png" alt="" class="img-fluid"></a>
        </div>
      </div>
    </div>
    
      <?=$content?>
  </div>

<?php $this->endBody() ?>
 
</body>
</html>
<?php $this->endPage() ?>

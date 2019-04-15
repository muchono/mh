<?php

/* @var $this \yii\web\View */

use yii\helpers\Url;
?>
<section class="simple-page sm msg">
  <div class="message-page">
    <h1 class="mp__title mp__title--success"><?=$text?> </h1>
    <figure class="mp__img">
      <img src="<?=Url::base()?>/img/msg-success-img.jpg" alt="" class="img-fluid">
    </figure>
    <a href="<?=Url::to(['site/index'])?>" class="btn-8">return to home</a>
  </div>
</section>
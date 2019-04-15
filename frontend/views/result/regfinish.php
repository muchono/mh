<?php
use yii\helpers\Url;
?>
<section class="simple-page sm msg">
      <div class="message-page">
        <h1 class="mp__title mp__title--success">Thank you for your registration.</h1>
        <figure class="mp__img">
          <img src="<?=Url::base()?>/img/msg-success-img.jpg" alt="" class="img-fluid">
        </figure>
        <p class="mp__lg-text">We’ve sent you an email with instructions to: <span><?=$email?></span></p>
        <p class="mp__sm-text">This email sometimes ends up in the spam, bulk or junk <br>mail, so please check these folders as well.</p>
        <a href="<?=Url::to(['site/index']);?>" class="btn-8">return to home</a>
      </div>
    </section>
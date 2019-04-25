<?php
    use yii\helpers\Url;
?>
<section class="simple-page sm msg">
      <div class="message-page">
        <h1 class="mp__title mp__title--success">Thank you for your purchase.</h1>
        <p class="mp__light-text">Your reference number: <strong><?=$remote_id;?></strong></p>
        <figure class="mp__img">
          <img src="<?=Url::base()?>/img/msg-success-img.jpg" alt="" class="img-fluid">
        </figure>
        <p class="mp__lg-text">Once the payment is approved we will sent you an email with instructions. Or you can check order details on My Account Page</span></p>
        <a href="<?=Url::to(['account/']);?>" class="btn-8">My Account</a>
      </div>
    </section>
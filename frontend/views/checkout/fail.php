<?php
    use yii\helpers\Url;
?>
<section class="simple-page sm msg">
      <div class="message-page">
        <h1 class="mp__title mp__title--danger">Your transaction was not succesful.</h1>
        <figure class="mp__img">
          <img src="img/msg-warning-img.jpg" alt="" class="img-fluid">
        </figure>
        <p class="mp__md-text">Perhaps the reason is the lack of funds in your account. <br>Try to go back and change the payment method.</p>
        <a href="<?=Url::to(['checkout/index']);?>" class="btn-8">Back</a>
      </div>
    </section>
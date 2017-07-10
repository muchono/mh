<?php
    use frontend\controllers\BlogController;
?>
<?php if (!BlogController::isSubscribed()){?>
<section class="subscribe-block">
      <form action="" class="sbsc-form">
        <h2 class="title-3 ">Subscribe to <b>MarketingHack</b> newsletter:</h2>
        <div class="sbsc-form__field">
          <input type="email" class="sbsc-form__input" id="blog_subscribe_input">
        </div>
        <div class="error-message" id="blog_subscribe_errors"></div>
        <div class="sbsc-form__field">
          <button type="submit" id="blog_subscribe" class="sbsc-form__botton">Subscribe</button>
        </div>
      </form>
    </section>
<?php }?>
    <section class="get-access-block">
      <div class="container">
        <h3 class="title-8">Get access to actual websites lists and step-by-step guides right now!</h3>
        <p class="gab__text-1">- go through the registration and get the access to demo versions of all our products.</p>
        <a href="" class="btn-3">Create Your Account</a>
        <p class="gab__text-2">Registration is free <br>and will take you a few minutes.</p>
      </div>
    </section>
<?php
$this->registerJsFile(
    '@web/js/blog.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);
?>
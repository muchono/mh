<?php

use yii\helpers\Url;

use yii\widgets\ActiveForm;
use yii\captcha\Captcha;
use yii\web\View;
/* @var $this yii\web\View */
/* @var $model \common\models\Product */

$this->title = $model->title;
?>
<section class="product-page">
      <div class="container-md">
        <div class="page-pane">
          <div class="breadcrumbs-2">
            <ul class="breadcrumbs-2__list">
              <li class="breadcrumbs-2__item">
                <a href="<?=Url::to(['site/index'])?>" class="breadcrumbs-2__link">MarketingHack</a>
              </li>
              <li class="breadcrumbs-2__item">
                <a href="<?=Url::to(['site/products'])?>" class="breadcrumbs-2__link">Products</a>
              </li>
              <li class="breadcrumbs-2__item">
                <span class="breadcrumbs-2__text"><?=$model->short_title?></span>
              </li>
            </ul>
          </div>
          <div class="product-page-wrap">
            <div class="product-page-content">
              <h1 class="title-9"><?=$model->page->title?></h1>
              <blockquote class="blockquote-3 ">
                <?=$model->page->description?>
              </blockquote>
              <article class="product-page-article">
                <div class="reset-this">
                <?=$model->page->content?>
                </div>
                <div class="buy-try-pane">
                  <a href="" class="btn-3 buy-full-btn" for="<?=$model->id?>">Buy Full Version</a>
                  <span class="btp__or">or</span>
                  <a href="<?=Url::to(['content/index','product_id'=>$model->id])?>" class="btn-6">Try Demo</a>
                </div>                  
              </article>
              <div class="under-post-pane">
                <div class="customer-reviews">
                  <div class="upp__head">
                    <h3 class="upp__title">Customer Reviews</h3>
                    <p class="upp__text">Based on <?=$model->getReviews()->where(['active' => 1])->count()?> reviews</p>
                    <a href="#support-form" class="upp__btn">Write a review</a>
                  </div>
                  <ul class="reviews-list">
                    <?php foreach ($model->activeReviews as $r) {?>
                    <li class="reviews-list__item">
                      <div class="review">
                        <div class="review__stars">
                          <div class="rate">
                            <div class="rate__wrap">
                              <?php for($i=1; $i<=5; $i++) {?>
                              <span class="rate__star rate__star--<?=$i <= $r->raiting ? 'on' : 'off'?>"></span>
                              <?php }?>
                            </div>
                          </div>
                          <div class="review__verified">Verified Buyer</div>
                          <div class="review__date"><?=$r->ago?> ago</div>
                        </div>
                        <div class="review__text">
                          <h4 class="review__title"><strong><?=$r->name?></strong> said:</h4>
                          <p class="review__text"><?=$r->content?></p>
                        </div>
                      </div>
                    </li>
                    <?php }?>
                  </ul>
                </div>
              </div>
              <span id="under_post"></span>
              <div class="under-post-pane">
                  <?php if ($review_added){?>
                  <div class="write-a-review">
                  <div class="upp__head">
                    <h3 class="upp__title" >Thank you. The review will be activated after moderation.</h3>
                  </div>
                  </div>
                  <?php } else {?>
                <div class="write-a-review">
                  <div class="upp__head">
                    <h3 class="upp__title">Write a Review</h3>
                    <p class="upp__text">Only for Buyers</p>
                  </div>
                  <?php $form = ActiveForm::begin(['id' => 'support-form', 'class' => 'war-form']); ?>
                    <div class="war-form__field">
                      <label for="" class="war-form__label">Name</label>
                      <?= $form->field($review, 'name')->textInput(['class' => 'war-form__input'])->label(false) ?>
                      <div class="war-form__info">Enter your name or nick-name (public)</div>
                    </div>
                    <div class="war-form__field">
                        <label for="" class="war-form__label">Email</label>
                        <?= $form->field($review, 'email')->textInput(['class' => 'war-form__input'])->label(false) ?>
                      <div class="war-form__info">Enter your email you've used for transaction (private)</div>
                    </div>
                    <div class="war-form__field">
                      <label for="" class="war-form__label">Rating</label>
                      <div class="rate">
                        <div class="rate__wrap">
                          <span class="rate__star rate__star--on"></span>
                          <span class="rate__star rate__star--on"></span>
                          <span class="rate__star rate__star--on"></span>
                          <span class="rate__star rate__star--on"></span>
                          <span class="rate__star rate__star--on"></span>
                        </div>
                          <?= $form->field($review, 'raiting')->hiddenInput(['value'=>5,'id'=>'raiting'])->label(false) ?>
                          <?= $form->field($review, 'product_id')->hiddenInput(['value'=>$model->id])->label(false) ?>
                      </div>
                    </div>
                    <div class="war-form__field">
                      <label for="" class="war-form__label">Review</label>
                      <?= $form->field($review, 'content')->textInput(['class' => 'war-form__textarea'])->label(false) ?>
                      <div class="war-form__info">Write your opinion about our product (public)</div>
                    </div>
                    <div class="war-form__field">
                        <label for="" class="war-form__label">Verification Code</label>
                    <?= $form->field($review, 'verifyCode')->label(false)
                          ->widget(Captcha::className(), [
                        'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
                        'options' => ['placeholder' => 'CAPTCHA Code', 'class' => 'war-form__input']
                    ]) ?>                        
                      
                    </div>                    
                    <div class="war-form__foot">
                      <button class="btn-2">Submit Review</button>
                    </div>
                  <?php ActiveForm::end(); ?>
                </div>
                  <?php }?>
              </div>
            </div>
            <aside class="product-page-side-bar">
              <div class="side-bar-pane">
                <div class="product-pane">
                  
                    <?php if (!$model->priceFinal) {?>
                    <div class="pp__head">
                      <div class="pp__head-col">
                        <div class="pp__on">
                          FREE Now
                        </div>
                      </div>
                      <div class="pp__head-col">
                        <span class="pp__price pp__price--discount">$<?=$model->price?></span>
                        <div class="pp__save">Your save $<?=$model->price?></div>
                      </div>
                    </div>                    
                    <?php } elseif ($model->discount) {?>
                    <div class="pp__head">
                     <div class="pp__head-col">
                      <div class="pp__off">
                        <strong><?=$model->discount->percent?><sup>%</sup></strong>
                        Discount
                      </div>
                    </div>
                    <div class="pp__head-col">
                      <span class="pp__price pp__price--discount">$<?=$model->price?></span>
                      <span class="pp__discount-price">$<?=$model->priceFinal?></span>
                      <div class="pp__save">Your save $<?=$model->price - $model->priceFinal?></div>
                    </div>
                    </div>
                    <?php } else {?>
                    <div class="pp__head">
                      <div class="pp__head-col">
                        <span class="pp__price">$<?=$model->price?></span>
                      </div>
                    </div>
                    <?php }?>
                      

                  <div class="pp__content">
                    <div class="pp__subscription">Subscription on
                      <select>
                        <option value="">1</option>
                        <option value="">2</option>
                        <option value="">3</option>
                      </select>
                      year
                    </div>
                    <h4 class="pp__title">Contains:</h4>
                    <ul class="pp__contains-list">
                      <li class="pp__contains-list-item">
                        <div class="pp__contains-icon">
                          <i class="pp-icon-1"></i>
                        </div>
                        <div class="pp__contains-text"><strong>Guide</strong> - <?=$model->page->guide_description?></div>
                      </li>
                      <li class="pp__contains-list-item">
                        <div class="pp__contains-icon">
                          <i class="pp-icon-2"></i>
                        </div>
                        <div class="pp__contains-text"><strong>List</strong> - <?=$model->page->list_description?></div>
                      </li>
                    </ul>
                  </div>
                  <div class="pp__foot">
                    <a href="" class="btn-5 add2cart"  for="<?=$model->id?>">Add to cart</a>
                    <span class="pp__or">or <a href="<?=Url::to(['content/index','product_id'=>$model->id])?>">check demo</a></span>
                  </div>
                </div>
              </div>
            <?php if ($model->page->features) {?>
              <div class="side-bar-pane">
                <h4 class="pp__title">Features:</h4>
                <ul class="pp__contains-list">
                    <?php if ($model->page->feature1) {?>
                  <li class="pp__contains-list-item">
                    <div class="pp__contains-icon">
                      <i class="pp-icon-3"></i>
                    </div>
                    <div class="pp__contains-text"><strong>Practice knowledges</strong> - <?=$model->page->feature1?>.</div>
                  </li>
                    <?php }?>
                  <?php if ($model->page->feature2) {?>
                  <li class="pp__contains-list-item">
                    <div class="pp__contains-icon">
                      <i class="pp-icon-4"></i>
                    </div>
                    <div class="pp__contains-text"><strong>Step-by-step guide</strong> - <?=$model->page->feature2?>.</div>
                  </li>
                  <?php }?>
                  <?php if ($model->page->feature3) {?>
                  <li class="pp__contains-list-item">
                    <div class="pp__contains-icon">
                      <i class="pp-icon-5"></i>
                    </div>
                    <div class="pp__contains-text"><strong>Actual information</strong> - <?=$model->page->feature3?>.</div>
                  </li>
                  <?php }?>
                  <?php if ($model->page->feature4) {?>
                  <li class="pp__contains-list-item">
                    <div class="pp__contains-icon">
                      <i class="pp-icon-6"></i>
                    </div>
                    <div class="pp__contains-text"><strong>Reagular updates</strong> - <?=$model->page->feature4?>.</div>
                  </li>
                  <?php }?>
                  <?php if ($model->page->feature5) {?>
                  <li class="pp__contains-list-item">
                    <div class="pp__contains-icon">
                      <i class="pp-icon-7"></i>
                    </div>
                    <div class="pp__contains-text"><strong>Emails to contact with editors</strong> - <?=$model->page->feature5?>.</div>
                  </li>
                  <?php }?>
                </ul>
              </div>
                <?php }?>
            </aside>
          </div>
        </div>
    <?= $this->render('_recommend_items', [
        'products' => $products,
    ]) ?>          
<?php
$this->registerJs(
    "$('.rate__star').click(function(event){"
        . "var active = $(this); active.attr('class', 'rate__star rate__star--on');"
        . "var before = active.prevAll('.rate__star'); before.attr('class', 'rate__star rate__star--on');"        
        . "$('#raiting').val(before.length+1);"
        . "active.nextAll('.rate__star').attr('class', 'rate__star rate__star--off');"
        . "})",
    View::POS_READY,
    'my-button-handler'
);
?>
</div>
</section>
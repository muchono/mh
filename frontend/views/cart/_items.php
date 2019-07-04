<?php
use yii\helpers\Url;
use yii\helpers\Html;
use common\models\Cart;
use yii\widgets\ActiveForm;
?>
<div class="cart-summary">
                <div class="cs__head">Cart Summary</div>
                <div class="cs__content">
                  <ul class="summary-list">
                      <?php foreach($cartInfo['products'] as $k=>$p){?>
                    <li class="sl__item">
                        <h4 class="sl__title"><?=$p->short_title?> <i class="sl__close" for="<?=$p->id?>"></i></h4>
                      <p class="sl__text"><?=$p->short_title?></p>
                      <div class="sl__subscription">
                        <div class="sl__col">Subscription on 1 year</div>
                        <div class="sl__col">
                          <div class="sl__price <?=$p->priceFinal ? '' : 'sl__price--free'?>"><?=$p->priceFinal ? '$'.$cartInfo['prices'][$k] : 'Free'?></div>
                        </div>
                      </div>
                      
                      <?php if (isset($cartInfo['offers'][$p->id])) {?>
                      <div class="cs__discount">Offer: <strong><?=$cartInfo['offers'][$p->id]->title?></strong></div>
                      <?php }?>
                    </li>
                      <?php }?>
                  </ul>
                </div>
                <div class="cs__foot">
                  <div class="cs__subtotal">Subtotal: <strong>$<?=$cartInfo['amount']?></strong></div>
                  <?php if ($cartInfo['discount']) {?>
                  <div class="cs__discount">Discount: <strong>$<?=$cartInfo['discount']?></strong></div>
                  <?php }?>
                  <div class="cs__total">Order Total:  $<?=$cartInfo['total']?></div>
                  <?php $form = ActiveForm::begin(['id' => 'cart-form', 'action' => Url::to(['checkout/'])]); ?>
                  <?php if ($cartInfo['products']){?>
                  <p><?= Html::input('text', 'code', '', ['class' => 'bf__input', 'placeholder'=>"Discount Code"]) ?></p>
                  <br/>
                  <button class="btn-9">Checkout Now</button>
                  <?php }?>
                  <?php ActiveForm::end(); ?>
                </div>
              </div>
<?php
use yii\helpers\Url;

use common\models\Cart;
?>
<div class="cart-summary">
                <div class="cs__head">Cart Summary</div>
                <div class="cs__content">
                  <ul class="summary-list">
                      <?php foreach($cartInfo['products'] as $k=>$p){?>
                    <li class="sl__item">
                        <h4 class="sl__title"><?=$p->short_title?> <i class="sl__close" for="<?=$p->id?>"></i></h4>
                      <p class="sl__text"><?=$p->full_title?></p>
                      <div class="sl__subscription">
                        <div class="sl__col">Subscription on
                          <select class="item-months" for="<?=$p->id?>">
                              <?php foreach(Cart::$months as $m){?>
                            <option <?=$cartInfo['cart'][$k]->months == $m ? 'selected' : ''?>><?=$m?></option>
                            <?php }?>
                          </select>
                          year</div>
                        <div class="sl__col">
                          <div class="sl__price <?=$p->priceFinal ? '' : 'sl__price--free'?>"><?=$p->priceFinal ? '$'.$cartInfo['prices'][$k] : 'Free'?></div>
                        </div>
                      </div>
                    </li>
                      <?php }?>
                  </ul>
                </div>
                <div class="cs__foot">
                  <div class="cs__subtotal">Subtotal: <strong>$<?=$cartInfo['amount']?></strong></div>
                  <div class="cs__discount">Discount: <strong>$<?=$cartInfo['discount']?></strong></div>
                  <div class="cs__total">Order Total:  $<?=$cartInfo['total']?></div>
                  <form action="">
                      <input type="hidden" name="r" value="checkout/index">
                  <button class="btn-9">Checkout Now</button>
                  </form>
                </div>
              </div>
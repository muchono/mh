<?php

use yii\web\View;

?>
<section class="simple-page sm">
      <h2 class="title-14">Payment Method:</h2>
      <ul class="pay-list">
        <li class="pay-list__item">
          <input type="radio" name="pay" id="pay-1">
          <label class="pay-btn" for="pay-1">
            <span class="pay-btn__icon">
              <img src="img/pay-1-ic.png" alt="" class="img-fluid">
            </span>
            <span class="pay-btn__text">Credit Card</span>
          </label>
        </li>
        <li class="pay-list__item">
          <input type="radio" name="pay" id="pay-2">
          <label class="pay-btn" for="pay-2">
            <span class="pay-btn__icon">
              <img src="img/pay-2-ic.png" alt="" class="img-fluid">
            </span>
            <span class="pay-btn__text">PayPal</span>
          </label>
        </li>
        <li class="pay-list__item">
          <input type="radio" name="pay" id="pay-3">
          <label class="pay-btn" for="pay-3">
            <span class="pay-btn__icon">
              <img src="img/pay-3-ic.png" alt="" class="img-fluid">
            </span>
            <span class="pay-btn__text">WebMoney</span>
          </label>
        </li>
        <li class="pay-list__item">
          <input type="radio" name="pay" id="pay-4">
          <label class="pay-btn" for="pay-4">
            <span class="pay-btn__icon">
              <img src="img/pay-4-ic.png" alt="" class="img-fluid">
            </span>
            <span class="pay-btn__text">Bitcoin</span>
          </label>
        </li>
      </ul>
      <h2 class="title-14">Billing Information:</h2>
      <div class="billing-info">
        <div class="billing-field-row">
          <div class="billing-field">
            <label for="" class="bf__label">Full Name</label>
            <input type="text" class="bf__input">
            <span class="bf__info">(for individuals only)</span>
          </div>
          <div class="billing-field billing-field--auto">
            <span class="bf__or">or</span>
          </div>
          <div class="billing-field">
            <label for="" class="bf__label">Company Name</label>
            <input type="text" class="bf__input">
            <span class="bf__info">(for legal entities only)</span>
          </div>
        </div>
        <div class="billing-field-row">
          <div class="billing-field billing-field--novalidate">
            <label for="" class="bf__label">Email</label>
            <input type="email" class="bf__input">
            <span class="bf__info">(to this email you will get confirmation letter)</span>
          </div>
        </div>
        <div class="billing-field-row">
          <div class="billing-field">
            <label for="" class="bf__label">Phone Number</label>
            <input type="email" class="bf__input">
            <span class="bf__info">(to this phone number you will get SMS code)</span>
          </div>
        </div>
        <div class="billing-field-row">
          <div class="billing-field">
            <label for="" class="bf__label">Country</label>
            <select name="" id="" class="bf__select">
              <option value="">lorem</option>
              <option value="">lorem</option>
              <option value="">lorem</option>
              <option value="">lorem</option>
              <option value="">lorem</option>
            </select>
          </div>
        </div>
        <div class="billing-field-row">
          <div class="billing-field">
            <label for="" class="bf__label">Address</label>
            <input type="email" class="bf__input">
          </div>
        </div>
        <div class="billing-field-row">
          <div class="billing-field">
            <label for="" class="bf__label">Postal Code</label>
            <input type="email" class="bf__input">
          </div>
        </div>
        <div class="billing-field-row">
          <div class="billing-field">
            <label for="" class="bf__label">City</label>
            <input type="email" class="bf__input">
          </div>
        </div>
      </div>
      <h2 class="title-14">Your Order:</h2>
      <table class="order-table">
          <thead>
            <tr>
              <th class="ot__num">?</th>
              <th class="ot__product">Product</th>
              <th class="ot__cost">Cost</th>
            </tr>
          </thead>
          <tbody  id="list_content">
               <?= $this->render('_items', [
                'cartInfo' => $cartInfo,
                ]) ?>              
          </tbody>
      </table>
      <?php if($products) {?>
      <p class="int-text">but perhaps you'll also be interested in:</p>
      <?php }?>
      <table class="order-table order-table--separate">
          <tbody>
              <?php foreach($products as $p) {?>
            <tr class="ot__row <?=$p->discount ? 'ot__row--discount' : ''?>">
              <td class="ot__num">
                <input type="checkbox" value="<?=$p->id?>" class="addtocart-checkbox">
              </td>
              <td class="ot__product"><?=$p->short_title?>: list + guide (subscription on 1 year)
                <?php if($p->discount) {?>                  
                <div class="ot__discount"><div class="otd__inner">
                  <?=$p->discount->percent?><span>%</span> <div>Discount</div>
                </div></div>
                 <?php }?>
              </td>
              <td class="ot__cost">$<?=$p->priceFinal?></td>
            </tr>
            <?php }?>
          </tbody>
      </table>
      <div class="payment-foot">
        <div class="total-payment">Total payment amount: $<span id="items_amount"><?=$cartInfo['total']?></span></div>
        <p class="terms-text">By passing to payment you confirm that you agree to the <a href="">Terms of Use</a> and <a href="">Privacy Policy</a></p>
        <button class="btn-3">Accept and Pay</button>
      </div>
    </section>
<?php
$this->registerJsFile(
    '@web/js/cart.js'
);
$this->registerJs(
    "Cart.construct();",
    View::POS_READY,
    'cart-handler'
);
?>
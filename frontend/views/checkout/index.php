<?php

use yii\web\View;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

?>
<section class="simple-page sm">
      <h2 class="title-14">Payment Method:</h2>
    <?php 
      $form = ActiveForm::begin([
     'enableClientValidation' => false,
     'enableAjaxValidation' => false,          
        ]); ?>
    
      <?= $form->field($userBilling, 'payment')->hiddenInput(['class' => 'bf__input'])->label(false) ?>      
      <ul class="pay-list">
          <!--
        <li class="pay-list__item">
          <input type="radio" name="payment" id="pay-1" value="Credit Card">
          <label class="pay-btn" for="pay-1">
            <span class="pay-btn__icon">
              <img src="img/pay-1-ic.png" alt="" class="img-fluid">
            </span>
            <span class="pay-btn__text">Credit Card</span>
          </label>
        </li>-->
        <?php foreach($payments as $k=>$pay){?>
        <li class="pay-list__item">
          <input type="radio" name="UserBilling[payment]" id="pay-<?=$k?>" value="<?=$pay?>" <?=$userBilling->payment == $pay ? 'checked' : ''?>>
          <label class="pay-btn" for="pay-<?=$k?>">
            <span class="pay-btn__icon">
              <img src="<?=Url::base()?>/img/pay-<?=$k?>-ic.png" alt="" class="img-fluid">
            </span>
            <span class="pay-btn__text"><?=$pay?></span>
          </label>
        </li>
        <?php }?>
      </ul>
      
      <h2 class="title-14">Billing Information:</h2>
      <div class="billing-info">
        <div class="billing-field-row">
          <div class="billing-field">
            <label for="" class="bf__label">Full Name</label>
            <?= $form->field($userBilling, 'full_name')->textInput(['class' => 'bf__input'])->label(false) ?>
            <span class="bf__info">(for individuals only)</span>
          </div>
          <div class="billing-field billing-field--auto">
            <span class="bf__or">or</span>
          </div>
          <div class="billing-field">
            <label for="" class="bf__label">Company Name</label>
            <?= $form->field($userBilling, 'company_name')->textInput(['class' => 'bf__input'])->label(false) ?>
            <span class="bf__info">(for legal entities only)</span>
          </div>
        </div>
        <div class="billing-field-row">
          <div class="billing-field">
            <label for="" class="bf__label">Email</label>
            <?= $form->field($userBilling, 'email')->textInput(['class' => 'bf__input'])->label(false) ?>            
            <span class="bf__info">(to this email you will get confirmation letter)</span>
          </div>
        </div>
        <div class="billing-field-row">
          <div class="billing-field">
            <label for="" class="bf__label">Phone Number</label>
            <?= $form->field($userBilling, 'phone_number')->textInput(['class' => 'bf__input'])->label(false) ?>
            <span class="bf__info">(to this phone number you will get SMS code)</span>
          </div>
        </div>
        <div class="billing-field-row">
          <div class="billing-field">
            <label for="" class="bf__label">Country</label>
            <?= $form->field($userBilling, 'country')
              ->dropDownList(ArrayHelper::map(common\models\Countries::find()->all(), 'id', 'country_name'), ['class'=>'bf__input'])->label(false);?>
          </div>
        </div>
        <div class="billing-field-row">
          <div class="billing-field">
            <label for="" class="bf__label">Address</label>
            <?= $form->field($userBilling, 'address')->textInput(['class' => 'bf__input'])->label(false) ?>
          </div>
        </div>
        <div class="billing-field-row">
          <div class="billing-field">
            <label for="" class="bf__label">Postal Code</label>
            <?= $form->field($userBilling, 'zip')->textInput(['class' => 'bf__input'])->label(false) ?>
          </div>
        </div>
        <div class="billing-field-row">
          <div class="billing-field">
            <label for="" class="bf__label">City</label>
            <?= $form->field($userBilling, 'city')->textInput(['class' => 'bf__input'])->label(false) ?>
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
        <a href='#' data-fsc-action="Add,Checkout" data-fsc-item-path-value="my-first-product">Purchase "Product One"</a>
        <button class="btn-3">Accept and Pay</button>
      </div>
        <?php ActiveForm::end(); ?>      
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
$this->registerJsFile(
    'https://d1f8f9xcsvx3ha.cloudfront.net/sbl/0.7.9/fastspring-builder.min.js',
    [
        'id' => "fsc-api",
        'data-storefront' => "nmsystems.test.onfastspring.com/popup-nmsystems",
        'position' => View::POS_HEAD,
        'data-debug' => "true",
        'position' => View::POS_HEAD,
    ],
    'fast-pay'
);
?>
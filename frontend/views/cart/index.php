<?php
use common\models\Cart;
use yii\web\View;
?>
<section class="cart-page">
      <div class="container-sm">
        <div class="page-pane">
          <h1 class="title-14 success">In Your Shopping Cart - <span id="items_count"><?=$cartInfo['count']?></span> Item(s)</h1>
          <div class="cart-page-wrap">
            <?php if (!empty($products)) {?>              
            <div class="cart-page-content">
              <div class="recommended-items">
                <h2 class="rci__title">Recommended Items:</h2>
                <ul class="rci__list">
                  <?php foreach($products as $p) {?>
                  <li class="rci__item">
                    <div class="recommended-product">
                      <div class="rp__col-left">
                        <h3 class="rp__title"><?=$p->short_title?></h3>
                        <p class="rp__text"><?=$p->full_title?></p>
                      </div>
                      <div class="rp__col-right">
                        <div class="rp__price <?=$p->priceFinal ? '' : 'rp__price--free'?>">$<?=$p->priceFinal?></div>
                        <?php if(!in_array($p->id, $cartInfo['products_list'])) {?>
                        <a href="" class="btn-sm-3 add-to-cart-button" for="<?=$p->id;?>">Add to Cart</a>
                        <?php }?>
                      </div>
                    </div>
                  </li>
                  <?php }?>
                </ul>
              </div>
            </div>
            <?php }?>
            <aside class="cart-page-aside <?=empty($products) ? 'cart-page-aside-long' : ''?>">
               <?= $this->render('_items', [
                'cartInfo' => $cartInfo,
                ]) ?>
            </aside>
          </div>
        </div>
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


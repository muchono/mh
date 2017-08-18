<?php
use yii\web\View;
?>
<section class="simple-page sm">
      <h2 class="title-14">My Account</h2>
    <?= $this->render('_menu', [
    ]) ?>
      <h2 class="title-14">My Products:</h2>
      <table class="my-product my-product--separate">
        <thead>
          <tr>
            <th class="ot__num">№</th>
            <th class="ot__product">Product</th>
            <th class="ot__expires">Expires</th>
            <th class="ot__renew">Renew</th>
          </tr>
        </thead>
        <tbody>
            <?php foreach ($orderedProducts as $key => $op) {?>
                 
          <tr class="ot__row ot__row--selected">
            <td class="ot__num">
              <div class="checkbox-1">
                <input id="cb-<?=$key?>" class="renew-checkbox" type="checkbox" value="<?=$op->product_id?>">
                <label for="cb-<?=$key?>"></label>
              </div>
            </td>
            <td class="ot__product">
              <?=$op->product->short_title?>: list + guide (subscription on <?=$op->months?> year)
              <div class="ot__product-mb-only">
                21 Aug 2017 <br>
                <a href="" class="btn-sm-2">Renew</a>
              </div>
            </td>
            <td class="ot__expires"><?=date('d M Y', $op->getExpirationDate())?></td>
            <td class="ot__renew">
              <a href="" class="btn-sm-2 renew-button" for="<?=$op->product_id?>">Renew</a>
            </td>
          </tr>
        <?php }?>
        </tbody>
      </table>

      <div class="account-foot">
        <button class="btn-sm-2" id="renew_all_button">Renew selected products</button>
      </div>
    </section>
<?php
$this->registerJsFile(
    '@web/js/account.js'
);
$this->registerJs(
    "Account.construct();",
    View::POS_READY,
    'account-handler'
);
?>
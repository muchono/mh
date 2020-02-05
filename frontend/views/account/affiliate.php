<?php
use yii\web\View;
use yii\helpers\Url;
use common\models\OrderToProduct;
?>
<section class="simple-page sm">
      <h2 class="title-14">My Account</h2>
    <?= $this->render('_menu', [
    ]) ?>
      <h2 class="title-14">Affiliate Information:</h2>
      <table class="my-product my-product--separate">
        <thead>
          <tr>
            <th class="ot__num"></th>
            <th class="ot__product">Comission</th>
            <th class="ot__expires">Users</th>
            <th class="ot__renew">Income</th>
          </tr>
        </thead>
        <tbody>
          <tr class="ot__row ot__row--selected">
            <td class="ot__num"><?=1?></td>
            <td class="ot__product"><?=1?></td>
            <td class="ot__expires"><?=1?></td>
            <td class="ot__renew"><?=1?></td>
          </tr>
        </tbody>
      </table>
     
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
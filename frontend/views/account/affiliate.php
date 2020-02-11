<?php
use yii\web\View;
use yii\helpers\Url;
use common\models\OrderToProduct;

$pa = $user->userAffiliate->getPaymentsAmount();
$am = floor($user->userAffiliate->getUsersPurchasedTotal() * $user->affiliate_comission / 100 - $pa);
?>
<section class="simple-page sm">
    <?= $this->render('_menu', [
    ]) ?>
      <h2 class="title-14">Affiliate Information:</h2>
      
    <table class="my-product my-product--separate">
        <thead>
          <tr>
            <th class="ot__num">Total Users</th>
            <th class="ot__cost">Comission</th>
            <th class="ot__num">Payed Comission</th>
            <th class="ot__num">To Pay</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="ot__num" style="border-right: 1px"><?=count($user->userAffiliate->getUsers())?></td>
            <td class="ot__cost"><?=$user->affiliate_comission?>%</td>
            <td class="ot__cost"><?=$pa ? $pa . '$' : $pa?></td>
            <td class="ot__cost"><?=$am ? $am . '$' : $am?></td>
          </tr>
        </tbody>
      </table>      
      <h3>Affiliate Links:</h3>
      <table class="my-product my-product--separate">

            <tbody>
         <tr class="ot__row ot__row--selected">                
             <td class="ot__product"><a href="<?=Url::to(['site/index'])?>" target="_blank">Home Page</a></td>
                <td class="ot__expires"><?=Url::home(true).'?'.$user->userAffiliate->getLink()?></td>
           </tr>                
    <?php foreach ($products as $p) {?>
         <tr class="ot__row ot__row--selected">                
             <td class="ot__product"><a href="<?=Url::to(['site/product','link'=>$p->page->link])?>" target="_blank"><?=$p->title?></a></td>
                <td class="ot__expires"><?=Url::to(['site/product','link'=>$p->page->link], true).'?'.$user->userAffiliate->getLink()?></td>
           </tr> 
    <?}?>     
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
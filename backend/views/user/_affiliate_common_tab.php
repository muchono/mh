<?php
use yii\helpers\Html;
$pa = $model->userAffiliate->getPaymentsAmount();
$am = floor($model->userAffiliate->getUsersPurchasedTotal() * $model->affiliate_comission / 100 - $pa);
?>
<pre>
<div>    
    <b>Affiliate Link:</b> <?=Yii::$app->urlManagerFrontend->getHostInfo().'/?'.$model->userAffiliate->getLink(); ?>

    <b>Users Number:</b> <?=count($model->userAffiliate->getUsers()); ?>
    
    <b>Users Purchase Amount ($):</b> <?=$model->userAffiliate->getUsersPurchasedTotal()?>
    
    <b>Amount Payed($):</b> <?=$pa ? $pa : 0?>
    
    <b>Amount To Pay($):</b> <?=$am?>
    <?= Html::checkbox("add_payment")?> - add amount as payed
    <?= Html::hiddenInput("add_payment_amount", $am)?>

</div>
</pre>

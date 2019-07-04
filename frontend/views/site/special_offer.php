<?php
use yii\helpers\Url;
/* @var $this yii\web\View */
use common\models\OrderToProduct;
$this->title = 'Special Offers';
?>
    <section class="bestsellers">
      <div class="container">
        <div class="bs-head">
          <h2 class="title-1">Special Offers</h2>
          <p class="bs-head__text">Each product consists of <strong>Guide</strong> + <strong>Digital Subscription</strong> for 1 year.</p>
        </div>
        <div class="bs-list">
          <?php foreach($products as $p) 
              if ($p->discount && $p->discount->show_on_page || !$p->priceFinal) {?>
          <div class="bs-list__item">
            <div class="product">
              <div class="pd__head">
                <div class="pd__text-1"><?=$p->short_title?></div>
                <a href="<?=Url::to(['site/product','link'=>$p->page->link])?>"><h3 class="title-2"><?=$p->links_available ? $p->getHrefsCount() : ''?> <?=$p->title?></h3></a>
                <div class="pd__text-2"><?=$p->full_title?></div>
                <i class="icon-<?=($p->priceFinal) ? 1 : 2?>"></i>
              </div>
              <div class="pd__content">
                <ul class="list-1">
                <?php foreach($p->getQuestionsList() as $g) {?>
                  <li><?=$g?></li>
                <?php }?>
                </ul>
                <a href="<?=Url::to(['site/product','link'=>$p->page->link])?>" class="pd__more">Learn more</a>
              </div>
              <div class="pd__foot">
                <?php if (OrderToProduct::isAccessible($p->id, Yii::$app->user->id)) {?>
                <div class="pd__available">Available</div>
                <?php } else {?>                       
                <?php if (!$p->priceFinal){?>
                <div class="pd-on">
                  FREE Now
                </div>
                <?php } elseif ($p->discount){?>
                <div class="pd-off">
                  <strong><?=$p->discount->percent?><sup>%</sup></strong>
                  Discount
                </div>
                <?php } else {?>                  
                <div class="pd__foot-item">
                </div>
                <?php }?>
                  
                <div class="pd-try">
                  <?php if ($p->discount){?>
                  <span class="pd-try__price pd-try__price--discount">$<?=$p->price?></span>
                      <?php if ($p->priceFinal){?>
                  <span class="pd-try__discount-price">$<?=$p->priceFinal?></span>
                      <?php }?>
                  <?php } else {?>
                  <span class="pd-try__price">$<?=$p->priceFinal?></span>
                  <?php } ?>
                  <span class="pd-try__add add2cart" for="<?=$p->id?>">                
                    <i class="icon-3"></i>
                  </span>
                  <a href="<?=Url::to(['content/index','product_id'=>$p->id])?>" class="btn-sm-1">try demo</a>
                </div>
                <?php } ?>
              </div>
            </div>
          </div>
          <?php }?>
        </div>
      </div>
    </section>  

<?php
use yii\helpers\Url;

?>
        <div class="recommend-items">
          <h2 class="ri__title">Recommend Items</h2>
          <div class="ri__row">
            <?php foreach($products as $p) {?>
            <div class="ri__col">
              <div class="product">
                <div class="pd__head">
                  <div class="pd__text-1"><?=$p->short_title?></div>
                  <a href="<?=Url::to(['site/product','product_id'=>$p->id])?>"><h3 class="title-2"><?=$p->title?></h3></a>
                  <div class="pd__text-2"><?=$p->full_title?>:</div>
                  <i class="icon-<?=($p->priceFinal) ? 1 : 2?>"></i>
                </div>
                <div class="pd__content">
                  <ul class="list-1">
                    <?php foreach($p->getQuestionsList() as $g) {?>
                      <li><?=$g?></li>
                    <?php }?>
                  </ul>
                  <a href="<?=Url::to(['site/product','product_id'=>$p->id])?>" class="pd__more">Learn more</a>
                </div>
                <div class="pd__foot">
                <div class="pd-try">
                  <?php if ($p->discount){?>
                  <span class="pd-try__price pd-try__price--discount">$<?=$p->price?></span>
                      <?php if ($p->priceFinal){?>
                  <span class="pd-try__discount-price">$<?=$p->priceFinal?></span>
                      <?php }?>
                  <?php } else {?>
                  <span class="pd-try__price">$<?=$p->priceFinal?></span>
                  <?php } ?>
                  <span class="pd-try__add" for="<?=$p->id?>">                
                    <i class="icon-3"></i>
                  </span>
                  <a href="<?=Url::to(['content/index','product_id'=>$p->id])?>" class="btn-sm-1">try demo</a>
                </div>
                </div>
              </div>
            </div>
            <?php }?>
          </div>
        </div>
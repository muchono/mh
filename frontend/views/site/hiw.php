<?php

use yii\helpers\Url;

/* @var $this yii\web\View */

$this->title = 'How it works';
?>
<section class="how-it-works">
      <div class="container-sm">
        <div class="page-pane">
          <div class="breadcrumbs-2">
            <ul class="breadcrumbs-2__list">
              <li class="breadcrumbs-2__item">
                <a href="<?=Url::to(['site/index'])?>" class="breadcrumbs-2__link">MarketingHack</a>
              </li>
              <li class="breadcrumbs-2__item">
                <a href="<?=Url::to(['site/products'])?>" class="breadcrumbs-2__link">Products</a>
              </li>
              <li class="breadcrumbs-2__item">
                <span class="breadcrumbs-2__text">Forum Link Building Techiques</span>
              </li>
            </ul>
          </div>
          <h1 class="title-9">How It Works</h1>
          <p>WordPress never stops growing in its popularity so it’s only natural that the number of available themes keeps growing year after year. WordPress developers and designers have been busy this year as well, bringing us tons of fresh, new themes for our marketplace. If you’ve been thinking about giving your site a makeover or if you’re planning to finally launch your website this year, don’t miss our roundup of the best WordPress themes in 2017.</p>
          <p>Our roundup includes the best selling themes of the year as well as the top five themes from select categories. You’ll find themes for creatives, business and store owners, as well as the top trending themes of the year. WordPress never stops growing in its popularity so it’s only natural that the number of available themes keeps growing year after year. WordPress developers and designers have been busy this year as well, bringing us tons of fresh, new themes for our marketplace. </p>
          <h2 class="title-11">Does Your Website Work Effectively and Efficiently?</h2>
          <p>WordPress never stops growing in its popularity so it’s only natural that the number of available themes keeps growing year after year. WordPress developers and designers have been busy this year as well, bringing us tons of fresh, new themes for our marketplace. If you’ve been thinking about giving your site a makeover or if you’re planning to finally launch your website this year, don’t miss our roundup of the best WordPress themes in 2017.</p>
          <p>Our roundup includes the best selling themes of the year as well as the top five themes from select categories. You’ll find themes for creatives, business and store owners, as well as the top trending themes of the year.</p>
          <p>WordPress never stops growing in its popularity so it’s only natural that the number of available themes keeps growing year after year. WordPress developers and designers have been busy this year as well, bringing us tons of fresh, new themes for our marketplace. If you’ve been thinking about giving your site a makeover or if you’re planning to finally launch your website this year, don’t miss our roundup of the best WordPress themes in 2017.</p>
          <p>Our roundup includes the best selling themes of the year as well as the top five themes from select categories. You’ll find themes for creatives, business and store owners, as well as the top trending themes of the year.</p>
          <figure>
            <img src="img/hit-img.jpg" alt="" class="img-fluid">
          </figure>
          <p>WordPress never stops growing in its popularity so it’s only natural that the number of available themes keeps growing year after year. WordPress developers and designers have been busy this year as well, bringing us tons of fresh, new themes for our marketplace. If you’ve been thinking about giving your site a makeover or if you’re planning to finally launch your website this year, don’t miss our roundup of the best WordPress themes in 2017. Our roundup includes the best selling themes of the year as well as the top five themes from select categories. You’ll find themes for creatives, business and store owners, as well as the top trending themes of the year.</p>
          <h2 class="title-11">Does Your Website Work Effectively and Efficiently?</h2>
          <figure>
            <img src="img/hit-img-2.jpg" alt="" class="img-fluid">
          </figure>
          <p>WordPress never stops growing in its popularity so it’s only natural that the number of available themes keeps growing year after year. WordPress developers and designers have been busy this year as well, bringing us tons of fresh, new themes for our marketplace. If you’ve been thinking about giving your site a makeover or if you’re planning to finally launch your website this year, don’t miss our roundup of the best WordPress themes in 2017. Our roundup includes the best selling themes of the year as well as the top five themes from select categories. You’ll find themes for creatives, business and store owners, as well as the top trending themes of the year.</p>
          <p>WordPress never stops growing in its popularity so it’s only natural that the number of available themes keeps growing year after year. WordPress developers and designers have been busy this year as well, bringing us tons of fresh, new themes for our marketplace. If you’ve been thinking about giving your site a makeover or if you’re planning to finally launch your website this year, don’t miss our roundup of the best WordPress themes in 2017. Our roundup includes the best selling themes of the year as well as the top five themes from select categories. You’ll find themes for creatives, business and store owners, as well as the top trending themes of the year.</p>
          <p>WordPress never stops growing in its popularity so it’s only natural that the number of available themes keeps growing year after year. WordPress developers and designers have been busy this year as well, bringing us tons of fresh, new themes for our marketplace. If you’ve been thinking about giving your site a makeover or if you’re planning to finally launch your website this year, don’t miss our roundup of the best WordPress themes in 2017. Our roundup includes the best selling themes of the year as well as the top five themes from select categories. You’ll find themes for creatives, business and store owners, as well as the top trending themes of the year.</p>
          <p>WordPress never stops growing in its popularity so it’s only natural that the number of available themes keeps growing year after year. WordPress developers and designers have been busy this year as well, bringing us tons of fresh, new themes for our marketplace. If you’ve been thinking about giving your site a makeover or if you’re planning to finally launch your website this year, don’t miss our roundup of the best WordPress themes in 2017. Our roundup includes the best selling themes of the year as well as the top five themes from select categories. You’ll find themes for creatives, business and store owners, as well as the top trending themes of the year.</p>
        </div>

        <div class="recommend-items">
          <h2 class="ri__title">Recommend Items</h2>
          <div class="ri__row">
            <?php foreach($products as $p) {?>
            <div class="ri__col">
              <div class="product">
                <div class="pd__head">
                  <div class="pd__text-1"><?=$p->short_title?></div>
                  <h3 class="title-2"><?=$p->title?></h3>
                  <div class="pd__text-2"><?=$p->full_title?>:</div>
                  <i class="icon-<?=($p->priceFinal) ? 1 : 2?>"></i>
                </div>
                <div class="pd__content">
                  <ul class="list-1">
                    <?php foreach($p->guide as $g) {?>
                      <li><?=$g->title?></li>
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
                  <span class="pd-try__add">                
                    <i class="icon-3"></i>
                  </span>
                  <a href="" class="btn-sm-1">try demo</a>
                </div>
                </div>
              </div>
            </div>
            <?php }?>
          </div>
        </div>
      </div>
    </section>
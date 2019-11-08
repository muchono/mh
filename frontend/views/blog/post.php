<?php
use yii\helpers\Url;
use common\models\OrderToProduct;
/* @var $model \common\models\Post */
?>
<section class="post-page">
      <div class="container-md">
        <div class="post-page-head">
          <div class="breadcrumbs">
            <ul class="breadcrumbs__list">
                <?php foreach($model->categories as $c) {?>
              <li class="breadcrumbs__item">
                <a href="<?=Url::to(['blog/', 'cid'=>$c->id]);?>" class="breadcrumbs__link"><?=$c->title?></a>
              </li>
                <?php }?>
            </ul>
          </div>
          <h1 class="title-9"><?=$model->title?></h1>
          <p class="post-page-head__text"><?=$model->meta_description?></p>
          <div class="post-page-head__meta">
            <div class="post-page-head__author">
              <?php if ($model->avatar_image) {?>
              <figure><img width="50" height="50" src="<?=Url::base()?>/images/blog/<?=$model->avatar_image?>" alt=""></figure>
              <?php }?>
              <div>
                  by <?=$model->getAuthor() ?>
              </div>
            </div>
            <div class="post-page-head__comments" style="display:none"><a href=""><i class="icon-13"></i> 0 Comments</a></div>
          </div>
        </div>
        <div class="post-page-wrap">
          <div class="post-page-content">
            <article class="post-article">
              <figure class="post-page__img"><img src="<?=Url::base()?>/images/blog/<?=$model->image?>" alt="" class="img-fluid"></figure>
              <span class="reset-this">
              <?=$model->content?>
              </span>
              
            </article>
            <?php if ($model->author_bio){?>
            <div class="by-author">
              <?php if ($model->avatar_image) {?>
              <figure class="by-author__img"><img src="<?=Url::base()?>/images/blog/<?=$model->avatar_image?>" alt=""></figure>
              <?php }?>                
              
              <h4 class="title-12">Written by <?=$model->getAuthor() ?></h4>
              <?=$model->author_bio ?>
            </div>
            <?php }?>
            <div class="related-posts">
              <h2 class="title-11">Related Posts:</h2>
              <ul class="related-posts-list">
                <?php foreach ($model->getRelated() as $d) {?>
                <li class="related-posts__item">
                  <article class="post">
                    <figure class="post__image">
                      <a href="<?=Url::to(['blog/url', 'url'=>$d->url_anckor]);?>"><img src="<?=Url::base()?>/images/blog/<?=$d->image?>" alt="" class="img-fluid"></a>
                    </figure>
                    <div class="post__content">
                      <h3 class="title-13"><a href="<?=Url::to(['blog/url', 'url'=>$d->url_anckor]);?>"><?=$d->title ?></a></h3>
                      <p class="post__text"><?=$d->meta_description ?>...</p>
                      <div class="post__meta">
                        <span class="post__author">by <?=$d->getAuthor() ?></span>
                      </div>
                    </div>
                  </article>
                </li>
                <?php }?>
              </ul>
            </div>
          </div>
          <aside class="post-page-side-bar">
            <?php if ($special_offer){?>
            <div class="advertising-block">
                <a href="<?=Url::to(['site/special-offer']);?>"><img src="<?=Url::base()?>/images/discount/<?=$special_offer->file1?>" alt=""></a>
            </div>
            <?php }?>
            <h2 class="title-10">Recommended for you:</h2>
            <?php foreach ($model->getRelatedProducts() as $p) {?>
            <article class="post">
              <div class="product">
                <div class="pd__head">
                  <div class="pd__text-1"><?=$p->short_title?></div>
                  <a href="<?=Url::to(['site/product','link'=>$p->page->link])?>"><h3 class="title-2"><?=$p->links_available ? $p->getHrefsCount() : ''?>  <?=$p->title?></h3></a>
                  <div class="pd__text-2"><?=$p->full_title?>:</div>
                  <i class="icon-<?=(!OrderToProduct::isAccessible($p->id, Yii::$app->user->id)) ? 1 : 2?>"></i>
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
                    <?php if (!OrderToProduct::isAccessible($p->id, Yii::$app->user->id)) {?>
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
            </article>
             <?php }?>
          </aside>
        </div>
      </div>
    </section>
    
    <?= $this->render('_bottom', [
    ]) ?>
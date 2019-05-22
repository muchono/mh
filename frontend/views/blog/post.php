<?php
use yii\helpers\Url;

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
          <h2 class="title-9"><?=$model->title?></h2>
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
              <h2 class="title-11"><?=$model->title?></h2>
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
                <a href="<?=Url::to(['site/product', 'product_id'=>$special_offer->getProducts()->one()->id]);?>"><img src="<?=Url::base()?>/images/discount/<?=$special_offer->file1?>" alt=""></a>
            </div>
            <?php }?>
            <h2 class="title-10">Recommended for you:</h2>
            <?php foreach ($model->getRecommended() as $d) {?>
            <article class="post">
              <figure class="post__image">
                <a href="<?=Url::to(['blog/url', 'url'=>$d->url_anckor]);?>"><img src="<?=Url::base()?>/images/blog/<?=$d->image?>" alt="" class="img-fluid"></a>
              </figure>
              <div class="post__content">
                <h3 class="title-7 "><a href="<?=Url::to(['blog/url', 'url'=>$d->url_anckor]);?>"><?=$d->title ?></a></h3>
                <p class="post__text"><?=$d->meta_description ?>...</p>
                <div class="post__meta">
                  <span class="post__author">by <?=$d->getAuthor() ?></span>
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
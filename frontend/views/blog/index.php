<?php
use yii\helpers\Url;

?>
<section class="blog-page">
      <div class="container-lg">
        <div class="blog-head">
          <h2 class="title-1">MarketngHack Blog</h2>
          <p class="head-text">All about digital marketing: SEO, SEM, SMM, Linkbuilding</p>
        </div>
        <div class="post-list">
         <?php foreach($posts->getModels() as $p){?> 
         <div class="post-list__item">
            <article class="post">
              <figure class="post__image">
                <a href="<?=Url::to(['post', 'id'=>$p->id]);?>"><img src="<?=Url::base()?>/images/blog/<?=$p->image?>" alt="" class="img-fluid"></a>
              </figure>
              <div class="post__content">
                <h3 class="title-7 "><a href="<?=Url::to(['post', 'id'=>$p->id]);?>"><?=$p->title?></a></h3>
                <p class="post__text"><?=$p->meta_description?>...</p>
                <div class="post__meta">
                  <span class="post__author">by <?=$p->author?></span>
                </div>
              </div>
            </article>
          </div>
         <?php }?>
        </div>
          

        <div class="pagination">
         <?php
echo frontend\widgets\LinkPagerMh::widget([
    'pagination'=>$posts->pagination,
    'maxButtonCount'=>4,
    'prevPageCssClass'=>'pgn-switcher__btn',
    'nextPageCssClass'=>'pgn-switcher__btn',
    'firstPageLabel'=>true,
    'lastPageLabel'=>true,
    ]);
?> 
        </div>
      </div>
    </section>
    <?= $this->render('_bottom', [
    ]) ?>
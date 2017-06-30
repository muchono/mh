<?php
use yii\helpers\Url;

$this->title = 'FAQ';


?>
<section class="simple-page">
      <div class="breadcrumbs-2">
        <ul class="breadcrumbs-2__list">
          <li class="breadcrumbs-2__item">
              <a href="<?=Url::to(['site/index'])?>" class="breadcrumbs-2__link">MarketingHack</a>
          </li>
          <li class="breadcrumbs-2__item">
            <a href="<?=Url::to(['site/faq'])?>" class="breadcrumbs-2__link">F.A.Q.</a>
          </li>
          <li class="breadcrumbs-2__item">
            <span class="breadcrumbs-2__text"><?=$model->title?></span>
          </li>
        </ul>
      </div>
      <h1 class="title-16"><?=$model->title?></h1>
      <div class="search-answer">
        <p><?=$model->answer?></p>
      </div>
      <h2 class="title-15">Related Questions:</h2>
      <ul class="pq-list">
        <?php foreach ($faqs as $f) {?>
        <li class="pq__item"><a href="<?=Url::to(['site/faq', 'id' => $f->id])?>" class="pq__link"><?=$f->title?></a></li>
        <?php }?>
      </ul>
    </section>
<?php

use yii\helpers\Url;


use yii\widgets\ActiveForm;

/* @var $this yii\web\View */

$this->title = 'Search Results';
?>
<section class="simple-page sm">
      <div class="breadcrumbs-2">
        <ul class="breadcrumbs-2__list">
          <li class="breadcrumbs-2__item">
            <a href="<?=Url::to(['site/index'])?>" class="breadcrumbs-2__link">MarketingHack</a>
          </li>
          <li class="breadcrumbs-2__item">
            <span class="breadcrumbs-2__text">F.A.Q.</span>
          </li>
        </ul>
      </div>
      <h1 class="title-15">Search Results:
        <span class="search-result"><?=$keywords?></span>
      </h1>
      <ul class="ask-list ask-list--result">
          <?php foreach($faqs as $f){?>
        <li class="ask-list__item"><a href="<?=Url::to(['site/faq', 'id' => $f->id])?>" class="ask-list__link"><?=$f->title?></a></a></li>
          <?php }?>
      </ul>
      <a href="<?=Url::to(['site/support'])?>" class="btn-back">back to search</a>
    </section>
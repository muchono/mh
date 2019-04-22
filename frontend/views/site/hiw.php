<?php

use yii\helpers\Url;

/* @var $this yii\web\View */

$this->title = 'How it works';

use common\models\PagesContent;
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
          <?=PagesContent::findOne(4)->content?>
        </div>

    <?= $this->render('_recommend_items', [
        'products' => $products,
    ]) ?>
      </div>
    </section>
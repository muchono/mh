<?php

use yii\helpers\Url;

/* @var $this yii\web\View */

$this->title = 'How it works';

use common\models\PagesContent;
$content = PagesContent::findOne(4);
?>
<section class="how-it-works">
      <div class="container-sm">
        <div class="page-pane">
          <div class="breadcrumbs-2">
            <ul class="breadcrumbs-2__list">
              <li class="breadcrumbs-2__item">
                <a href="<?=Url::home()?>" class="breadcrumbs-2__link">MarketingHack</a>
              </li>
              <li class="breadcrumbs-2__item">
                <span class="breadcrumbs-2__text"><?=$content->name?></span>
              </li>
            </ul>
          </div>
          <h1 class="title-9"><?=$content->name?></h1>
          <div class="reset-this">
          <?=$content->content?>
          </div>
        </div>

    <?= $this->render('_recommend_items', [
        'products' => $products,
    ]) ?>
      </div>
    </section>
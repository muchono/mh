<?php
use yii\helpers\Url;
?>
<div class="guide-container">
              <div class="contents-list-block">
                <i class="contents-list-block__icon"></i>
                <h3 class="contents-list__head">Guide Table</h3>
                <ol class="contents-list">
                  <?php foreach ($product->guide as $g){?>
                  <li class="contents-list__item"><a href="#title_<?=$g->id?>"><?=$g->title?></a></li>
                  <?php }?>
                </ol>
              </div>
              <?php foreach ($product->guide as $g){?>
              <h2 class="title-5" id="title_<?=$g->id?>"><?=$g->title?></h2>
			  <span class="reset-this">
                  <p class="text-1"><?=$accessable ? str_replace('index.php?r=product-guide%2Fget-image', Url::to(['product-guide/get-image', 'token' => md5(time())]), $g->aboutClear) : $g->aboutCode?> </p>
			  </span>
              <?php }?>
              <div class="alert-1"><i class="alert-ic-1"></i>This content is protected by copyright and is intended for viewing only on MarketingHack.net. Its use: copy, placement, distribution (with a link to this site or not) will be prosecuted according to the Digital Millennium Copyright Act (DMCA).</div>
            </div>
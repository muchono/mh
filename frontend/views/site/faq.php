<?php

use yii\jui\AutoComplete;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

use common\models\Faq;

/* @var $this yii\web\View */

$this->title = 'FAQ';

?>

<section class="simple-page">
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
      <h1 class="title-15">Questions and Answers</h1>
      <div class="search-questions">
        <?php $form = ActiveForm::begin(); ?>
        <?php echo AutoComplete::widget([

            'name' => 'search',
            'options' => ['class' => 'search-questions__input', 'placeholder' => 'Search for your questions'],
            'clientOptions' => [
                'source' => Faq::find()
                        ->select(['title as value', 'title as label', 'id as id'])
                        ->asArray()
                        ->all(),
                'select' => new JsExpression("function( event, ui ) {
                    location.replace('".Url::to(['site/faq'])."&id='+ui.item.id);    
                }"),
                
                /*
                "js:function(request, response) {
    $.getJSON('".$url"', {
        term: extractLast(request.term)
    }, response);
}"*/
            ],
        ]);?>
          
            <?php ActiveForm::end(); ?>
      </div>
      <h2 class="title-15">Popular Questions:</h2>
      <ul class="pq-list">
        <?php foreach ($faqs as $f) {?>
        <li class="pq__item"><a href="<?=Url::to(['site/faq', 'id' => $f->id])?>" class="pq__link"><?=$f->title?></a></li>
        <?php }?>
      </ul>
    </section>
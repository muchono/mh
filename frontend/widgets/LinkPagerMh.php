<?php
namespace frontend\widgets;
use Yii;
use yii\base\InvalidConfigException;
use yii\helpers\Html;
use yii\base\Widget;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;

class LinkPagerMh extends \yii\widgets\LinkPager {
    /**
     * @inheritdoc
     */    
    public $options = ['class' => 'pgn-list'];
    public $linkOptions = ['class' => 'pgn-list__link'];
    
    public $activePageCssClass = 'pgn-list__link pgn-list__link--active';
    public $disabledPageCssClass = 'pgn-list__item';
    public $pageCssClass = 'pgn-list__item';
    public $firstPageCssClass = 'pgn-list__item';
    public $lastPageCssClass = 'pgn-list__item';
    
    /**
     * @inheritdoc
     */
    protected function renderPageButtons()
    {
        $pageCount = $this->pagination->getPageCount();
        if ($pageCount < 2 && $this->hideOnSinglePage) {
            return '';
        }

        $buttons = [];
        $currentPage = $this->pagination->getPage();

        // first page
        $firstPageLabel = $this->firstPageLabel === true ? '1' : $this->firstPageLabel;
        if ($firstPageLabel !== false) {
            $buttons[] = $this->renderPageButton($firstPageLabel, 0, $this->firstPageCssClass, false, $currentPage <= 0);
        }

        // internal pages
        list($beginPage, $endPage) = $this->getPageRange();
        
        if ($beginPage > 1) {
            $buttons[] = $this->renderPageButton('...', $beginPage - 1, $this->firstPageCssClass, false, false);
        }        
        for ($i = $beginPage; $i <= $endPage; ++$i) {
            if ($this->firstPageLabel && ($i + 1 == 1)) {
                continue;
            }
            if ($this->lastPageLabel && ($i + 1 >= $pageCount)) {
                continue;
            }            
            $buttons[] = $this->renderPageButton($i + 1, $i, null, false, $i == $currentPage);
        }
        if ($endPage+1 < $pageCount-1) {
            $buttons[] = $this->renderPageButton('...', $endPage + 1, $this->firstPageCssClass, false, false);
        }         

        // last page
        $lastPageLabel = $this->lastPageLabel === true ? $pageCount : $this->lastPageLabel;
        if ($lastPageLabel !== false) {
            $buttons[] = $this->renderPageButton($lastPageLabel, $pageCount - 1, $this->lastPageCssClass, false, $currentPage >= $pageCount - 1);
        }
        
        return $this->renderPrevNext($currentPage, $pageCount). Html::tag('ul', implode("\n", $buttons), $this->options);
    }
    
    /**
     * Renders a previous and next page buttons.
     * @param string $label the text label for the button
     * @param int $currentPage current page number
     * @param int $pageCount the page number
     * @return string the rendering result
     */
    protected function renderPrevNext($currentPage, $pageCount)
    {        // prev page
        if ($this->prevPageLabel !== false) {
            if (($page = $currentPage - 1) < 0) {
                $page = 0;
            }
            //$buttons[] = $this->renderPageButton($this->prevPageLabel, $page, $this->prevPageCssClass, $currentPage <= 0, false);
            if ($currentPage != $page) {
                $buttons[] = Html::a(Html::tag('i', '', ['class' => 'pgn-prev']), $this->pagination->createUrl($page), ['class' => 'pgn-switcher__btn']);
            }
        }
        
        // next page
        if ($this->nextPageLabel !== false) {
            if (($page = $currentPage + 1) >= $pageCount - 1) {
                $page = $pageCount - 1;
            }

            //$buttons[] = $this->renderPageButton($this->nextPageLabel, $page, $this->nextPageCssClass, $currentPage >= $pageCount - 1, false);
            if ($currentPage + 1 < $pageCount) {
                $buttons[] = Html::a(Html::tag('i', '', ['class' => 'pgn-next']), $this->pagination->createUrl($page), ['class' => 'pgn-switcher__btn']);
            }
        }
        return Html::tag('div', join('', $buttons), ['class' => 'pgn-switcher']);
    }
    
    protected function renderPageButton($label, $page, $class, $disabled, $active)
    {
        $options = ['class' => empty($class) ? $this->pageCssClass : $class];
        
        $linkOptions = $this->linkOptions;
        $linkOptions['data-page'] = $page;
        
        $c = Html::a($label, $this->pagination->createUrl($page), $linkOptions);
        if ($active) {
            $c = Html::tag('span', $label, ['class' => $this->activePageCssClass]);
        }
        if ($disabled) {
            Html::addCssClass($options, $this->disabledPageCssClass);
            $tag = ArrayHelper::remove($this->disabledListItemSubTagOptions, 'tag', 'span');
            
            return Html::tag('li', Html::tag($tag, $label, $this->disabledListItemSubTagOptions), $options);
        }

        return Html::tag('li', $c, $options);
    }    
}
?>
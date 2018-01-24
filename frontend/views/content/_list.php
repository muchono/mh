            <div class="table-view">
              <div class="table-info">
                <div>Latest update: <strong><?=$last_update?></strong></div>
                <ul class="filter-list">
                  <li class="filter-list__item">
                    Show
                    <div class="filter-list__select">
                      <select name="urls_filter">
                        <option value="all_urls">All URLs</option>
                        <option value="latest_urls" <?= $sort['urls_filter'] == 'latest_urls' ? 'selected' : ''?>>Latest Update</option>
                      </select>
                    </div>
                  </li>
                  <li class="filter-list__item">
                    Sort By
                    <div class="filter-list__select" name="order_filter">
                      <select>
                        <option value="da_rank:down" <?= $sort['list_sort'] == 'da_rank:down' ? 'selected' : ''?>>DA</option>
                        <option value="alexa_rank:down" <?= in_array($sort['list_sort'], array('alexa_rank:down', 'alexa_rank:up')) ? 'selected' : ''?>>Alexa</option>
                        <option value="url:down" <?= $sort['list_sort'] == 'url:down' ? 'selected' : ''?>>Alphabet</option>
                      </select>
                    </div>
                  </li>
                  <li class="filter-list__item">
                    Show
                    <div class="filter-list__select">
                      <select name="pages_filter">
                          <?php foreach([50,100,25] as $p){?>
                          <option value="<?=$p?>" <?=$p == $sort['page_size'] ? 'selected': ''?>><?=$p?></option>
                          <?php }?>
                      </select>
                    </div>
                    Per Page
                  </li>
                  <li class="filter-list__item"><span class="filter-list__info">Showing <?=$begin=$pages->getPage() * $pages->pageSize + 1?> to <?=$begin + $hrefsProvider->getCount()-1?> of <?=$hrefsProvider->getTotalCount()?> URLs</span></li>
                </ul>
              </div>
              
              <table class="table-1">
                <thead>
                  <tr>
                    <th class="tb__1">#</th>
                    <th class="tb__2"><i class="icon-10"></i></th>
                    <th class="tb__3">
                      URL
                      <span class="table-filter">
                        <span class="tf-wrap">
                          <span class="tf-wrap__up" for="url"></span>
                          <span class="tf-wrap__down" for="url"></span>
                        </span>
                      </span>
                    </th>
                    <th class="tb__4">
                      DA
                      <span class="table-filter">
                        <span class="tf-wrap">
                          <span class="tf-wrap__up" for="da_rank"></span>
                          <span class="tf-wrap__down" for="da_rank"></span>
                        </span>
                      </span>
                    </th>
                    <th class="tb__5">
                      Alexa
                      <span class="table-filter">
                        <span class="tf-wrap">
                          <span class="tf-wrap__up" for="alexa_rank"></span>
                          <span class="tf-wrap__down" for="alexa_rank"></span>
                        </span>
                      </span>
                    </th>
                    <th class="tb__6">
                      Category
                      <span class="table-filter">
                        <span class="tf-wrap">
                          <span class="tf-wrap__up" for="categoryFirst"></span>
                          <span class="tf-wrap__down" for="categoryFirst"></span>
                        </span>                          
                      </span>
                    </th>
                    <th class="tb__7">
                      Details
                      <span class="table-filter">
                        <span class="tf-wrap">
                          <span class="tf-wrap__up" for="type_links"></span>
                          <span class="tf-wrap__down" for="type_links"></span>
                        </span>                          
                      </span>
                    </th>
                    <th class="tb__8">Example</th>
                    <th class="tb__9">
                      R
                    </th>
                  </tr>
                </thead>
                <tbody>
                    <?php foreach($hrefsProvider->getModels() as $i=>$link) {?>
                  <tr>
                    <td class="tb__1"><?=$i+1?></td>
                    <td class="tb__2"><i class="icon-11 <?=$accessable ? '' : 'unclickable'?>" for="<?=$link->id?>"></i></td>
                    <td class="tb__3"><a href="<?=$accessable ? $link->url : ''?>" class=" <?=$accessable ? '' : 'unclickable'?>" target="_blank"><?=$accessable ? $link->url : $link->urlCoded?></a></td>
                    <td class="tb__4"><?=$link->da_rank?></td>
                    <td class="tb__5"><?=$link->alexa_rank?></td>
                    <td class="tb__6"><?= join(', ', $link->getCategoriesArray())?></td>
                    <td class="tb__7">
                        <?php if (in_array($link->type_links, array('nofollow','follow'))) {?>
                        <a class="<?=$link->type_links?>-link unclickable"><?=  \common\models\ProductHref::$link_types[$link->type_links]?></a>.
                        <?php } else {?>
                        <a href="" class="<?=$link->type_links?>-link unclickable"><?=  $link->type_links && $link->type_links != 'no_links' ? \common\models\ProductHref::$link_types[$link->type_links] : ''?></a>
                        
                        <?php }?>
                        <?=$accessable ? $link->about : $link->aboutCoded?>
                    </td>
                    <td class="tb__8"><a href="<?=$accessable ? $link->example_url : '#'?>" class=" <?=$accessable ? '' : 'unclickable'?>" target="_blank">Example</a></td>
                    <td class="tb__9"><div><i class="icon-12" for="<?=$accessable ? $link->id:''?>"></i></div></td>
                  </tr>
                    <?php }?>
                </tbody>
              </table>
            </div>

            <div class="pagination">
         <?php
        echo frontend\widgets\LinkPagerMh::widget([
            'pagination'=>$hrefsProvider->pagination,
            'maxButtonCount'=>4,
            'prevPageCssClass'=>'pgn-switcher__btn',
            'nextPageCssClass'=>'pgn-switcher__btn',
            'firstPageLabel'=>true,
            'lastPageLabel'=>true,
            ]);
        ?>               
        </div>
        <div class="report hide" id="report_issue">
          <div class="report__head">
            Please Report
            <span class="report__close">
              <i></i>
            </span>
          </div>
          <div class="report__content">
            <ul class="report-list">
              <?php foreach($report_list as $k=>$r) { ?>
              <li class="report-list__item">
                  <input type="checkbox" id="input-<?=$k?>" name="report[]" value="<?=$k?>">
                <label for="input-<?=$k?>"><?=$r?></label>
              </li>
              <?php }?>
            </ul>
          </div>
          <div class="report__foot">
            <a href="" class="btn-report">send report</a>
          </div>
        </div>

        <div class="report hide" id="report_result">
          <div class="report__head">
            Please Report
            <span class="report__close">
              <i></i>
            </span>
          </div>
          <div class="report__content">
            <figure class="report__img">
              <img src="img/report-thank-img.jpg" alt="" class="img-fluid">
            </figure>
          </div>
          <div class="report__foot">
            <div class="btn-report-disable">Thank you!</div>
          </div>
        </div>
          
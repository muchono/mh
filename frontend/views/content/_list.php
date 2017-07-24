
            <div class="table-view">
              <div class="table-info">
                <div>Latest update: <strong>06.24.2016</strong></div>
                <ul class="filter-list">
                  <li class="filter-list__item">Show <span class="filter-list__filter">All URLs</span></li>
                  <li class="filter-list__item">Sort By <span class="filter-list__filter">DA</span></li>
                  <li class="filter-list__item">Show <span class="filter-list__filter">50</span> Per Page</li>
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
                          <span class="tf-wrap__up"></span>
                          <span class="tf-wrap__down"></span>
                        </span>
                      </span>
                    </th>
                    <th class="tb__4">
                      DA
                      <span class="table-filter">
                        <span class="tf-wrap">
                          <span class="tf-wrap__up"></span>
                          <span class="tf-wrap__down"></span>
                        </span>
                      </span>
                    </th>
                    <th class="tb__5">
                      Alexa
                      <span class="table-filter">
                        <span class="tf-wrap">
                          <span class="tf-wrap__up"></span>
                          <span class="tf-wrap__down"></span>
                        </span>
                      </span>
                    </th>
                    <th class="tb__6">
                      Category
                    </th>
                    <th class="tb__7">
                      Details
                      <span class="table-filter">
                        <span class="tf-wrap">
                          <span class="tf-wrap__up"></span>
                          <span class="tf-wrap__down"></span>
                        </span>
                      </span>
                    </th>
                    <th class="tb__8">Example</th>
                    <th class="tb__9">R</th>
                  </tr>
                </thead>
                <tbody>
                    <?php foreach($hrefsProvider->getModels() as $i=>$link) {?>
                  <tr>
                    <td class="tb__1"><?=$i+1?></td>
                    <td class="tb__2"><i class="icon-10"></i></td>
                    <td class="tb__3"><a href="<?=$link->url?>" target="_blank"><?=$link->url?></a></td>
                    <td class="tb__4"><?=$link->da_rank?></td>
                    <td class="tb__5"><?=$link->alexa_rank?></td>
                    <td class="tb__6"><?= join(', ', $link->getCategoriesArray())?></td>
                    <td class="tb__7"><a href="" class="follow-link"><?=  \common\models\ProductHref::$link_types[$link->type_links]?></a></td>
                    <td class="tb__8"><a href="<?=$link->example_url?>" target="_blank">Example</a></td>
                    <td class="tb__9"><i class="icon-12"></i></td>
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
          
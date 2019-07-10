            <?php foreach($cartInfo['products'] as $k=>$p){?>  
            <tr class="ot__row ot__row--selected">
              <td class="ot__num">
                &nbsp;
              </td>
              <td class="ot__product"><?=$p->short_title?>: list + guide (subscription on <?=$cartInfo['cart'][$k]->months?> year<?=$cartInfo['cart'][$k]->months > 1 ? 's' : ''?>)</td>
              <td class="ot__cost"><?=$cartInfo['prices_final'][$k] ? '$'.$cartInfo['prices_final'][$k] : 'Free'?></td>
            </tr>
            <?php }?>
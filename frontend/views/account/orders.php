<section class="simple-page sm">
      <h2 class="title-14">My Account</h2>
          <?= $this->render('_menu', [
    ]) ?>
      <h2 class="title-14">Order History:</h2>
      <p class="transactions">1 - <?=$orders_count?> of <?=$orders_count?> Transactions</p>
      <div class="table-view">
        <table class="order-history">
          <thead>
            <tr>
              <th class="oh__id">Order ID</th>
              <th class="oh__date">Date</th>
              <th class="oh__desc">Description</th>
              <th class="oh__payment">Payment</th>
              <th class="oh__total">Total</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($orders as $key => $o) {?>
            <tr class="oh__row">
              <td class="oh__id"><?=$o->id?></td>
              <td class="oh__date"><?=date('m/d/Y', $o->created_at)?></td>
              <td class="oh__desc">
                  <?php foreach ($o->productIDs as $op) {?>
                  <div><?=$op->product->short_title?>: list + guide (subscription on <?=$op->months?> year<?=$op->months > 1 ?'s':''?>)</div>
                  <?php }?> 
              </td>
              <td class="oh__payment"><?=$o->payment_method?></td>
              <td class="oh__total">$<?=$o->total?></td>
            </tr>
            <?php }?> 
          </tbody>
        </table>
      </div>
    </section>
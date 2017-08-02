<section class="simple-page sm">
      <h2 class="title-14">My Account</h2>
    <?= $this->render('_menu', [
    ]) ?>
      <h2 class="title-14">My Products:</h2>
      <table class="my-product my-product--separate">
        <thead>
          <tr>
            <th class="ot__num">№</th>
            <th class="ot__product">Product</th>
            <th class="ot__expires">Expires</th>
            <th class="ot__renew">Renew</th>
          </tr>
        </thead>
        <tbody>
          <tr class="ot__row ot__row--selected">
            <td class="ot__num">
              <div class="checkbox-1">
                <input id="cb-1" type="checkbox">
                <label for="cb-1"></label>
              </div>
            </td>
            <td class="ot__product">
              Guest Post Marketing: list + guide (subscription on 1 year)
              <div class="ot__product-mb-only">
                21 Aug 2017 <br>
                <a href="" class="btn-sm-2">Renew</a>
              </div>
            </td>
            <td class="ot__expires">21 Aug 2017</td>
            <td class="ot__renew">
              <a href="" class="btn-sm-2">Renew</a>
            </td>
          </tr>
          <tr class="ot__row ot__row--selected">
            <td class="ot__num">
              <div class="checkbox-1">
                <input id="cb-2" type="checkbox">
                <label for="cb-2"></label>
              </div>
            </td>
            <td class="ot__product">
              Guest Post Marketing: list + guide (subscription on 1 year)
              <div class="ot__product-mb-only">
                21 Aug 2017 <br>
                <a href="" class="btn-sm-2">Renew</a>
              </div>
            </td>
            <td class="ot__expires">21 Aug 2017</td>
            <td class="ot__renew">
              <a href="" class="btn-sm-2">Renew</a>
            </td>
          </tr>
          <tr class="ot__row">
            <td class="ot__num">
              <div class="checkbox-1">
                <input id="cb-3" type="checkbox">
                <label for="cb-3"></label>
              </div>
            </td>
            <td class="ot__product">
              Guest Post Marketing: list + guide (subscription on 1 year)
              <div class="ot__product-mb-only">
                21 Aug 2017 <br>
                <a href="" class="btn-sm-2">Renew</a>
              </div>
            </td>
            <td class="ot__expires">21 Aug 2017</td>
            <td class="ot__renew">
              <a href="" class="btn-sm-2">Renew</a>
            </td>
          </tr>
          <tr class="ot__row">
            <td class="ot__num">
              <div class="checkbox-1">
                <input id="cb-4" type="checkbox">
                <label for="cb-4"></label>
              </div>
            </td>
            <td class="ot__product">
              Guest Post Marketing: list + guide (subscription on 1 year)
              <div class="ot__product-mb-only">
                21 Aug 2017 <br>
                <a href="" class="btn-sm-2">Renew</a>
              </div>
            </td>
            <td class="ot__expires">21 Aug 2017</td>
            <td class="ot__renew">
              <a href="" class="btn-sm-2">Renew</a>
            </td>
          </tr>
        </tbody>
      </table>

      <div class="account-foot">
        <button class="btn-sm-2">Renew selected products</button>
      </div>
    </section>
<section class="simple-page sm">
      <h2 class="title-14">My Account</h2>
          <?= $this->render('_menu', [
    ]) ?>
      <h2 class="title-14">Edit Profile:</h2>
      <div class="youremail">
        <div class="youremail__title">Email</div>
        <p class="youremail__text">yourname@gmail.com</p>
      </div>
      <div class="account-info">
        <div class="account-field-row">
          <div class="account-field">
            <label for="" class="bf__label">First Name</label>
            <input type="text" class="bf__input">
            <span class="bf__info">(for individuals only)</span>
          </div>
          <div class="account-field account-field--auto">
            <span class="bf__or">or</span>
          </div>
          <div class="account-field">
            <label for="" class="bf__label">Company Name</label>
            <input type="text" class="bf__input">
            <span class="bf__info">(for legal entities only)</span>
          </div>
        </div>
        <div class="account-field-row">
          <div class="account-field account-field--novalidate">
            <label for="" class="bf__label">Last Name</label>
            <input type="text" class="bf__input">
            <span class="bf__info">(for individuals only)</span>
          </div>
        </div>
        <div class="account-field-row">
          <div class="account-field">
            <label for="" class="bf__label">Phone Number</label>
            <input type="text" class="bf__input">
            <span class="bf__info">(to this phone number you will get SMS code)</span>
          </div>
        </div>
        <div class="account-field-row">
          <div class="account-field">
            <label for="" class="bf__label">Country</label>
            <select name="" id="" class="bf__select">
              <option value="">lorem</option>
              <option value="">lorem</option>
              <option value="">lorem</option>
              <option value="">lorem</option>
              <option value="">lorem</option>
            </select>
            <span class="bf__info">(to this phone number you will get SMS code)</span>
          </div>
        </div>
        <div class="account-field-row">
          <div class="account-field">
            <label for="" class="bf__label">Address</label>
            <input type="email" class="bf__input">
          </div>
        </div>
        <div class="account-field-row">
          <div class="account-field">
            <label for="" class="bf__label">Postal Code</label>
            <input type="email" class="bf__input">
          </div>
        </div>
        <div class="account-field-row">
          <div class="account-field">
            <label for="" class="bf__label">City</label>
            <input type="email" class="bf__input">
          </div>
        </div>
        <div class="account-cb-field-row">
          <div class="account-cb-field">
            <input type="checkbox" id="bfcb-1" class="bfcb__input">
            <label for="bfcb-1" class="bfcb__label">Receive e-mails with free offers, special offers, discounts and new products</label>
          </div>
          <div class="account-cb-field">
            <input type="checkbox" id="bfcb-2" class="bfcb__input">
            <label for="bfcb-2" class="bfcb__label">Receive e-mails with MarketingHack blog’s news</label>
          </div>
        </div>
      </div>

      <div class="account-foot">
        <button class="btn-8">Save  Information</button>
      </div>
    </section>
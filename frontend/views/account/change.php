<section class="simple-page sm">
      <h2 class="title-14">My Account</h2>
          <?= $this->render('_menu', [
    ]) ?>      
      <h2 class="title-14">Change Password:</h2>
      <div class="account-info">
        <div class="account-field-row">
          <div class="account-field">
            <label for="" class="bf__label">Old Password</label>
            <input type="password" class="bf__input">
          </div>
        </div>
        <div class="account-field-row">
          <div class="account-field">
            <label for="" class="bf__label">New Password</label>
            <input type="password" class="bf__input">
            <span class="bf__info">(minimum length 7 characters)</span>
          </div>
        </div>
        <div class="account-field-row">
          <div class="account-field account-field--novalidate">
            <label for="" class="bf__label">Confirm New Password</label>
            <input type="password" class="bf__input">
            <span class="bf__info">(password and confirmation match)</span>
          </div>
        </div>
      </div>

      <div class="account-foot">
        <button class="btn-8">Update  Password</button>
      </div>
    </section>
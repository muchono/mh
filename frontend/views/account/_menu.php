<?php
use yii\helpers\Url;
?>
<ul class="account-list">
        <li class="account-list__item <?=($this->context->action->id == 'index' ? 'account-list__item--active' : '')?>">
          <a href="<?=Url::to(['account/index']);?>" class="account-btn">
            <span class="account-btn__icon">
              <img src="img/acc-1<?=($this->context->action->id == 'index' ? '-active' : '')?>-ic.jpg" alt="" class="img-fluid">
            </span>
            <span class="account-btn__text">My Products</span>
          </a>
        </li>
        <li class="account-list__item <?=($this->context->action->id == 'profile' ? 'account-list__item--active' : '')?>">
          <a href="<?=Url::to(['account/profile']);?>" class="account-btn">
            <span class="account-btn__icon">
              <img src="img/acc-2<?=($this->context->action->id == 'profile' ? '-active' : '')?>-ic.jpg" alt="" class="img-fluid">
            </span>
            <span class="account-btn__text">Edit Profile</span>
          </a>
        </li>
        <li class="account-list__item <?=($this->context->action->id == 'orders' ? 'account-list__item--active' : '')?>">
          <a href="<?=Url::to(['account/orders']);?>" class="account-btn">
            <span class="account-btn__icon">
              <img src="img/acc-3<?=($this->context->action->id == 'orders' ? '-active' : '')?>-ic.jpg" alt="" class="img-fluid">
            </span>
            <span class="account-btn__text">Order History</span>
          </a>
        </li>
        <li class="account-list__item <?=($this->context->action->id == 'change' ? 'account-list__item--active' : '')?>">
          <a href="<?=Url::to(['account/change']);?>" class="account-btn">
            <span class="account-btn__icon">
              <img src="img/acc-4<?=($this->context->action->id == 'change' ? '-active' : '')?>-ic.jpg" alt="" class="img-fluid">
            </span>
            <span class="account-btn__text">Change Password</span>
          </a>
        </li>
      </ul>
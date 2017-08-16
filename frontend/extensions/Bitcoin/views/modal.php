<div class="bitcoin_modal_wrap hide">
  <div class="modal_body modal_payment_popup">
    <img src="/img/bitcoin.jpg" class="modal_logo">
    <div class="modal_content">
        <p>Please pay <span class="strong"><span id="bitcoin_modal_price"><?php echo $this->exchange($data['total'])?></span> BTC</span> </p>
        <p>to the following address:</p>
        <div class="modal_content_center">
            <div class="modal_payment_address center"><?php echo $this->getAddress(Yii::app()->user->profile->id);?></div>
            <div class="bitcoin_modal_message">&nbsp;</div>
            <p>After payment please confirm:</p>
            <div class="button">
                <a href="#" class="butt back"  id="bitcoinBack">Back</a>
                <a href="#" class="butt accept" id="bitcoinPaid">Confirm</a>
            </div>
        </div>
    </div>
  </div>
</div>
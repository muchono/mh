<?php
class Webmoney extends CPayment 
{
    protected $_action_url = 'https://merchant.webmoney.ru/lmi/payment.asp';
    /**
     *
    212.118.48.* (212.118.48.0 маска 255.255.255.0 или в unix-нотации 212.118.48.0/24)
    212.158.173.* (212.158.173.0 маска 255.255.255.0 или в unix-нотации 212.158.173.0/24)
    91.200.28.* (91.200.28.0 маска 255.255.255.0 или в unix-нотации 91.200.28.0/24)
    91.227.52.* (91.227.52.0 маска 255.255.255.0 или в unix-нотации 91.227.52.0/24)

     */
    protected $_wm_ip_masks = array(
        
    );
    
   
    public function addLog($string)
    {
        $fh = fopen($this->_logFileName, 'a+');
        fwrite($fh, date('d-m-Y H:i') . ' : ' . $string . "\n");
        fclose($fh);
    }
    
    protected function confirm($params)
    {
        $r = 0;
        $this->addLog('Transaction confirmation request');
        if (!empty($params['LMI_PAYMENT_NO'])){
            $transaction = Transaction::model()->findByPk($params['LMI_PAYMENT_NO']);
            if (!empty($transaction)){
                $this->setID($transaction->id);
                $this->_payment_result = $transaction->success;
                $this->_payment_details = $params;
                if (!empty($params['RND'])
                    && md5($transaction->time) == $params['RND']
                    && $transaction->success) {
                    $r = 1;
                    $this->addLog('Transaction success confirmed, payment_no: ' .$params['LMI_PAYMENT_NO']);
                }else $this->addLog('Transaction confirmation error, payment_no: ' .$params['LMI_PAYMENT_NO']);
            }else $this->addLog('Transaction not found for confirmation, payment_no: ' .$params['LMI_PAYMENT_NO']);
        }
        
        return $r;
    }
    
    public function exitByError($string, $step, $id) 
    {
        $this->addLog($string . ", step: $step, payment_no: ". $id);
        Yii::app()->end();
    }

    
    public function result($params = array())
    {
        $transaction = null;
        $this->addLog('Transaction prerequest triger');
        
        if (isset($params['LMI_PAYMENT_NO'])){
            $transaction = Transaction::model()->findByPk($params['LMI_PAYMENT_NO']);
        }

        if(empty($transaction)) {
            $this->exitByError('Transaction not found', 1, isset($params['LMI_PAYMENT_NO']) ? $params['LMI_PAYMENT_NO'] : 0 );
        }
        
        if(!isset($params['RND']) || md5($transaction->time) != $params['RND']) {
            $this->exitByError('Transaction not valid', 2, $params['LMI_PAYMENT_NO']);
        }       
        
        $this->_payment_details = $params;
        $this->setID($transaction->id);        
        if(isset($params['LMI_PREREQUEST']) && $params['LMI_PREREQUEST'] == 1){ # Prerequest
            $this->saveSate();
            $this->addLog('Transaction prerequest, payment_no: '.$transaction->id);
            echo 'YES';
        }else{
            # Create check string
            $chkstring =  $this->_params['wmz'].number_format($transaction->price, 2, '.', '').$transaction->id.
                          $params['LMI_MODE'].$params['LMI_SYS_INVS_NO'].$params['LMI_SYS_TRANS_NO'].$params['LMI_SYS_TRANS_DATE'].
                          $this->_params['secretKey'].$params['LMI_PAYER_PURSE'].$params['LMI_PAYER_WM'];
            $sha256 = strtoupper(hash('sha256', $chkstring));
            $hash_check = ($params['LMI_HASH'] == $sha256);
            
            if($hash_check){
                $this->_payment_result = 1;
                $this->saveSate();
            } else {
                $this->saveSate();
                $this->exitByError('Transaction check error', 3, $params['LMI_PAYMENT_NO'].' '. $chkstring.' '.$sha256);
            }
        }
        
        Yii::app()->end;
    }
    
    protected function pay($params)
    {
        echo $this->getHTML();
        Yii::app()->end();
    }
    
    public function getHTML()
    {
        return '
        <html>
        <body>
        <form id="wm_pay_form" name="wmpay" method="POST" action="'.$this->_action_url.'">
          <input type="hidden" name="LMI_PAYMENT_AMOUNT" value="'.$this->_transaction->price.'">
          <input type="hidden" name="LMI_PAYMENT_DESC" value="'.$this->_params['description'].'">
          <input type="hidden" name="LMI_PAYMENT_NO" value="'.$this->_transaction->id.'">
          <input type="hidden" name="LMI_PAYEE_PURSE" value="'.$this->_params['wmz'].'">
          <input type="hidden" name="LMI_RESULT_URL" value="'.Yii::app()->createAbsoluteUrl('BuyPublication/PaymentPreResult', array("payment"=>'Webmoney')).'">
          <input type="hidden" name="LMI_SUCCESS_URL" value="'.Yii::app()->createAbsoluteUrl('BuyPublication/PaymentResult', array("payment"=>'Webmoney')).'">
          <input type="hidden" name="LMI_SUCCESS_METHOD" value="POST">
          <input type="hidden" name="LMI_FAIL_URL" value="'.Yii::app()->createAbsoluteUrl('BuyPublication/PaymentResult', array("payment"=>'Webmoney')).'">
          <input type="hidden" name="LMI_FAIL_METHOD" value="POST">
          <input type="hidden" name="LMI_PAYMER_EMAIL" value="'.Yii::app()->user->profile->email.'">
          '.($this->_params['mode'] == 1 ? '<input type="hidden" name="LMI_SIM_MODE" value="0">' : '').
           '
          <input type="hidden" name="RND" value="'.md5($this->_transaction->time).'">
        </form>
        <script type="text/javascript">
        document.getElementById("wm_pay_form").submit();
        </script>
        </body>
        </html>
        ';
    }
 
}
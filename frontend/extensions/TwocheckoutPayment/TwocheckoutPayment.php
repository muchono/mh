<?php
Yii::import('application.extensions.TwocheckoutPayment.Twocheckout');
class TwocheckoutPayment extends CPayment 
{
    protected $_action_url = 'https://merchant.webmoney.ru/lmi/payment.asp';

    protected $_wm_ip_masks = array(
        
    );
    
    public function init()
    {
        //Publishable Key: 6DA0F668-6D0E-46EA-853C-ECD9DA7AAF4F
        // Your sellerId(account number) and privateKey are required to make the Payment API Authorization call.
        //Twocheckout::privateKey('DE75C596-8B00-4CAC-A267-DB9EA7743465');
        //Twocheckout::sellerId('901264854');

        // Your username and password are required to make any Admin API call.
        //Twocheckout::username('netgeron');
        //Twocheckout::password('vErmOlIn1');

        // If you want to turn off SSL verification (Please don't do this in your production environment)
        //Twocheckout::verifySSL(false);  // this is set to true by default

        // To use your sandbox account set sandbox to true
        Twocheckout::sandbox($this->_params['sandbox']);

        // All methods return an Array by default or you can set the format to 'json' to get a JSON response.
        //Twocheckout::format('json');
    }
    
    public function addLog($string)
    {
        $fh = fopen($this->_logFileName, 'a+');
        fwrite($fh, date('d-m-Y H:i') . ' : ' . $string . "\n");
        fclose($fh);
    }
    
    protected function confirm($params)
    {
        $r = 0;
        $this->init();
        $this->addLog('Transaction confirmation request');
        
        if (isset($params['merchant_order_id'])){
            $transaction = Transaction::model()->findByPk($params['merchant_order_id']);
        }

        if(empty($transaction)) {
            $this->logError('Transaction not found', 1, isset($params['merchant_order_id']) ? $params['merchant_order_id'] : 0 );
        } else {
            $this->setID($transaction->id);
            $params['passback'] = Twocheckout_Return::check($params, $this->_params['SecretWord']);
            $this->_payment_details = $params;
            if ($params['passback']['response_code'] == 'Success' && $params['passback']['response_message'] == 'Hash Matched') {
                $r = 1;
            }
        }
        return $r;
    }
    
    public function logError($string, $step, $id) 
    {
        $this->addLog($string . ", step: $step, payment_no: ". $id);
    }
    
    protected function pay($params)
    {
        $this->init();
        
        $data = array(
            'sid' => $this->_params['sid'],
            'mode' => '2CO',            
            'merchant_order_id' => $this->_transaction->id,
            'currency_code' => 'USD',
            'card_holder_name' => Yii::app()->user->profile->billing->full_name,
            'street_address' => Yii::app()->user->profile->billing->address,
            'city' => Yii::app()->user->profile->billing->city,
            'zip' => Yii::app()->user->profile->billing->zip,
            'country' => Yii::app()->user->profile->billing->countryInfo->country_name,
            'email' => Yii::app()->user->profile->email,
            'x_receipt_link_url' => Yii::app()->createAbsoluteUrl('BuyPublication/PaymentResult', array("payment"=>'TwocheckoutPayment')),
        );
        
        $i = 0;
        foreach($this->_items as $item) {
            $data['li_'.$i.'_name'] = $item['name'];
            $data['li_'.$i.'_price'] = $item['price'];
            $i++;
        }
        header('Location: ' . Twocheckout_Charge::link($data));
        Yii::app()->end();
    }
    
    public function getHTML()
    {
        $data = array(
            'sid' => $this->_params['sid'],
            'mode' => '2CO',            
            'merchant_order_id' => $this->_transaction->id,
            'currency_code' => 'USD',
            'card_holder_name' => Yii::app()->user->profile->billing->full_name,
            'street_address' => Yii::app()->user->profile->billing->address,
            'city' => Yii::app()->user->profile->billing->city,
            'zip' => Yii::app()->user->profile->billing->zip,
            'country' => Yii::app()->user->profile->billing->countryInfo->country_name,
            'email' => Yii::app()->user->profile->email,
            'x_receipt_link_url' => Yii::app()->createAbsoluteUrl('BuyPublication/PaymentResult', array("payment"=>'TwocheckoutPayment')),
        );
        
        $i = 0;
        foreach($this->_items as $item) {
            $data['li_'.$i.'_name'] = $item['name'];
            $data['li_'.$i.'_price'] = $item['price'];
            $i++;
        }
        return '
        <html>
        <body>'.Twocheckout_Charge::form($data, 'auto').'
        </body>
        </html>
        ';
    } 
}
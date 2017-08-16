<?php
Yii::setPathOfAlias('PayPal',Yii::getPathOfAlias('application.extensions.PayPal'));
Yii::import('application.extensions.PayPal.ResultPrinter');

use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Api\PaymentExecution;
use PayPal\Common\PPModel;

class PayPal extends CPayment
{
    protected $_apiContext = null;
    
    public function init()
    {
        $this->_apiContext = new PayPal\Rest\ApiContext(
            new PayPal\Auth\OAuthTokenCredential(
                $this->_params['clientId'],
                $this->_params['clientSecret']
            )
        );
        
        $this->_apiContext->setConfig(
            array(
                'mode' => $this->_params['mode'],
                'http.ConnectionTimeOut' => 30,
                'log.LogEnabled' => true,
                'log.FileName' => $this->_logFileName,
                'log.LogLevel' => 'FINE',
                'validation.level' => 'log',
                'cache.enabled' => true,
            )
        );
    }
    
    protected function pay($params)
    {
        header('Location:' . $this->getLink());
        Yii::app()->end();
    }
    
    public function getLink()
    {
        $this->init();
        
        $approvalUrl = '';
        $payer = new Payer(); 
        $payer->setPaymentMethod("paypal");
        $items_list = array();
        $amount_price = 0;
        foreach($this->_items as $i) {
            $item = new Item(); 
            $amount_price += $i['price'];
            $item->setName($i['name'])->setCurrency($this->_params['currency'])->setQuantity(1)->setPrice($i['price']);
            $items_list[] = $item;
        }
        
        if (!empty($items_list)) {
            $itemList = new ItemList();
            $itemList->setItems($items_list);

            $amount = new Amount();
            $amount->setCurrency("USD")->setTotal($amount_price);

            $transaction = new Transaction(); 

            $transaction->setAmount($amount)
                    ->setItemList($itemList)
                    ->setDescription($this->_params['description'])
                    ->setInvoiceNumber($this->getID());

            $redirectUrls = new RedirectUrls(); 
            $redirectUrls->setReturnUrl(Yii::app()->createAbsoluteUrl('BuyPublication/PaymentResult', array("payment"=>'PayPal', "success"=> 1, 'tid' => $this->getID())))
                         ->setCancelUrl(Yii::app()->createAbsoluteUrl('BuyPublication/PaymentResult', array("payment"=>'PayPal', "success"=> 0)));

            $payment = new Payment();
            $payment->setIntent("sale")
                    ->setPayer($payer)
                    ->setRedirectUrls($redirectUrls)
                    ->setTransactions(array($transaction));
            $request = clone $payment;

            $payment->create($this->_apiContext);


            foreach ($payment->getLinks() as $link) { 
                if ($link->getRel() == 'approval_url') { 
                    $approvalUrl = $link->getHref(); 
                    break; 
                } 
            }        
        }
        return $approvalUrl;
    }
    
    public function getHTML()
    {
        return '<a href="'.$this->getLink().'" id="paypal_link">LINK</a>';
    }
    
    protected function confirm($params)
    {
        $this->init();
        $r = false;
        if (!empty($_GET['success']) && $_GET['success']) {
            $payment = Payment::get($params['paymentId'], $this->_apiContext);
            $execution = new PaymentExecution();
            $execution->setPayerId($params['PayerID']);

            $result = $payment->execute($execution, $this->_apiContext);
            $this->setPaymentDetails($result->toArray());
            
            $r = $result->state == 'approved';
            if ($r) {
                $paymentDetails = Payment::get($payment->getId(), $this->_apiContext);
                $this->setID($paymentDetails->transactions[0]->getInvoiceNumber());
            }
        }
        return $r;
        
        /*
        ResultPrinter::printResult("Executed Payment", "Payment", $payment->getId(), $execution, $result);

        try { 
            $payment = Payment::get($payment->getId(), $this->_apiContext); 

        } catch (Exception $ex) { 
            ResultPrinter::printError("Get Payment", "Payment", null, null, $ex); 
            exit(1); 

        } 
        ResultPrinter::printResult("Get Payment", "Payment", $payment->getId(), null, $payment);
         * 
         */
    }
}
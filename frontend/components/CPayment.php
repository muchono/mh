<?php

namespace frontend\components;
use Yii;
use yii\helpers\Url;
use common\models\Transaction;

class CPayment
{
    /**
     * Payment items
     * @var array Items like array('name'=>'anyname', 'price'=>'anyprice')
     */
    protected $_total = 0;
    /*
     * Cart Items 
     * Ex: array(array('name' => 'name', 'price' => 11))
     */
    protected $_items = array();
    protected $_payment_result = 0;
    protected $_id = 0;
    protected $_transaction = null;
    protected $_params;
    protected $_payment_details = null;
    protected $_logFileName = '';
    protected $_currency = 'USD';
    protected $_exchangeRate = 0;
    protected $_symbol = '$';
    /**
     * Payment Class Name
     * @var string 
     */
    protected $_name = '';


    public function __construct()
    {
        $reflect = new \ReflectionClass($this);
        $this->_name = $reflect->getShortName();
        $this->_logFileName = Url::to('@frontend/runtime/logs/'.$this->_name.'.log');
        $this->_exchangeRate = $this->_defineRate();
    }
    
    /**
     * Exchange money
     * @param float $summ
     * @return float
     */
    public function exchange($summ)
    {
        return round($summ/$this->_exchangeRate, 2);
    }
    
    public function getCurrency()
    {
        return $this->_currency;
    }
    
    public function getSymbol()
    {
        return $this->_symbol;
    }
    
    /**
     * Get exchange rate
     * @return mixed
     */
    public function getRate()
    {
        $this->_exchangeRate;
    }
    
    public function includeHTML()
    {
        
    }    
    
    protected function _defineRate()
    {
        return 1;
    }
    


    public function perform($params = array())
    {
        $this->beforePay();
        $this->pay($params);
        $this->afterPay();
    }
    
    public function result($params = array()) {
        
    }
    
    public function finish($params = array())
    {
        $this->beforeConfirm($params);
        $this->_payment_result = $this->confirm($params) ? 1 : 0;
        $this->afterConfirm($params);
        
        return $this->_payment_result;
    }
    
    public function setParams($params)
    {
        $this->_params = $params;
    }
    
    public function setItems($items)
    {
        $this->_total = 0;
        foreach($items as $i) {
            $this->_total += $i['price'];
        }
        $this->_items = $items;
    }
    
    public function setID($params)
    {
        $this->_id = $params;
    }    
    
    public function getID()
    {
        return $this->_id;
    }
    
    public function getHTML()
    {
        return "";
    }
    
    public function setPaymentDetails($param)
    {
        $this->_payment_details = $param;
    }
    
    public function getPaymentDetails($param)
    {
        return $this->_payment_details;
    }
    
    /**
     * Register css, JS or other sources
     */
    public function registerClientScripts()
    {
        
    }
    
    protected function afterPay()
    {
        
    }
    
    protected function beforePay()
    {
        $this->_transaction = new Transaction;
        $this->_transaction->price = $this->_total;
        $this->_transaction->payment = $this->_name;
        $this->_transaction->user_id = Yii::$app->user->id;
        $this->_transaction->insert();
        
        $this->setID($this->_transaction->id);
    }
    
    protected function beforeConfirm($params)
    {
        
    }
    
    protected function afterConfirm($params)
    {
        $this->saveSate();
    }
    
    
    protected function saveSate()
    {
        if ($this->_id) {
            $transaction = Transaction::findOne($this->_id);
            if (!empty($transaction)) {
                $transaction->success = $this->_payment_result;
                if (!empty($this->_payment_details)) $transaction->appendResponse($this->_payment_details);
                $transaction->update();
            }
        }
    }
    
    protected function pay($params) 
    {
        
    }
    
    protected function confirm($params)
    {
        return false;
    }
}
?>
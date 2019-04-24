<?php

namespace frontend\extensions\FastSpring;

use Yii;
use yii\helpers\Url;
use common\models\Transaction;


class FastSpring extends \frontend\components\CPayment
{
    protected $_action_url = 'https://merchant.webmoney.ru/lmi/payment.asp';
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

    }
    
    public function exitByError($string, $step, $id) 
    {
        $this->addLog($string . ", step: $step, payment_no: ". $id);
    }

    
    public function result($params = array())
    {
        $this->addLog(json_encode($params));
    }
    
    protected function pay($params)
    {
        echo $this->getHTML();
        return '';
    }
    
    public function getHTML()
    {

    }
}
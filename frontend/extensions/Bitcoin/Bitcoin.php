<?php
Yii::import('application.extensions.Curl.Curl');

class Bitcoin extends CPayment
{
    const CONFIRMATION_AMOUNT = 3;
    const SECURE_STR = 'ch236DDssf2sedjc';
    protected $_dbTables = array('payment' => 'bitcoin_payment', 'address' => 'bitcoin_address');
    protected $_action_url = 'https://api.blockchain.info/v2/receive?xpub=%s&callback=$s&key=%s';
    protected $_exchangeURL = 'https://blockchain.info/ticker';
    protected $_currency = 'BTC';
    protected $_symbol = '฿';    

    public function addLog($string)
    {
        $fh = fopen($this->_logFileName, 'a+');
        fwrite($fh, date('d-m-Y H:i') . ' : ' . $string . "\n");
        fclose($fh);
    }
    
    protected function confirm($params)
    {
        $user_id = Yii::app()->user->profile->id;
        $payments = $this->getPayments($user_id);
        $cart_info = Cart::getByUser($user_id);
        $to_pay = $this->exchange($cart_info['total']);

        $this->addLog('Transaction confirmation start User: '.$user_id.' (' . $to_pay . "<=" .$payments['total_not_used'] .')');

        $r = $to_pay <= $payments['total_not_used'] ? 1 : 0;
        //mark payments used
        if ($r) {
            $address = $this->getAddress($user_id);
            Yii::app()->db->createCommand('UPDATE '.$this->_dbTables['payment'].' SET used=1 WHERE `user_id`='.$user_id)
                      ->execute();

            $this->addLog('Confirmed User: '.$user_id.' ('.$address.')');
        } else {
            $this->addLog('Transaction fail');
        }

        return $r;
    }
    
    /**
     * Exchange money
     * @param float $summ
     * @return float
     */
    public function exchange($summ)
    {
        return round($summ/$this->_exchangeRate, 4);
    }
    
    public function exitByError($string, $step, $id) 
    {
        $this->addLog($string . ", step: $step, payment_no: ". $id);
        Yii::app()->end();
    }
    
    
    /**
     * Get address for user
     * @param integer $user_id User ID
     * @return string Address
     */
    public function getAddress($user_id)
    {
        $address = Yii::app()->db->createCommand()
                             ->select('address')
                             ->from($this->_dbTables['address'])
                             ->where('user_id=:user_id', array(':user_id' => $user_id))
                             ->queryScalar();
        if (empty($address)) {
            $address = $this->generateAddressFor($user_id);
        }
        return $address;
    }
    
    public function getPaymentByAddress($address)
    {
        return Yii::app()->db->createCommand()
                             ->select('*')
                             ->from($this->_dbTables['payment'])
                             ->where('user_id=:user_id', array(':user_id' => $user_id))
                             ->queryScalar();        
    }
    
    
    /**
     * Generate address for user
     * @param integer $user_id
     * @return string Address
     */
    public function generateAddressFor($user_id)
    {
        $callback_url = Yii::app()->getBaseUrl(true).'/buyPublication/PaymentPreResult?payment=Bitcoin&user_id='.$user_id.'&secure='.$this->getSecure($user_id);
        $url = 'https://api.blockchain.info/v2/receive?xpub='.$this->_params['xpub'].'&callback='.urlencode($callback_url).'&key='.$this->_params['key'];
        
        $this->addLog('Generate address for ' . $user_id . ' ' . $url);
        
        $curl = new Curl();
        $agent= 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.0.3705; .NET CLR 1.1.4322)';
        $res = $curl->setOption(CURLOPT_SSL_VERIFYPEER, false)
                    ->setOption(CURLOPT_FOLLOWLOCATION, false)
                    ->setOption(CURLOPT_USERAGENT, $agent)
                    ->get($url);
        
        $this->addLog('Generate address ressult ' . $res);
        $res_array = json_decode($res, 1);
        $address = '';
        if (!empty($res_array['address'])) {
            $address = $res_array['address'];
            Yii::app()->db->createCommand()
              ->insert($this->_dbTables['address'], array('address'=>$res_array['address'], 'user_id'=>$user_id));
        }

        return $address;
    }
    
    /**
     * Get payments
     * @param integer $user_id User ID
     * @return array 
     */
    public function getPayments($user_id)
    {
        $info = Yii::app()->db->createCommand('SELECT (SELECT FORMAT(SUM(total), 5) FROM '.$this->_dbTables['payment'].' WHERE user_id='.$user_id.') total,
                                       (SELECT FORMAT(SUM(total), 5) FROM '.$this->_dbTables['payment'].' WHERE user_id='.$user_id.' AND used = 0 AND confirmation_amount >= ' . self::CONFIRMATION_AMOUNT . ') total_not_used')
                              ->queryRow(true);
        
        $info['payments'] = Yii::app()->db->createCommand()
                ->select('*')
                ->from($this->_dbTables['payment'])
                ->where('user_id=:user_id', array(':user_id'=>$user_id))
                ->queryAll(true);
        
        return $info;
    }

    public function includeHTML($data = array())
    {
        $path = Yii::getPathOfAlias('application.extensions.Bitcoin.views.modal');
        include_once($path .'.php');
    }
    
    public function perform($params = array())
    {
        header('Location: '.Yii::app()->getBaseUrl(true).'/buyPublication/PaymentResult?payment=Bitcoin');
        Yii::app()->end();
    }
    
    /**
     * Add the payment
     * @param array $param
     */
    public function result($param = array())
    {
        $this->addLog('Bitcoin Daemon:' . json_encode($param));
        if (empty($param['user_id'])) {
            $this->addLog('Empty user');
        } elseif (!empty($param['confirmations']) 
                && $param['confirmations'] >= self::CONFIRMATION_AMOUNT) {
            if ($param['secure'] == $this->getSecure($param['user_id'])) {
                $data = array(
                    'total'            => $param['value'] / 100000000,
                    'address'          => $param['address'],
                    'user_id'          => $param['user_id'],
                    'transaction_hash' => $param['transaction_hash'],
                    'confirmation_amount' => $param['confirmations'],
                    'datetime'         => new CDbExpression('NOW()'),
                );
                Yii::app()->db->createCommand()
                          ->insert($this->_dbTables['payment'], $data);
                Yii::app()->db->createCommand()
                          ->delete($this->_dbTables['address'], 'user_id=:user_id', array(':user_id'=>$param['user_id']));
                
                $this->addLog('Response *ok*');
                echo '*ok*';
            } else {
                $this->addLog('Secure ERROR');
            }
        } else {
            $this->addLog('Confirmations: '. (empty($param['confirmations']) ? 0 : (int) $param['confirmations']));
        }
    }
    
    /**
     * Generate secure string
     * @param string $str Base string 
     * @return string Hash
     */
    public function getSecure($str)
    {
        return sha1($str.self::SECURE_STR);
    }
    
    /**
     * Register css, JS or other sources
     */    
    public function registerClientScripts()
    {
        Yii::app()->clientScript
                  ->registerScriptFile(Yii::app()->baseUrl.'/js/BitcoinPayment.js',
                                       CClientScript::POS_END);
        Yii::app()->clientScript
                  ->registerCssFile(Yii::app()->baseUrl.'/css/bitcoin_modal.css');             
    }  
    
    /**
     * Define exchange rate
     * @return mixed
     */
    protected function _defineRate()
    {
        $cache_key = 'bitcoin_exchange_'.date("dmY");
        $value = Yii::app()->cache->get($cache_key);
        if($value === false)
        {
            $curl = new Curl();

            $agent= 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.0.3705; .NET CLR 1.1.4322)';
            $rates = json_decode($curl->setOption(CURLOPT_SSL_VERIFYPEER, false)
                 ->setOption(CURLOPT_USERAGENT, $agent)
                 ->get($this->_exchangeURL), 1);
            $value = $rates["USD"]['buy'];
            Yii::app()->cache->set($cache_key, $value, 24 * 60/* 24 hours*/);
        }
        

        return $value;
    }
}
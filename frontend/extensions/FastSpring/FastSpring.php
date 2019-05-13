<?php

namespace frontend\extensions\FastSpring;

use Yii;
use yii\helpers\Url;
use common\models\Transaction;
use common\models\User;
use common\models\Cart;
use frontend\controllers\CheckoutController;


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

    protected function afterConfirm($params) {}
    
    protected function beforePay(){}
    
    protected function confirm($params)
    {
        $r = 0;
        if (!empty($params['order'])) {
            $data = $this->getOrder($params['order']);
            if (!empty($data) && $data->completed) {
                $t = Transaction::find()
                        ->where(['remote_id' => $data->id, 'user_id' => Yii::$app->user->id])
                        ->one();

                if (empty($t) && !$t->used) {
                    $user = User::findOne(Yii::$app->user->id);
                    
                    $cartInfo = Cart::getInfo($user->id);
                    
                    if ($cartInfo['total'] <= $data->total) {
                        $this->_transaction = new Transaction;
                        $this->_transaction->price = $data->total;
                        $this->_transaction->payment = $this->_name;
                        $this->_transaction->user_id = $user->id;
                        $this->_transaction->success = $data->completed;
                        $this->_transaction->remote_id = $data->id;
                        $this->_transaction->used = 1;
                        $this->_transaction->insert();                        

                        $this->setID($this->_transaction->id);
                        
                        $r = 1;
                    }
                }
            }
        }

        return $r;
    }
    
    public function exitByError($string, $step, $id) 
    {
        $this->addLog($string . ", step: $step, payment_no: ". $id);
    }

    
    /**
     * Check Webhook Events
     * @param arrray $params
     */
    public function result($params = array())
    {
        /*
        $this->addLog(json_encode($params));
        $getallheaders = getallheaders();
        $this->addLog('HEADERS: '. json_encode($getallheaders));

        $json_str = file_get_contents('php://input');
        
        $hash = $this->getWebhookHash($json_str);
        $this->addLog('CREATED HASH: '. $hash);
        if ($hash == $getallheaders['X-FS-Signature']) {
            $this->addLog('Hash was checked successfully');
            $this->addLog($json_str);
            $data = json_decode($json_str);
            
            $log = '';
            foreach($data->events as $e) {
                $log .= 'Process: ' . $e->data->order ."\n";
                if ($e->type == 'order.completed') {
                    $user = User::findByEmail($e->data->customer->email);
                    $this->addLog('FIND USER E-MAIL: '. $e->data->customer->email);
                    if (!empty($user)) {
                        $this->_transaction = new Transaction;
                        $this->_transaction->price = $e->data->total;
                        $this->_transaction->payment = $this->_name;
                        $this->_transaction->user_id = $user->id;
                        $this->_transaction->success = $e->data->completed;
                        $this->_transaction->remote_id = $e->data->order;
                        $this->_transaction->insert();
                        
                        CheckoutController::performSuccess('FastSpring', $this->_transaction->id, $user);
                        
                        $log .= 'Transaction Created: ' . $this->_transaction->id ."\n";
                        $this->setID($this->_transaction->id);
                    }
                }
            }
            $this->addLog($log);
        }
         * 
         */
    }
    
    public function getOrder($id)
    {
		$ch = curl_init($this->getUrl().'orders/'.$id);
		
		curl_setopt($ch, CURLOPT_USERPWD, $this->_params['API_NAAME'] . ":" . $this->_params['API_PASSWORD']);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
		
		$response = curl_exec($ch);
		$info = curl_getinfo($ch);
        
        return empty($response) ? '' : json_decode($response);
    }
    
    protected function getWebhookHash($data)
    {
        $secret = 'sdflsd34234kgj0JMMFDFDf';
        return base64_encode(hash_hmac('sha256', $data, $secret, true));
    }
    
    protected function pay($params)
    {
        echo $this->getHTML();
        return '';
    }
    

	private function getUrl() 
    {
		$url = "https://api.fastspring.com/";

		return $url;
	}
    
    public function getHTML()
    {
        $json_payload = json_encode([
            "accountCustomKey" => $this->_params['user']->id, 
            "contact" => [
                "email" => $this->_params['user']->email,
                "firstName" => $this->_params['user']->name,
                "lastName" => "Customer"
            ], 
            "items" => [[
                "path" => "marketing-year-subscription",
                "pricing" => [
                    "trial" => 0,
                    "interval" => "year",
                    "intervalLength" => 1,
                    "intervalCount" => 0,
                    "intervalCount" => 0,
                    "quantityBehavior" => "hide",
                    "quantityDefault" => 1,
                    "price" => [
                        "USD" => $this->_total,
                    ]
                ]
            ]]
        ]);


        $aes_key = openssl_random_pseudo_bytes(16);
        $cipher_text = openssl_encrypt($json_payload, 'AES-128-ECB', $aes_key, OPENSSL_RAW_DATA); //, $iv);
        $secure_payload = base64_encode($cipher_text);

        $private_key_content = file_get_contents($this->_params['PRIVATE_KEY_PATH']);

        $private_key = openssl_pkey_get_private($private_key_content);
        openssl_private_encrypt($aes_key, $aes_key_encrypted, $private_key);
        $secure_key = base64_encode($aes_key_encrypted);


        return '
        <html>
        <head>
        <script type="text/javascript">
            var p = "'.$secure_payload.'";
            var k = "'.$secure_key.'";
            var fscSession = {
                  "secure": {
                      "payload": p,
                      "key": k
                   }
              };
            function fastSpringResult(obj) { 
                if (null === obj) {
                    location.replace("'.Url::to(['checkout/fail']).'");
                } else {
                    location.replace("'.Url::to(['checkout/payment-result']).'?payment=FastSpring&order="+obj.id);
                }
            };
        </script>        
        <script id="fsc-api" src="https://d1f8f9xcsvx3ha.cloudfront.net/sbl/0.7.9/fastspring-builder.min.js" '
                .'data-storefront="nmsystems.'.($this->_params['TEST_MODE'] ? 'test.' : '').'onfastspring.com/popup-nmsystems" '
                . 'data-debug="'.($this->_params['DEBUG'] ? 'true' : 'false').'" '
                . 'data-popup-closed="fastSpringResult" '
                . 'data-access-key="'.$this->_params['ACCESS_KEY'].'"></script>
                   
        </head>
        <body>
        <script type="text/javascript">
        fastspring.builder.checkout();
        </script>
        </body>
        </html>
        ';        
    }
}
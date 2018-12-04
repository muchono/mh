<?php

namespace common\models;

use Yii;
use \DrewM\MailChimp\MailChimp;

use common\models\Product;

class MailchimpMirror
{
    const ID = 'mailchimp';
    protected $api = null;
    protected $store_id = '';
    protected $result = null;
    
    public function __construct()
    {
        $this->api = new MailChimp(Yii::$app->params[self::ID]['apikey']);
        $this->store_id = Yii::$app->params[self::ID]['store_id'];
    }
    
    /**
     * Call API method
     * @param string $method Request method name
     * @param string $url Request URL
     * @param array $data Data
     * @return array
     */
    public function call($method, $url, $data = [])
    {
        Yii::info(json_encode([
            'request' => $method . ':' . $url,
            'data' => $data,
        ]), self::ID);
        
        $this->result = $this->api->$method($url, $data);
        
        Yii::info(json_encode([
            'result' => $this->result,
        ]), self::ID);
        
        return $this->result;
    }
    
    public function addProduct(Product $p)
    {
        $result = $this->api->post("/ecommerce/stores/mh_store_1/products", [
                    //"id" => "product_2",
                    "title" => "Product Title 2",
                    "variants" => [
                        [
                         "id" => "product_2",
                         "title" => "Product Title 2",
                        ]
                    ],
        ]);
        
        print_r($result);
    }
    
    public function getErrorName()
    {
        return 'MailChimp Error. ' . $this->result['title'];
    }
    
    public function actionMc()
    {

        //$result = $MailChimp->get('/lists/');
        $result = $this->call('get', '/lists/');
        //$result = $MailChimp->get('/ecommerce/stores');
        
        /*
        $result = $MailChimp->post("/ecommerce/stores", [
                    "id" => "mh_store_1",
                    "list_id" => "0baf1f4673",
                    "name" => "Marketing Hack",
                    "domain" => "marketinghack.net",
                    "email_address" => "info@marketinghack.net",
                    "currency_code" => "USD"
                    ]);

        $result = $MailChimp->post("/ecommerce/stores", [
                    "id" => "mh_store_1",
                    "list_id" => "0baf1f4673",
                    "name" => "Marketing Hack",
                    "domain" => "marketinghack.net",
                    "email_address" => "info@marketinghack.net",
                    "currency_code" => "USD"
                    ]);

        $result = $MailChimp->post("/ecommerce/stores/mh_store_1/products", [
                    "id" => "product_2",
                    "title" => "Product Title 2",
                    "variants" => [
                        ["id" => "product_2",
                         "title" => "Product Title 2",
                        ]
                    ],
                    ]);*/

        print_r($result);
        
        print 'OK';
    }
}
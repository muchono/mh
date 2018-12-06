<?php

namespace common\models;

use Yii;
use \DrewM\MailChimp\MailChimp;

use common\models\Product;
use common\models\User;
use common\models\Subscriber;

class MailchimpMirror
{
    const ID = 'mailchimp';
    protected $api = null;
    protected $store_id = '';
    protected $list_id = '';
    protected $result = null;
    
    public function __construct()
    {
        $this->api = new MailChimp(Yii::$app->params[self::ID]['apikey']);
        $this->store_id = Yii::$app->params[self::ID]['store_id'];
        $this->list_id = Yii::$app->params[self::ID]['list_id'];
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
        
        return $this->api->success();
    }
    
    
    /**
     * Add to list
     * @param Subscriber $d Data
     * @return boolean Result
     */
    public function listsAddMember(Subscriber $d)
    {
        return $this->call('post', "/lists/".$this->list_id."/members", [
                    "email_address" => $d->email,
                    "status" => 'subscribed',
        ]);
    }
    
    /**
     * Get Lists
     * @return list
     */
    public function listsGet()
    {
        $this->call('get', "/lists/");
        return $this->result;
    }
    
    /**
     * Add Product
     * @param Product $d Product Data
     * @return boolean Result
     */
    public function productAdd(Product $d)
    {
        return $this->call('post', "/ecommerce/stores/".$this->store_id."/products", [
                    "id" => $d->id,
                    "title" => $d->title,
                    "description" => $d->full_title,
                    "variants" => [
                        [
                         "id" => $d->id,
                         "title" => $d->title,
                        ]
                    ],
        ]);
    }
    /**
     * Delete Product
     * @param Product $d Product Data
     * @return boolean Result
     */
    public function productDelete(Product $d)
    {
        return $this->call('delete', "/ecommerce/stores/".$this->store_id."/products/".$d->id);
    }
    
    /**
     * Update Product
     * @param Product $d Product Data
     * @return boolean Result
     */
    public function productUpdate(Product $d)
    {
        return $this->call('patch', "/ecommerce/stores/".$this->store_id."/products/".$d->id, [
                    "title" => $d->title,
                    "description" => $d->full_title,
                    "variants" => [
                        [
                         "id" => $d->id,
                         "title" => $d->title,
                        ]
                    ],
        ]);
    }  
    

    
    /**
     * Add user
     * @param User $d Data
     * @return boolean Result
     */
    public function userAdd(User $d)
    {
        return $this->call('post', "/ecommerce/stores/".$this->store_id."/customers", [
                    "id" => $d->id,
                    "email_address" => $d->email,
                    "opt_in_status" => false,
                    "first_name" => $d->name,
        ]);
    }
    /**
     * Delete user
     * @param User $d  Data
     * @return boolean Result
     */
    public function userDelete(User $d)
    {
        return $this->call('delete', "/ecommerce/stores/".$this->store_id."/customers/".$d->id);
    }
    
    /**
     * Update user
     * @param Product $d Product Data
     * @return boolean Result
     */
    public function userUpdate(User $d)
    {
        return $this->call('patch', "/ecommerce/stores/".$this->store_id."/customers/".$d->id, [
                    "first_name" => $d->name,
        ]);
    } 
    
    /**
     * Get Users
     * @return list
     */
    public function usersGet($id = 0)
    {
        $this->call('get', "/ecommerce/stores/".$this->store_id."/customers" . ($id ? '/'. (int) $id : ''));
        return $this->result;
    }
    
    /**
     * Get Last Error Name
     * @return string Error Name
     */
    public function getErrorName()
    {
        return 'MailChimp Error: ' . $this->api->getLastError();
    }
    
    /**
     * Access to MailChimp Direct Inteface
     * @return MailChimp
     */
    public function api()
    {
        return $this->api;
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
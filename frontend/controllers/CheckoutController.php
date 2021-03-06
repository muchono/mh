<?php

namespace frontend\controllers;

use Yii;

use yii\filters\AccessControl;

use common\models\Cart;
use common\models\Product;
use common\models\UserBilling;
use common\models\User;
use common\models\Order;
use common\models\OrderToProduct;
use common\models\Discount;


class CheckoutController extends \frontend\controllers\Controller
{
    const PDF_INVOICE_DIR = '/runtime/invoices/';
    protected $_payments = array(1=>'FastSpring', 3=>'Webmoney');
    protected $_payments_names = array( 1=>'Bank Cards', 3=>'Webmoney');
    protected $default_payment = 'FastSpring';
    /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {
        if (in_array($action->id, ['payment-result', 'payment-pre-result', 'subscription-result'])) {
            $this->enableCsrfValidation = false;
        }

        return parent::beforeAction($action);
    }
    
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['payment-pre-result', 'subscription-result'],
                        'allow' => true,
                        'roles' => ['?'],                        
                    ],                    
                ],
            ],             
        ];
    }
    
    /**
     * Apply Discount
     *
     * @return mixed
     */
    public function actionApplyDiscount()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        
        $r = array('success' => 0);
        $code = trim(Yii::$app->request->post('code'));
        if ($code
                && $discount = Discount::findActive()->andWhere(['apply_code' => $code])->one())
        {
            $r['success'] = 1;
            Cart::saveDiscountID($discount->id);
        }
        
        return $r;
    }
    
    /**
     * Disable Discount
     *
     * @return mixed
     */
    public function actionDisableDiscount()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        
        $r = array('success' => 1);
        
        Cart::saveDiscountID(0);
        
        return $r;
    }
    
    /**
     * Displays fail page.
     * @return mixed
     */

    public function actionFail()
    {
        $this->layout = 'result';
        
        $p = new \frontend\extensions\FastSpring\FastSpring;
        
        return $this->render('fail');
    }    
    
    /**
     * Displays fail page.
     * @return mixed
     */

    public function actionFailt()
    {
        $this->layout = 'result';
        
        return $this->render('fail');
    }      
    
    /**
     * Displays homepage.
     * @return mixed
     */
    public function actionIndex()
    {
        $cartInfo = Cart::getInfo(Yii::$app->user->id, ['discount_id'=> Cart::getDiscountID()]);
        $products = Product::findActive()->andWhere(['not in', 'id', $cartInfo['products_list']])->all();
        $user = User::findOne(Yii::$app->user->id);
        $userBilling = null;
        if ($user->billing) {
            $userBilling = $user->billing;
        } else {
            $userBilling = new UserBilling;
            $userBilling->payment = $this->default_payment;
        }
        
        $userBilling->user_id = Yii::$app->user->id;
        $userBilling->scenario = 'billing';
        
        foreach ($products as $key => $p) {
            if (OrderToProduct::isAccessible($p->id, Yii::$app->user->id)) {
                unset($products[$key]);
            }
        }
        
        if ($userBilling->load(Yii::$app->request->post()) && $userBilling->save()) {
            //if it needs to pay
            if ($cartInfo['total']) {
                //run payment
                $items = array();
                foreach ($cartInfo['products'] as $k=>$p) {
                    $tmp = array('name' => $p->short_title, 'price'=>$p->priceFinal);
                    $items[] = $tmp;
                }


                $params = Yii::$app->params['payments'][$userBilling->payment];
                $params['user'] = $user;
                $n = '\frontend\extensions\\' . $userBilling->payment. '\\' . $userBilling->payment;
                $payment = new $n();
                $payment->setParams($params);
                $payment->setItems($items);
                $payment->setTotal($cartInfo['total']);
                $payment->perform();
                return '';
            } else {
                $order = self::cartToOrder(['payment' => '', 'transaction_id' => 0]);
                
                self::generatePDFInvoice($order);
                return $this->redirect(array('checkout/success', 'o' => $order->id));
            }
        }
        
        return $this->render('index', array(
            'products' => $products,
            'cartInfo' => $cartInfo,
            'userBilling' => $userBilling,
            'payments' => $this->_payments,
            'payments_names' => $this->_payments_names,
        ));
    }
    
    /**
     * Get Cart Items
     *
     * @return mixed
     */
    public function actionGetList()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        
        $r = array('success' => 1);
        $cartInfo = Cart::getInfo(Yii::$app->user->id, ['discount_id'=> Cart::getDiscountID()]);
        $r['items_amount'] = $cartInfo['total'];
        $r['content'] = $this->renderPartial('_items',[
           'cartInfo' => $cartInfo,
        ]);
        return $r;
    }

    
    public function actionPaymentCheck()
    {
        $r = array('result'=>0);
        $payment_name = Yii::$app->request->post('payment');
        if (!empty($payment_name) && in_array($payment_name, array_keys(Yii::$app->params['payments']))) {
            $n = '\frontend\extensions\\' . new $payment_name. '\\' . new $payment_name;
            $payment = new $n();            
            $payment->setParams(Yii::$app->params['payments'][$_POST['payment']]);
            $payments = $payment->getPayments(Yii::$app->user->id);
            $cart_info = Cart::getByUser(Yii::$app->user->id);
            $to_pay = $payment->exchange($cart_info['total']);
            $r['to_pay'] = $to_pay;
            if ($to_pay <= $payments['total_not_used']) {
                $r['result'] = 1;
            } else {
                $r['message'] = "Received sum: ".($payments['total_not_used'] ? $payments['total_not_used'] : 0) . ' BTC<br/>Note: Bitcoin enrollment can take up to 30 minutes.
                <br/>So do not close this window and click on the "Confirm" later.';
            }
        }
        exit(json_encode($r));
    }
    
    public function actionPaymentPreResult()
    {
        $payment_name = Yii::$app->request->get('payment');
        if ($payment_name
                && isset(Yii::$app->params['payments'][$payment_name])) {
            
            $n = '\frontend\extensions\\' . $payment_name. '\\' . $payment_name;
           
            $payment = new $n();            
            $payment->setParams(Yii::$app->params['payments'][$payment_name]);
            $payment->result($_REQUEST);
        }
    }
    
    public function actionSubscriptionResult()
    {
        $payment_name = Yii::$app->request->get('payment');
        if ($payment_name
                && isset(Yii::$app->params['payments'][$payment_name])) {
            
            $n = '\frontend\extensions\\' . $payment_name. '\\' . $payment_name;
           
            $payment = new $n();            
            $payment->setParams(Yii::$app->params['payments'][$payment_name]);
            if ($payment->subscriptionResult($_REQUEST)) {
                $order = self::performSubscription(['payment_method' => $payment_name, 
                    'transaction_id' => $payment->getID(),
                    'subscription_transaction_id' => $payment->getSubscriptionID()
                    ]);

                if ($order) {
                    self::generatePDFInvoice($order);
                    self::orderNotify($order);
                }
            }
        }
    }
    
    public function actionPaymentResult()
    {
        $payed = false;
        $payment_name = Yii::$app->request->get('payment');
        if ($payment_name 
                && isset(Yii::$app->params['payments'][$payment_name])) {
            $n = '\frontend\extensions\\' . $payment_name. '\\' . $payment_name;
        
            $payment = new $n();            
            $payment->setParams(Yii::$app->params['payments'][$payment_name]);
            $payed = $payment->finish($_REQUEST);

            if ($payed) {
                $user = User::findOne(Yii::$app->user->id);
                
                $order = self::cartToOrder(['payment' => Yii::$app->request->get('payment'), 'transaction_id' => $payment->getID()]);
        
                self::generatePDFInvoice($order);
                
                $products_list = [];
                $discount = 0;
                
                foreach($order->products as $p) {
                    $products_list[] = $p->short_title;
                }
                
                foreach ($order->productIDs as $p) {
                    $discount = $p->discount;
                }
                
                $body = Yii::$app->controller->renderPartial('@app/views/mails/thank_you_for_purchase.php', [
                    'products' => $products_list,
                ]);
                
                if (0) {
                    $body = Yii::$app->controller->renderPartial('@app/views/mails/thank_you_for_purchase_discount.php', [
                        'products' => $products_list,
                        'discount' => $discount,
                    ]);                    
                }
                
                Yii::$app->mailer->compose()
                            ->setTo($user->email)
                            ->setFrom(Yii::$app->params['adminEmail'])
                            ->setSubject('Thank you for the purchase')
                            ->setHtmlBody($body)
                            ->send();
                
                self::orderNotify($order);
                
                return $this->redirect(array('checkout/success', 'o' => $order->id));
            }
        }
        
        return $this->redirect(array('checkout/fail'));
    }
    
    /**
     * Displays success page.
     * @return mixed
     */

    public function actionSuccess()
    {
        $this->layout = 'result';
        
        if (Yii::$app->request->get('o')) {
            $order = Order::findOne(Yii::$app->request->get('o'));
            if ($order && $order->user_id == Yii::$app->user->id) {
                $user = User::findOne(Yii::$app->user->id);
                return $this->render('success', ['order_id' => $order->id, 'email' => $user->email, 'order' => $order]);
            }
        }
        return '';
    }
    
    static public function invoicePDFDir()
    {
        return \Yii::getAlias('@frontend'). self::PDF_INVOICE_DIR;
    }
    
    static function generatePDFInvoice(Order $order)
    {
        if (!is_dir(self::invoicePDFDir())) {
            throw new Exception('PDF Invoice direactory not found');
        }
        $user = User::findOne($order->user_id);
        
        $totalDiff = $order->getProductsTotal() - $order->total;
        
        $html = Yii::$app->controller->renderPartial('@frontend/views/checkout/_invoice_pdf', array('order'=>$order, 'user'=> $user, 'totalDiff' => $totalDiff), true);
        
        include(Yii::$app->getBasePath()."/extensions/mpdf60/mpdf.php");
        
        $mpdf=new \mPDF('utf-8','A4','','',20,15,48,25,10,10);
        $mpdf->useOnlyCoreFonts = true;
        $mpdf->SetProtection(array('print'));
        $mpdf->SetTitle("MarketingHack Invoice");
        $mpdf->SetAuthor("MarketingHack");
        $mpdf->SetWatermarkText("Paid");
        $mpdf->showWatermarkText = true;
        $mpdf->watermark_font = 'DejaVuSansCondensed';
        $mpdf->watermarkTextAlpha = 0.1;
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->WriteHTML($html);
        
        $fname = self::invoicePDFDir().$order->id.'.pdf';
        $mpdf->Output($fname,'F');
        
        return $fname;
    } 
    
    static function cartToOrder($params = array())
    {
        $order_params = Cart::getInfo(Yii::$app->user->id, ['discount_id'=> Cart::getDiscountID()]);
        
        $order_params['payment_method'] = empty($params['payment']) ? 'free' : $params['payment'];
        $order_params['payment_status'] = 1;
        $order_params['id'] = Order::genID();
        $order_params['transaction_id'] = empty($params['transaction_id']) ? 0 : $params['transaction_id'];
        
        $order = new Order();
        $order->createByCart($order_params);
        
        return $order;
    }
    
    static function orderNotify(Order $order)
    {
        if ($order->payment_method != 'free') {
            $products = [];
            foreach ($order->products as $p) {
                $products[] = $p->short_title;
            }
            $body = 'New Order Details '.'<br/>'
                    . 'Date:'.date('d-m-y H:i', $order->created_at) .'<br/>'
                    . 'Total:'.$order->total .'<br/>'
                    . 'Payment: ' . $order->payment_method.'<br/>'
                    . 'Products:' . join(', ', $products).'<br/>'
                    . 'User:' .$order->user->name . ' ('.$order->user->email.')'.'<br/>'
                    . 'Thanks';

            Yii::$app->mailer->compose()
                        ->setTo(Yii::$app->params['toAdminEmail'])
                        ->setFrom('transaction@marketinghack.net')
                        ->setSubject('MarketingHack New Order #'.$order->id)
                        ->setHtmlBody($body)
                        ->send();        
        }
    }
    
    static function performSubscription($params = array())
    {
        $order = Order::findOne(['transaction_id' => $params['subscription_transaction_id']]);
        
        return Order::copyFrom($order, $params);
    }
}
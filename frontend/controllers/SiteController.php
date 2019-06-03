<?php
namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\Url;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use frontend\models\GetDemoForm;
use yii\helpers\Html;

use common\models\LoginForm;
use common\models\Product;
use common\models\ProductHref;
use common\models\ProductReview;
use common\models\User;
use common\models\AboutUsContent;
use common\models\Faq;
use common\models\Discount;

/**
 * Site controller
 */
class SiteController extends \frontend\controllers\Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $this->view->params['page'] ='home';
        
        $this->view->params['layout_style'] = 'main-layout';
        
        $getDemoModel = new GetDemoForm();
        if ($getDemoModel->load(Yii::$app->request->post()) && $getDemoModel->validate()) {
                $model = new SignupForm();
                $model->name = $getDemoModel->name;
                $model->email = $getDemoModel->email;
                $model->password = rand(1000, 1000000).'pSap2dd123';
        
            if ($model->signup()) {
                $model->sendEmail(['add_pass' => true]);
                exit('<center>Thank you. <br/><br/>Instructions have been sent to your e-mail box.</center>');
            } else {
                exit('<center>'.join('<br/>', $model->getErrors()).'</center>');
            }
        } else {
            return $this->render('index', array(
                'products' => Product::findActive()->all(),
                'productsCount' => Product::findActive()->count(),
                'hrefsCount' => ProductHref::find()->where(['status' => '1'])->count(),
                'usersCount' => User::find()->where(['active' => '1'])->count(),
                'aboutUsContent' => AboutUsContent::find()->all(),
                'getDemoModel' => $getDemoModel,
            ));
        }
    }
    
    /**
     * Displays FAQ.
     *
     * @return mixed
     */
    public function actionFaq()
    {
        $this->view->params['page'] ='faq';
        
        $getID = Yii::$app->request->get('id');
        if (!empty($getID)
                && ($model = Faq::findOne($getID)))
        {
            return $this->render('faq_answer', array(
                'model' => $model,
                'faqs' => Faq::find()->orderBy('title')->all(),
            ));            
        } else {
            return $this->render('faq', array(
            'faqs' => Faq::find()->orderBy('title')->all(),
            ));
        }

    }
    
    /**
     * Confirm registration
     */
    public function actionRegistration() 
    {
        if (Yii::$app->request->get('code') && Yii::$app->request->get('id')) {
            $user = User::findOne(Yii::$app->request->get('id'));
            
            if ($user->auth_key == Yii::$app->request->get('code')
                    && !$user->registration_confirmed)
            {
                $user->registration_confirmed = $user->active = 1;
                $user->save();

                $login_case = \frontend\models\LoginCase::addCase($user->id, 'special_offer');
                $body = Yii::$app->controller->renderPartial('@app/views/mails/special_offer.php', [
                    'link' => Url::to(['site/apply-special-offer', 'code' => $login_case->auth_key, 'id' => $login_case->id], true),
                    'products' => Product::findActive()->all(),
                    'front_url' => Url::home(true).'/',
                    'user' => $user,
                    'offer' => Discount::findOne(Discount::SPECIAL40ID),
                ]);

                Yii::$app->mailer->compose()
                            ->setTo($user->email)
                            ->setFrom(Yii::$app->params['adminEmail'])
                            ->setSubject('Special 40% off for new users')
                            ->setHtmlBody($body)
                            ->send();                

                $this->layout= 'result';

                return $this->render('success', [
                    'text' => 'Thank you. Your registration completed.',
                    'link' => Url::to(['content/']),
                ]);                
            } 
        }
    }
    
    /**
     * Forgot password
     *
     * @return mixed
     */
    public function actionRestore()
    {   
        if (Yii::$app->request->get('key')) {
            $user = User::findByPasswordResetToken(Yii::$app->request->get('key'));
            if ($user) {
                $password = substr(md5(time()), 0, rand(6, 10));
                
                $user->removePasswordResetToken();
                $user->setPassword($password);
                $user->save();
                
                $body = Yii::$app->controller->renderPartial('@app/views/mails/password_changed.php', [
                    'password' => $password,
                ]);
                //send to user
                Yii::$app->mailer->compose()
                            ->setTo($user->email)
                            ->setFrom(Yii::$app->params['adminEmail'])
                            ->setSubject('New Password - MarketingHack.net')
                            ->setHtmlBody($body)
                            ->send();
                        
                $this->layout= 'result';
                
                return $this->render('success', [
                    'text' => 'Your password has been reset. Check your email for further instructions.',
                ]);
            }
        }
    }
    
    /**
     * Displays Login.
     *
     * @return mixed
     */
    public function actionSignin()
    {
        return $this->redirect(['site/index', 'show_login' => 1]);
    }

    /**
     * Displays Products.
     *
     * @return mixed
     */
    public function actionProducts()
    {
        $this->view->params['page'] ='products';
        
        return $this->render('products', array(
            'products' => Product::findActive()->all(),
        ));
    }
    
    /**
     * Displays Product.
     *
     * @return mixed
     */
    public function actionProduct()
    {

        $this->view->params['page'] ='products';
        $this->view->params['social-panel'] = true;
        if (Yii::$app->request->get('product_id') 
                && $model = Product::findOne(Yii::$app->request->get('product_id'))) {
                    $review = new ProductReview(['scenario' => 'front']);
                    
                    if ($review->load(Yii::$app->request->post()) && $review->save()) {
                        return $this->redirect(['site/product', 'product_id' => $model->id, 'review_added'=>'1', '#' => 'under_post']);
                    }
                    $this->view->title = $model->page->title;
                    \Yii::$app->view->registerMetaTag([
                        'name' => 'description',
                        'content' => $model->page->description
                    ]);                     
                    return $this->render('product_page', array(
                        'model' => $model,
                        'review' => $review,
                        'review_added' => Yii::$app->request->get('review_added'),
                        'products' => Product::findActive()->limit(4)->all(),
                    ));
        } else {
            return $this->redirect(['site/products']);
        }
    } 
    
    /**
     * Displays Special Offers.
     *
     * @return mixed
     */
    public function actionSpecialOffer()
    {
        $this->view->params['page'] ='special-offer';
        return $this->render('special_offer', array(
            'products' => Product::findActive()->all(),
        ));
    }
    
    /**
     * Displays Support.
     *
     * @return mixed
     */
    public function actionSupport()
    {
        $this->view->params['page'] ='support';
        
        if (Yii::$app->request->post() && Yii::$app->request->post('keywords')) {
            $faqs = Faq::find()->where(['LIKE', 'title', Html::encode(Yii::$app->request->post('keywords'))])->all();
            $faqs = array_merge($faqs, Faq::find()->where(['LIKE', 'answer', Html::encode(Yii::$app->request->post('keywords'))])->all());
            return $this->render('support_result', array(
                'faqs' => $faqs,
                'keywords' => Html::encode(Yii::$app->request->post('keywords')),
            ));                    
        } else {
            $model = new \frontend\models\SupportQuestion();
            
            if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                $ticket_id = time() - 1553300000/* any value */;
                //send to admin
                $model->sendEmail(Yii::$app->params['contactEmail'], $ticket_id);
                
                
                //send to user
                $body = Yii::$app->controller->renderPartial('@app/views/mails/inquiry.php', [
                    'ticket_id' => $ticket_id,
                ]);
                //send to user
                Yii::$app->mailer->compose()
                            ->setTo($model->email)
                            ->setFrom(Yii::$app->params['adminEmail'])
                            ->setSubject('Thank you for your inquiry - '.$ticket_id)
                            ->setHtmlBody($body)
                            ->send();
                
                return $this->redirect(['site/success']);
            } else {
                return $this->render('support', array(
                    'faqs' => Faq::find()->orderBy('popular_question DESC')->limit(10)->all(),
                    'model' => $model,
                ));
            }
        }
    }
    
    /**
     * Displays How It Works.
     *
     * @return mixed
     */
    public function actionHiw()
    {
        $this->view->params['page'] ='hiw';

        return $this->render('hiw', array(
            'products' => Product::findActive()->limit(3)->all(),
        ));
    }    
    
    /**
     * Displays Privacy
     *
     * @return mixed
     */
    public function actionPrivacy()
    {
        $this->view->params['page'] ='';
        
        return $this->render('privacy', array(
        ));
    }  
    
    /**
     * Displays Terms
     *
     * @return mixed
     */
    public function actionTerms()
    {
        $this->view->params['page'] ='';
        
        return $this->render('terms', array(
        ));
    }    
    /**
     * Unblock Account
     *
     * @return mixed
     */
    public function actionUnblock()
    {
        if (Yii::$app->request->get('key') && Yii::$app->request->get('u')) {
            $user = User::findOne(Yii::$app->request->get('u'));
            if ($user && $user->blocked 
                    && md5($user->blocked) == Yii::$app->request->get('key')) {
                $user->blocked = 0;
                $user->active = 1;
                $user->active_at = 0;
                $user->save();
            }
        }
        return $this->redirect(['site/index', 'show_login' => 1]);
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['toAdminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }
    
    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionError()
    {
        header("HTTP/1.1 301 Moved Permanently");
        if (substr(Yii::$app->request->absoluteUrl, -1, 1) !== '/') {
            header('Location: '.Yii::$app->request->absoluteUrl.'/');
        } else {
            header('Location: '.Url::home());            
        }
        exit;
    }
    
    
    /**
     * Five days before product expiration notify
     *
     * @return mixed
     */
    public function actionCheckExpiration5()
    {
        $five_days = \common\models\OrderToProduct::getDaysToExpiration(5 /*days*/, 'five_days_notify');
        $fh = fopen(Url::to('@frontend/runtime/logs/expiration5days.log'), 'a+');
        fwrite($fh, date('d-m-Y H:i') . " : Start check \n");
        
        foreach($five_days as $d) {
            print $d->id;
            $product = Product::findOne($d->product_id);
            $user = User::findOne($d->user_id);
            
            if ($product->status && $user->active) {
                $body = Yii::$app->controller->renderPartial('@app/views/mails/subscription_ends_ in_5days.php', [
                    'link' => Url::to(['site/product', 'product_id' => $product->id], true),
                ]);

                Yii::$app->mailer->compose()
                            ->setTo($user->email)
                            ->setFrom(Yii::$app->params['adminEmail'])
                            ->setSubject('Subscription ends in 5 days')
                            ->setHtmlBody($body)
                            ->send();
                
                $d->five_days_notify = 1;
                $d->save();
                
                fwrite($fh, date('d-m-Y H:i') . ' : User ID: ' . $user->id . '; Product ID: ' . $product->id . "\n");
            }
        }
        
        fclose($fh);
    }
    
  /**
     * Product expiration notify
     *
     * @return mixed
     */
    public function actionCheckExpiration()
    {
        $expired = \common\models\OrderToProduct::getDaysToExpiration(0/* means expired*/, 'expiration_notify');
        $fh = fopen(Url::to('@frontend/runtime/logs/subscription_has_expired.log'), 'a+');
        fwrite($fh, date('d-m-Y H:i') . " : Start check \n");
        
        foreach($expired as $d) {
            $product = Product::findOne($d->product_id);
            $user = User::findOne($d->user_id);
            
            if ($product->status && $user->active) {
                $body = Yii::$app->controller->renderPartial('@app/views/mails/subscription_has_expired.php', [
                    'link' => Url::to(['site/product', 'product_id' => $product->id], true),
                ]);

                Yii::$app->mailer->compose()
                            ->setTo($user->email)
                            ->setFrom(Yii::$app->params['adminEmail'])
                            ->setSubject('Subscription has expired')
                            ->setHtmlBody($body)
                            ->send();
                
                $d->expiration_notify = 1;
                $d->save();
                
                fwrite($fh, date('d-m-Y H:i') . ' : User ID: ' . $user->id . '; Product ID: ' . $product->id . "\n");
            }
        }
        
        fclose($fh);
    }    
    
    
    
    /**
     * Displays Special Offers.
     *
     * @return mixed
     */    
    public function actionHideOffer()
    {
        Yii::$app->session->set('head_offer_closed', true);
        exit;
    }

    /**
     * Apply special offer
     *
     * @return mixed
     */
    public function actionApplySpecialOffer()
    {
        if (Yii::$app->request->get('code') && Yii::$app->request->get('id')) {
            $login_case = \frontend\models\LoginCase::findOne(Yii::$app->request->get('id'));
            
            if ($login_case && $login_case->auth_key == Yii::$app->request->get('code')) {
                $user = User::findOne($login_case->user_id);
                if ($user && $user->active && \common\models\Discount::isSpeacialAvailable($user->id)) {
                    Yii::$app->user->login($user, 0);
                    foreach (\common\models\Discount::getProductsNotInCart($user->id) as $pid) {
                        $cart = new \common\models\Cart();
                        $cart->product_id = $pid;
                        $cart->months = 1;
                        $cart->user_id = $user->id;
                        $cart->save();
                    }
                    
                    return $this->redirect(['cart/index']);
                }
                
            }
        }
        return $this->redirect(['site/index']);
    }
    
    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }


    /** 
     * To keep session open
     * 
     */
    public function actionSome()
    {
        exit('200');
    }

    public function actionSuccess()
    {
        $this->layout= 'result';
        return $this->render('success', [
            'text' => 'Thank you for contacting MarketingHack.',
        ]);
    }
    
    /**
     * Requests password reset.
     *
     * @return mixed
     
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }*/

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }*/
}

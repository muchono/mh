<?php
namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
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
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
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
            $subscriber = new \common\models\Subscriber();
            $subscriber->name = $getDemoModel->name;
            $subscriber->email = $getDemoModel->email;
            $subscriber->ip =  ip2long(Yii::$app->request->userIP);
            $subscriber->save(false);
            
            exit('<center>Thank you. <br/><br/>Instructions have been sent to your e-mail box.</center>');
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
                $model->sendEmail(Yii::$app->params['adminEmail']);
                
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
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
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
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }



    public function actionSuccess()
    {
        $this->layout= 'result';
        return $this->render('success', [
        ]);
    }
    
    /**
     * Requests password reset.
     *
     * @return mixed
     */
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
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
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
    }
}

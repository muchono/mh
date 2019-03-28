<?php

namespace backend\controllers;

use Yii;
use common\models\Discount;
use backend\models\DiscountSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\filters\AccessControl;

/**
 * DiscountController implements the CRUD actions for Discount model.
 */
class DiscountController extends Controller
{
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
                ],
            ],             
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Discount models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DiscountSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Discount model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }
    

    /**
     * Creates a new Discount model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Discount();

        if ($model->load(Yii::$app->request->post())) { 
            $model->imageFile1 = UploadedFile::getInstance($model, 'imageFile1'); 
            $model->imageFile2 = UploadedFile::getInstance($model, 'imageFile2');              
            if ($model->save()) {
                $model->saveFiles();
                return $this->redirect(['update', 'id' => $model->id]);
            }
        } 
        
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Discount model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $model->imageFile1 = UploadedFile::getInstance($model, 'imageFile1'); 
            $model->imageFile2 = UploadedFile::getInstance($model, 'imageFile2');            
            if ($model->save()) {
                $model->saveFiles();
                if (Yii::$app->request->post('send')) {
                    $this->sendNotification($model);
                }
                
                return $this->redirect(['update', 'id' => $model->id]);
            }
        } 
        
        
        $model->modifyDatesView();
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Discount model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

  /**
     * Send post notification
     */
    public function sendNotification(Discount $offer)
    {
        //send to registered users
        $usersBilling = \common\models\UserBilling::find()->where(['subscribe_offers' => 1])->all();
        foreach($usersBilling as $ub) {
            $user = \common\models\User::findOne($ub->user_id);
            
            $body = Yii::$app->controller->renderPartial('@app/views/mails/action.php', [
                'offer' => $offer,
                'front_url' => Yii::$app->urlManagerFrontend->getHostInfo().Yii::$app->urlManagerFrontend->getBaseUrl('').'/',
                'user' => $user,
                'subscriber' => 0,                
            ]);
            
            print $body;
            exit;

            Yii::$app->mailer->compose()
                        ->setTo($user->email)
                        ->setFrom(Yii::$app->params['adminEmail'])
                        ->setSubject($offer->title.' from MarketingHack.net')
                        ->setTextBody($body)
                        ->send();            

        }
        
        //send to subscribed users
        $slist = Subscriber::find()
                ->where(['active' => 1])
                ->all();

        foreach($slist as $s) {
            $body = Yii::$app->controller->renderPartial('@app/views/mails/action.php', [
                'offer' => $offer,
                'front_url' => Yii::$app->urlManagerFrontend->getHostInfo().Yii::$app->urlManagerFrontend->getBaseUrl('').'/',
                'user' => $s,
                'subscriber' => 1,
            ]);
    
            Yii::$app->mailer->compose()
                        ->setTo($s->email)
                        ->setFrom(Yii::$app->params['adminEmail'])
                        ->setSubject($offer->title.' from MarketingHack.net')
                        ->setTextBody($body)
                        ->send();
        }
    }
    
    /**
     * Finds the Discount model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Discount the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Discount::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

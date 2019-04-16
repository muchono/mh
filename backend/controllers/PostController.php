<?php

namespace backend\controllers;

use Yii;
use common\models\Post;
use common\models\Subscriber;
use common\models\User;
use backend\models\PostSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\helpers\Url;

/**
 * PostController implements the CRUD actions for Post model.
 */
class PostController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Post models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PostSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Post model.
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
     * Creates a new Post model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Post();


        if ($model->load(Yii::$app->request->post())) {
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile'); 
            $model->imageFileAvatar = UploadedFile::getInstance($model, 'imageFileAvatar'); 
            if ($model->save()) {
                $model->image = 'main_'.$model->id . '.' . $model->imageFile->extension;
                $model->imageFile->saveAs($model->imagesRootDir.$model->image);
                if ($model->imageFileAvatar) {
                    $model->avatar_image = 'avatar_'.$model->id . '.' . $model->imageFileAvatar->extension;
                    $model->imageFileAvatar->saveAs($model->imagesRootDir.$model->avatar_image);                    
                }
                $model->save(false, array('image', 'avatar_image'));
                
                return $this->redirect(['update', 'id' => $model->id]);
            }
        }
        
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Post model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        
        if ($model->load(Yii::$app->request->post())) { 
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile'); 
            $model->imageFileAvatar = UploadedFile::getInstance($model, 'imageFileAvatar');             
            if ($model->save()) {
                if ($model->imageFile) {
                    $model->image = 'main_'.$model->id . '.' . $model->imageFile->extension;
                    $model->imageFile->saveAs($model->imagesRootDir.$model->image);
                    $model->save(false, array('image'));
                }
                if ($model->imageFileAvatar) {
                    $model->avatar_image = 'blog_avatar_image_'.$model->id . '.' . $model->imageFileAvatar->extension;
                    $model->imageFileAvatar->saveAs($model->imagesRootDir.$model->avatar_image);
                    $model->save(false, array('image', 'avatar_image'));
                }             
                
                if (Yii::$app->request->post('send')) {
                    $this->sendNotification($model);
                }
                return $this->redirect(['update', 'id' => $model->id]);
            }
        }
        
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Post model.
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
    public function sendNotification(Post $post)
    {
        //send to registered users
        $usersBilling = \common\models\UserBilling::find()->where(['subscribe_blog' => 1])->all();
        foreach($usersBilling as $ub) {
            $user = \common\models\User::findOne($ub->user_id);
            
            $body = Yii::$app->controller->renderPartial('@app/views/mails/post.php', [
                'post' => $post,
                'front_url' => Yii::$app->urlManagerFrontend->getHostInfo().Yii::$app->urlManagerFrontend->getBaseUrl('').'/',
                'user' => $user,
                'subscriber' => 0,                
            ]);

            Yii::$app->mailer->compose()
                        ->setTo($user->email)
                        ->setFrom(Yii::$app->params['adminEmail'])
                        ->setSubject('MarketingHack New Post')
                        ->setHtmlBody($body)
                        ->send();            

        }
        
        //send to subscribed users
        $slist = Subscriber::find()
                ->where(['active' => 1])
                ->all();

        foreach($slist as $s) {
            $body = Yii::$app->controller->renderPartial('@app/views/mails/post.php', [
                'post' => $post,
                'front_url' => Yii::$app->urlManagerFrontend->getHostInfo().Yii::$app->urlManagerFrontend->getBaseUrl('').'/',
                'user' => $s,
                'subscriber' => 1,
            ]);
    
            Yii::$app->mailer->compose()
                        ->setTo($s->email)
                        ->setFrom(Yii::$app->params['adminEmail'])
                        ->setSubject('MarketingHack New Post')
                        ->setHtmlBody($body)
                        ->send();            
        }
    }
    
    
    /**
     * Finds the Post model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Post the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Post::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

<?php

namespace backend\controllers;

use Yii;
use common\models\Product;
use common\models\ProductReview;
use backend\models\ProductReviewSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * ProductReviewController implements the CRUD actions for ProductReview model.
 */
class ProductReviewController extends Controller
{
    /**
     * Base Product
     * @var Product 
     */
    private $product = null;
    
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
     * Lists all ProductReview models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProductReviewSearch();
        
        $searchModel->setProduct($this->product);
        
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new ProductReview model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ProductReview();
        $model->setProduct($this->product);
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'product_id' => $this->product->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing ProductReview model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        
        $model->setProduct(Product::findOne($model->product_id));
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'product_id' => $model->product_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing ProductReview model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $product_id = $model->product_id;
        $model->delete();

        return $this->redirect(['index', 'product_id' => $product_id]);
    }

    public function beforeAction($action)
    {
        $r = true;
        if (!in_array($action->id, array('update', 'delete', 'sorting'))
                && (empty(Yii::$app->request->queryParams['product_id'])
                || (($this->product = Product::findOne(Yii::$app->request->queryParams['product_id'])) 
                        === null))) {
                        
             $this->redirect(['product/index']);
             $r = false;
        }
        
        return $r ? parent::beforeAction($action) : $r;
    }
    
    /**
     * Finds the ProductReview model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return ProductReview the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ProductReview::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

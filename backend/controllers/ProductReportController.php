<?php

namespace backend\controllers;

use Yii;
use common\models\ProductReport;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use common\models\Product;

/**
 * ProductReportController implements the CRUD actions for ProductReport model.
 */
class ProductReportController extends Controller
{
    /**
     * Base Product
     * @var Product 
     */
    private $product = null;    
    
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
     * Lists all ProductReport models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => ProductReport::find()->where(['product_id' => $this->product->id])->orderBy('title'),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'product' => $this->product,
        ]);
    }

    /**
     * Displays a single ProductReport model.
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
     * Creates a new ProductReport model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ProductReport();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'product_id' => $model->product_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'product' => $this->product,                
            ]);
        }
    }

    /**
     * Updates an existing ProductReport model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'product_id' => $model->product_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'product' => Product::findOne($model->product_id),                
            ]);
        }
    }

    /**
     * Deletes an existing ProductReport model.
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

    /**
     * Finds the ProductReport model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return ProductReport the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ProductReport::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

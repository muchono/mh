<?php

namespace backend\controllers;

use Yii;
use backend\models\Product;
use backend\models\ProductGuide;
use backend\models\ProductGuideSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProductGuideController implements the CRUD actions for ProductGuide model.
 */
class ProductGuideController extends Controller
{
    /**
     * Base Product
     * @var Product 
     */
    private $product = null;
    /**
     * @inheritdoc
     */
    
    
    /**
     * @inheritdoc
     */    
    public function actions()
    {
        return [
            'sorting' => [
                'class' => \kotchuprik\sortable\actions\Sorting::className(),
                'query' => ProductGuide::find(),
            ],
        ];
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
     * Lists all ProductGuide models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProductGuideSearch();
        $searchModel->setProduct($this->product);
        
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ProductGuide model.
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
     * Creates a new ProductGuide model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ProductGuide();
        $model->setProduct($this->product);
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'product_id' => $model->product_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing ProductGuide model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['update', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing ProductGuide model.
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
     * Finds the ProductGuide model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return ProductGuide the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ProductGuide::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

<?php

namespace backend\controllers;

use Yii;
use common\models\Product;
use common\models\ProductHref;
use backend\models\ProductHrefSearch;
use common\models\ProductHrefToCategory;
use yii\filters\AccessControl;
use yii\data\ArrayDataProvider;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProductHrefController implements the CRUD actions for ProductHref model.
 */
class ProductHrefController extends Controller
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
     * @inheritdoc
     */
    public function beforeAction($action)
    {
        $r = true;
        if (!in_array($action->id, array('update', 'delete'))
                && (empty(Yii::$app->request->queryParams['product_id'])
                || (($this->product = Product::findOne(Yii::$app->request->queryParams['product_id'])) 
                        === null))) {
            
             $this->redirect(['product/index']);
             $r = false;
        }
        
        return $r ? parent::beforeAction($action) : $r;
    }
    
    /**
     * Lists all ProductHref models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProductHrefSearch();
        $searchModel->setProduct($this->product);
        
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new ProductHref model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $searchModel = new ProductHrefSearch();
        $searchModel->setProduct($this->product);
        $first = 0;
        
        if (Yii::$app->request->post()) {
            $valid = true;
            $hrefs = [];
            $post = Yii::$app->request->post();
            /**
             * update data
             */
            if (!empty($post['hrefs'])) {
                foreach($post['hrefs'] as $id=>$info) {
                    $model = $this->findModel($id);
                    $model->load(array('ProductHref' => $info));

                    if (!$model->save()) {
                        $valid = false;
                    }
                    $hrefs[$id] = $model;
                }
            }
            
            /**
             * add new data
             */
            if (!empty($post['new'])) {
                $time = time();
                foreach($post['new'] as $info) {
                    $model = new ProductHref;
                    $model->load(array('ProductHref' => $info));
                    $model->status = 1;
                    $model->product_id = $this->product->id;
                    $model->last_update = $time;
                    
                    if ($model->save()) {
                        $hrefs[$model->id] = $model;
                    } else {
                        $valid = false;
                        $hrefs[] = $model;
                    }
                }
            }
            if ($valid) {
                return $this->redirect(['index', 'product_id' => $this->product->id]);
            }
            
            $dataProvider = new ArrayDataProvider([
                'allModels' => $hrefs,
                'pagination' => false,
            ]);            
        } else {
            $first = 1;
            $one = new ProductHref;
            $one->id = 'IIII';

            $dataProvider = new ArrayDataProvider([
                'allModels' => [$one],
                'pagination' => false,
            ]);            
        }
        
        
        return $this->render('create', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'first' => $first,
        ]);
    }

    /**
     * Updates an existing ProductHref model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        
        $model->setProduct(Product::findOne($model->product_id));
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['update', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing ProductHref model.
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
     * Finds the ProductHref model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return ProductHref the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ProductHref::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

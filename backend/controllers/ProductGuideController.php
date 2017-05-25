<?php

namespace backend\controllers;

use Yii;
use common\models\Product;
use common\models\ProductGuide;
use backend\models\ProductGuideSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\helpers\Json;
use yii\filters\AccessControl;

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
        if (!in_array($action->id, array('update', 'delete', 'sorting', 'upload-image', 'get-image'))
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
     * Upload Image
     */
    public function actionUploadImage()
    {
        if (!empty($_FILES)) {
            reset ($_FILES);
            $temp = current($_FILES);
            if (is_uploaded_file($temp['tmp_name'])){
                // Sanitize input
                if (preg_match("/([^\w\s\d\-_~,;:\[\]\(\).])|([\.]{2,})/", $temp['name'])) {
                    header("HTTP/1.0 500 Invalid file name.");
                    return;
                }

                // Verify extension
                if (!in_array(strtolower(pathinfo($temp['name'], PATHINFO_EXTENSION)), array("gif", "jpg", "png"))) {
                    header("HTTP/1.0 500 Invalid extension.");
                    return;
                }
                $fname = microtime(1) . '.' . pathinfo($temp['name'], PATHINFO_EXTENSION);
                move_uploaded_file($temp['tmp_name'], Yii::getAlias('@common/content/images/') . $fname);

                echo Json::encode(array('location' => Url::to(['product-guide/get-image', 'id' => $fname])));
            } else {
              header("HTTP/1.0 500 Server Error");
            }        
        }
    }
    
    
    /**
     * Get Image
     */
    public function actionGetImage()
    {
        $f = Yii::getAlias('@common/content/images/') . Yii::$app->request->get('id');
        if (is_file($f)) {
            echo file_get_contents($f);
        }
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

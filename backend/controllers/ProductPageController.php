<?php

namespace backend\controllers;

use Yii;
use common\models\Product;
use common\models\ProductPage;
use backend\models\ProductPageSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\Json;
use yii\helpers\Url;

/**
 * ProductPageController implements the CRUD actions for ProductPage model.
 */
class ProductPageController extends Controller
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
     * Lists all ProductPage models.
     * @return mixed
     */
    public function actionIndex()
    {
        $model = ProductPage::find()->where(['product_id' => $this->product->id])->one();
        
        if ($model === null) {
            return $this->redirect(['create', 'product_id' => $this->product->id]);
        } else {
            return $this->redirect(['update', 'id' => $model->id]);   
        }
    }

    /**
     * Displays a single ProductPage model.
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
     * Creates a new ProductPage model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ProductPage();
        $model->setProduct($this->product);
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['update', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing ProductPage model.
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
     * Deletes an existing ProductPage model.
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
                $fname = 'product'.microtime(1) . '.' . pathinfo($temp['name'], PATHINFO_EXTENSION);
                move_uploaded_file($temp['tmp_name'], Yii::getAlias('@front_html') . '/images/product/'. $fname);

                echo Json::encode(array('location' => Yii::$app->urlManagerFrontend->getHostInfo().Yii::$app->urlManagerFrontend->getBaseUrl('').'/images/product/' . $fname));
            } else {
              header("HTTP/1.0 500 Server Error");
            }        
        }
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
     * Finds the ProductPage model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return ProductPage the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ProductPage::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

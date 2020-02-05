<?php

namespace backend\controllers;

use Yii;
use common\models\ProductReportItem;
use common\models\UserAffiliate;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * ProductReportItemController implements the CRUD actions for ProductReportItem model.
 */
class ProductReportItemController extends Controller
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
                    //'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all ProductReportItem models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => ProductReportItem::findIndex(),
        ]);
        
        if (!empty(Yii::$app->request->post('selection'))) {
            foreach(Yii::$app->request->post('selection') as $id) {
                $d = ProductReportItem::findOne($id);
                if (!empty($d)) {
                    ProductReportItem::deleteAll(['product_href_id' => $d->product_href_id, 'product_report_id' => $d->product_report_id]);
                }
            }
        }
        
        $affiliates = UserAffiliate::findAffiliates();
        $aff_count = 0;
        foreach ($affiliates as $a) {
            if ($a['comission'] >= UserAffiliate::MIN_TO_PAY) {
                $aff_count++;
            }
        }
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'affiliates' => $affiliates,
            'aff_count' => $aff_count,
        ]);
    }

    /**
     * Deletes an existing ProductReportItem model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete()
    {
        print_r($_POST);
        exit;

        return $this->redirect(['index']);
    }

    /**
     * Finds the ProductReportItem model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return ProductReportItem the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ProductReportItem::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

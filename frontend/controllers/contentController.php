<?php

namespace frontend\controllers;

use Yii;
use common\models\Product;
use common\models\ProductHref;
use common\models\ProductGuide;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;

class ContentController extends \frontend\controllers\Controller
{
    public $layout = 'content';
    
    public function beforeAction($action)
    {
        
        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        $user_id = 1;
        $this->view->params['products'] = Product::findActive()->all();      
        $this->view->params['selectd_product'] = $this->view->params['products'][0];
        $this->view->params['selected_product_hrefs'] = $this->renderHrefs($this->view->params['selectd_product']);
        $this->view->params['selected_product_guide'] = $this->renderGuide($this->view->params['selectd_product']);
        
        return $this->render('index');
    }
    
    public function actionGuide()
    {
        $r = array();

        $product_id = Yii::$app->request->post('project_id');
        //add Security
        if ($product_id && $product = Product::findOne($product_id)) {
            $r = array(
                'c' => $this->renderGuide($product),
            );
        }
            
        echo json_encode($r);
        exit;
    }
    
    public function actionList()
    {
        $r = array();

        $product_id = Yii::$app->request->post('project_id');
        //add Security
        if ($product_id && $product = Product::findOne($product_id)) {
            $r = array(
                'c' => $this->renderHrefs($product),
            );
        }
            
        echo json_encode($r);
        exit;
    }
    
    public function renderHrefs($product)
    {
        $dataProvider = new ActiveDataProvider([
            'query' => $product->getHrefs(),
            'pagination' => array('pageSize' => 3),
        ]);    
        $pages = new Pagination(['totalCount' => $dataProvider->getTotalCount()]);

        return $this->renderPartial('_list',['product' => $product,
            'hrefsProvider' => $dataProvider,
            'pages' => $pages]);
    }
    
    public function renderGuide($product)
    {
        return $this->renderPartial('_guide',['product' => $product]);
    }    

}

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
    public $reportValues = [
        'not_provide' => "Doesn't provide guest posting",
        'requires_payment' => "Requires payment for guest posting",
        'ceased_to_exist' => "Site ceased to exist",
    ];
    
    public function beforeAction($action)
    {
        
        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        $user_id = 1;
        $this->view->params['products'] = Product::findActive()->all();
        
        $product_id = Yii::$app->request->get('product_id');
        if ($product_id && $product = Product::findOne($product_id)) {
            $this->view->params['selected_product'] = $product;
        } else {
            $this->view->params['selected_product'] = $this->view->params['products'][0];    
        }
        
        $this->view->params['selected_product_hrefs'] = $this->renderHrefs($this->view->params['selected_product']);
        $this->view->params['selected_product_guide'] = $this->renderGuide($this->view->params['selected_product']);
        
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
                'c' => $this->renderHrefs($product, Yii::$app->request->post('sort')),
            );
        }
            
        echo json_encode($r);
        exit;
    }
    
    public function actionMarkLink()
    {
        $r = array('success' => 1);
        
        echo json_encode($r);
        exit;
    }   
    
    public function actionSendReport()
    {
        $r = array('success' => 1);
        
        echo json_encode($r);
        exit;
    }
    
    public function renderHrefs($product, $sort = array())
    {
        $params = [
            'query' => $product->getHrefs(),
            'pagination' => array('pageSize' => 50),
        ];

        if (!empty($sort['list_sort'])) {
            list($field, $order) = explode(':', $sort['list_sort']);
            if (in_array($field, ['url','da_rank','alexa_rank','type_links'])
                    && in_array($order, ['up','down'])) {
                
                $params['sort'] = ['defaultOrder' => [$field => $order == 'up' ? SORT_ASC : SORT_DESC]];
            }
        }
        $dataProvider = new ActiveDataProvider($params);    
        $pages = new Pagination(['totalCount' => $dataProvider->getTotalCount()]);

        return $this->renderPartial('_list',['product' => $product,
            'hrefsProvider' => $dataProvider,
            'last_update' => ProductHref::getLastUpdate($product->id),
            'report_list' => $this->reportValues,
            'pages' => $pages]);
    }
    
    public function renderGuide($product)
    {
        return $this->renderPartial('_guide',['product' => $product]);
    }    

}

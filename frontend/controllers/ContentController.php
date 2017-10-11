<?php

namespace frontend\controllers;

use Yii;
use common\models\Product;
use common\models\ProductHref;
use common\models\ProductGuide;
use common\models\OrderToProduct;
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
        $page_size = 50;
        
        if (!empty($sort['page_size']) && in_array($page_size, array(1,25,50,100))) {
            $page_size = $sort['page_size'];
        }
        $where = [];
        if ($sort['urls_filter'] && $sort['urls_filter'] == 'latest_urls'){
            $where['last_update'] = ProductHref::getLastAdd($product->id);
        }
        
        $params = [
            'query' => $product->getHrefs()->select(['*', 
                '(SELECT phc.title '
                . 'FROM product_href_to_category phtoc '
                . 'LEFT JOIN product_href_category phc ON phc.id = phtoc.category_id '
                . 'WHERE phtoc.product_id = product_href.id '
                . 'ORDER BY phc.title '
                . 'LIMIT 1 ) categoryFirst '])->where($where),
            'pagination' => array('pageSize' => $page_size),
        ];
        /*
        $params = [
            'query' => $product->getHrefs()->where($where),
            'pagination' => array('pageSize' => $page_size),
        ];
         * 
         */

        $params['sort'] = ['defaultOrder' => ['da_rank' =>  SORT_DESC]];
        $sort_attributes = ['url','da_rank','alexa_rank','type_links', 'categoryFirst'];
        if (!empty($sort['list_sort'])) {
            list($field, $order) = explode(':', $sort['list_sort']);
            if (in_array($field, $sort_attributes)
                    && in_array($order, ['up','down'])) {
                
                $params['sort'] = ['defaultOrder' => [$field => $order == 'up' ? SORT_ASC : SORT_DESC]];
            }
        }
        
        $params['sort']['attributes'] = $sort_attributes;        
        $dataProvider = new ActiveDataProvider($params);    
        $pages = new Pagination(['totalCount' => $dataProvider->getTotalCount()]);
        
        $accessable = OrderToProduct::isAccessible($product->id, Yii::$app->user->id);
        
        return $this->renderPartial('_list',['product' => $product,
            'hrefsProvider' => $dataProvider,
            'last_update' => ProductHref::getLastUpdate($product->id),
            'report_list' => $this->reportValues,
            'pages' => $pages,
            'sort' => $sort,
            'accessable' => $accessable,
            ]);
    }
    
    public function renderGuide($product)
    {
        return $this->renderPartial('_guide',['product' => $product,
            'accessable' => OrderToProduct::isAccessible($product->id, Yii::$app->user->id)
            ]);
    }    

}

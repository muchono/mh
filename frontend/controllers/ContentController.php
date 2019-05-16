<?php

namespace frontend\controllers;

use Yii;
use common\models\Product;
use common\models\ProductHref;
use common\models\ProductGuide;
use common\models\OrderToProduct;
use common\models\User;
use frontend\models\UserMark;

use yii\data\ActiveDataProvider;
use yii\data\Pagination;

use yii\filters\AccessControl;

class ContentController extends \frontend\controllers\Controller
{
    public $layout = 'content';
    
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['mark-link', 'send-report'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],                     
                ],
            ],             
        ];
    }
    
    public function beforeAction($action)
    {
        
        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        $this->view->params['products'] = Product::findActive()->all();
        
        $product_id = Yii::$app->request->get('product_id');
        $this->view->params['selected_product_accessible'] = 0;
        
        if ($product_id && $product = Product::findOne($product_id)) {
            $this->view->params['selected_product'] = $product;
        } else {
            $this->view->params['selected_product'] = $this->view->params['products'][0];    
        }
        
        if ($this->view->params['selected_product']) {
            $this->view->params['selected_product_accessible'] = Yii::$app->user->id && OrderToProduct::isAccessible($this->view->params['selected_product']->id, Yii::$app->user->id);
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
        $r = array('success' => 0);
        if (Yii::$app->request->post('link')) {
            $mark = new UserMark;
            $mark->user_id = Yii::$app->user->id;
            $mark->href_id = (int) Yii::$app->request->post('link');
            $mark->save();
            
            $r['success'] = 1;
        }
        echo json_encode($r);
        exit;
    }   
    
    public function actionSendReport()
    {
        $r = array('success' => 1);
        if (Yii::$app->request->get('for') && Yii::$app->request->post('report')) {
            $href = ProductHref::findOne((int) Yii::$app->request->get('for'));
            if ($href 
                    && OrderToProduct::isAccessible($href->product_id, Yii::$app->user->id)) {
                
                $product = Product::findOne($href->product_id);
                $user = User::findOne(Yii::$app->user->id);
                $items = [];
                foreach (Yii::$app->request->post('report') as $ri) {
                    $items[] = \common\models\ProductReport::findOne($ri)->title;
                }
                
                //send to user
                $body = Yii::$app->controller->renderPartial('@app/views/mails/report.php', [
                    'user' => $user,
                    'product' => $product,
                    'items' => $items,
                    'href' => $href,
                ]);
                
                Yii::$app->mailer->compose()
                            ->setTo(Yii::$app->params['contactEmail'])
                            ->setFrom(Yii::$app->params['adminEmail'])
                            ->setSubject('MarketingHack URL Report')
                            ->setHtmlBody($body)
                            ->send();
                $r['success'] = 1;                
            }
            
        }
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
        
        $marked = UserMark::find(['user_id' => Yii::$app->user->id])->indexBy('href_id')->asArray()->all();
        
        return $this->renderPartial('_list',['product' => $product,
            'hrefsProvider' => $dataProvider,
            'last_update' => ProductHref::getLastUpdate($product->id),
            'report_list' => $product->getReports()->orderBy('title')->all(),
            'pages' => $pages,
            'sort' => $sort,
            'accessable' => $accessable,
            'marked' => $marked,
            'product' => $product,
            ]);
    }
    
    public function renderGuide($product)
    {
        return $this->renderPartial('_guide',['product' => $product,
            'accessable' => OrderToProduct::isAccessible($product->id, Yii::$app->user->id)
            ]);
    }    

}

<?php
namespace app\components;

use yii\web\UrlRuleInterface;
use yii\base\Object;
use common\models\ProductPage;

class ProductUrlRule extends Object implements UrlRuleInterface
{
    public function createUrl($manager, $route, $params)
    {
        if ($route === 'site/product') {
            if (isset($params['link'])) {
                return $params['link'];
            }
        }
        return false;
    }

    public function parseRequest($manager, $request)
    {
        $pathInfo = $request->getPathInfo();
        if (preg_match('/^([\w-]+)?$/', $pathInfo, $matches)) {
            $page = ProductPage::findOne(['link' => $matches[0]]);
            if ($page) {
                return ['site/product', ['product_id' => $page->product_id]];
            }
        }
        return false;
    }
}
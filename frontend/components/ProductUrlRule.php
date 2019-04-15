<?php
namespace app\components;

use yii\web\UrlRuleInterface;
use yii\base\BaseObject;

class ProductUrlRule extends BaseObject implements UrlRuleInterface
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
        if (preg_match('%^(\w+)(/(\w+))?$%', $pathInfo, $matches)) {
            print_r($matches);
            exit;
        }
        return false;
    }
}
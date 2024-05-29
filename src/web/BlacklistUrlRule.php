<?php declare(strict_types=1);

namespace hipanel\modules\client\web;

use yii\base\BaseObject;
use yii\web\UrlRuleInterface;

class BlacklistUrlRule extends BaseObject implements UrlRuleInterface
{
    public function createUrl($manager, $route, $params)
    {
        if (preg_match('#^client/blacklisted/[\w-]+$#', $route)) {
            if (isset($params['category'])) {
                $controller = $params['category'];
                unset($params['category']);
            } else {
                $controller = \Yii::$app->request->get('category');
            }
            $url = "client/$controller/" . $this->resolveActionFromRoute($route);
            if (!empty($params)) {
                $url .= '?' . http_build_query($params);
            }
            return $url;
        }
        return false;
    }

    private function resolveActionFromRoute($route): string
    {
        $parts = explode('/', $route);
        return end($parts);
    }

    public function parseRequest($manager, $request)
    {
        $pathInfo = $request->getPathInfo();
        if (preg_match('%^client/(blacklist|whitelist)/([\w-]+)$%', $pathInfo, $matches)) {
            $controller = $matches[1];
            $action = $matches[2];
            return ['client/blacklisted/' . $action, ['category' => $controller]];
        }
        return false;
    }
}

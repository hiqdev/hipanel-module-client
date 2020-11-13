<?php
/**
 * Client module for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-client
 * @package   hipanel-module-client
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2019, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\client\menus;

use hipanel\helpers\Url;
use hipanel\modules\client\ClientWithCounters;
use hiqdev\yii2\menus\Menu;
use Yii;

class DashboardItem extends Menu
{
    protected ClientWithCounters $clientWithCounters;

    public function __construct(ClientWithCounters $clientWithCounters, $config = [])
    {
        $this->clientWithCounters = $clientWithCounters;
        parent::__construct($config);
    }

    public function items()
    {
        return Yii::$app->user->can('client.read') ? [
            'client' => [
                'label' => $this->render('dashboardItem', array_merge($this->clientWithCounters->getWidgetData('client'), [
                    'route' => Url::toRoute('@client/index'),
                ])),
                'encode' => false,
            ],
        ] : [];
    }
}

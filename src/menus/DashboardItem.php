<?php
/**
 * Client module for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-client
 * @package   hipanel-module-client
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2018, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\client\menus;

use hipanel\modules\dashboard\DashboardInterface;
use Yii;

class DashboardItem extends \hiqdev\yii2\menus\Menu
{
    protected $dashboard;

    public function __construct(DashboardInterface $dashboard, $config = [])
    {
        $this->dashboard = $dashboard;
        parent::__construct($config);
    }

    public function items()
    {
        return [
            'clients' => [
                'label' => $this->render('dashboardItem', $this->dashboard->mget(['model'])),
                'encode' => false,
                'visible' => Yii::$app->user->can('client.list'),
            ],
        ];
    }
}

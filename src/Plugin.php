<?php
/**
 * @link    http://hiqdev.com/hipanel-module-client
 * @license http://hiqdev.com/hipanel-module-client/license
 * @copyright Copyright (c) 2015 HiQDev
 */

namespace hipanel\modules\client;

class Plugin extends \hiqdev\pluginmanager\Plugin
{
    protected $_items = [
        'menus' => [
            [
                'class' => 'hipanel\modules\client\SidebarMenu',
            ],
        ],
        'modules' => [
            'client' => [
                'class' => 'hipanel\modules\client\Module',
            ],
        ],
    ];

}

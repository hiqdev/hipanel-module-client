<?php

/*
 * Client module for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-client
 * @package   hipanel-module-client
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2016, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\client;

class Plugin extends \hiqdev\pluginmanager\Plugin
{
    protected $_items = [
        'aliases' => [
            '@client'  => '/client/client',
            '@contact' => '/client/contact',
        ],
        'menus' => [
            'hipanel\modules\client\SidebarMenu',
        ],
        'modules' => [
            'client' => [
                'class' => 'hipanel\modules\client\Module',
            ],
        ],
        'components' => [
            'i18n' => [
                'translations' => [
                    'hipanel/client' => [
                        'class' => 'yii\i18n\PhpMessageSource',
                        'basePath' => '@hipanel/modules/client/messages',
                        'fileMap' => [
                            'hipanel/client' => 'client.php',
                        ],
                    ],
                ],
            ],
        ],
    ];
}

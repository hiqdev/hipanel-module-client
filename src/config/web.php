<?php
/**
 * Client module for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-client
 * @package   hipanel-module-client
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2017, HiQDev (http://hiqdev.com/)
 */

return [
    'aliases' => [
        '@client' => '/client/client',
        '@contact' => '/client/contact',
        '@article' => '/client/article',
    ],
    'modules' => [
        'client' => [
            'class' => \hipanel\modules\client\Module::class,
        ],
    ],
    'bootstrap' => [
        \hipanel\modules\client\bootstrap\ContactAttributesVerificationBootstrap::class,
        \hipanel\modules\client\bootstrap\ForceGdprVerificationBootstrap::class,
    ],
    'components' => [
        'i18n' => [
            'translations' => [
                'hipanel:client' => [
                    'class' => \yii\i18n\PhpMessageSource::class,
                    'basePath' => '@hipanel/modules/client/messages',
                ],
            ],
        ],
    ],
    'container' => [
        'definitions' => [
            \hipanel\modules\dashboard\menus\DashboardMenu::class => [
                'add' => [
                    'client' => [
                        'menu' => [
                            'class' => \hipanel\modules\client\menus\DashboardItem::class,
                        ],
                        'where' => [
                            'after' => ['dashboard'],
                        ],
                    ],
                ],
            ],
            \hiqdev\thememanager\menus\AbstractSidebarMenu::class => [
                'add' => [
                    'client' => [
                        'menu' => [
                            'class' => \hipanel\modules\client\menus\SidebarMenu::class,
                        ],
                        'where' => [
                            'after' => ['dashboard'],
                        ],
                    ],
                ],
            ],
        ],
    ],
];

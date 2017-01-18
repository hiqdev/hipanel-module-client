<?php

/*
 * Client module for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-client
 * @package   hipanel-module-client
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2016, HiQDev (http://hiqdev.com/)
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

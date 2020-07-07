<?php
/**
 * Client module for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-client
 * @package   hipanel-module-client
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2019, HiQDev (http://hiqdev.com/)
 */

return [
    'aliases' => [
        '@client' => '/client/client',
        '@contact' => '/client/contact',
        '@article' => '/client/article',
        '@client/assignments' => '/client/assignments',
    ],
    'modules' => [
        'client' => [
            'class' => \hipanel\modules\client\Module::class,
        ],
        'language' => [
            'on ' . \hiqdev\yii2\language\events\LanguageWasChanged::EVENT_NAME =>
                function (\hiqdev\yii2\language\events\LanguageWasChanged $event) {
                    $handler = Yii::$container->get(\hipanel\modules\client\event\handler\PersistUiLanguageChange::class);
                    $handler->handle($event);
                }
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
                    'basePath' => dirname(__DIR__) . '/src/messages',
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
        'singletons' => [
            \hipanel\modules\client\helpers\HasPINCode::class => \hipanel\modules\client\helpers\HasPINCode::class,
        ],
    ],
];

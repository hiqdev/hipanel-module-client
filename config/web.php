<?php
/**
 * Client module for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-client
 * @package   hipanel-module-client
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2019, HiQDev (http://hiqdev.com/)
 */

use hipanel\modules\client\grid\ClientGridView;
use hipanel\modules\client\models\Client;
use hipanel\modules\client\models\ClientSearch;
use hipanel\modules\finance\models\ClientResource;

return [
    'aliases' => [
        '@client' => '/client/client',
        '@contact' => '/client/contact',
        '@article' => '/client/article',
        '@client/assignments' => '/client/assignments',
        '@client/debt' => '/debt/debt',
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
            'client-referral-resource-configuration' => fn(\yii\di\Container $container) => \hipanel\modules\finance\helpers\ResourceConfigurator::build()
                ->setToObjectUrl('@client/resource-detail')
                ->setModelClassName(Client::class)
                ->setSearchModelClassName(ClientSearch::class)
                ->setGridClassName(ClientGridView::class)
                ->setResourceModelClassName(ClientResource::class)
                ->setSearchView('@vendor/hiqdev/hipanel-module-client/src/views/client/_search')
                ->setColumns(['referral']),
        ],
    ],
];

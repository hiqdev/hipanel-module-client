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

use Yii;

class SidebarMenu extends \hiqdev\yii2\menus\Menu
{
    public function items()
    {
        $user = Yii::$app->user;

        return [
            'clients' => [
                'label'   => Yii::t('hipanel', 'Clients'),
                'url'     => ['/client/client/index'],
                'icon'    => 'fa-group',
                'visible' => function () use ($user) {
                    return $user->can('client.list');
                },
                'items'   => [
                    'clients' => [
                        'label' => Yii::t('hipanel', 'Clients'),
                        'url'   => ['/client/client/index'],
                        'visible' => $user->can('client.list'),
                    ],
//                  'mailing' => [
//                      'label' => Yii::t('hipanel', 'Mailing'),
//                      'url'   => ['/client/mailing/index'],
//                  ],
//                  'articles' => [
//                      'label' => Yii::t('hipanel', 'News and articles'),
//                      'url'   => ['/client/article/index'],
//                  ],
                    'contacts' => [
                        'label' => Yii::t('hipanel', 'Contacts'),
                        'url'   => ['/client/contact/index'],
                        'visible' => $user->can('contact.read'),
                    ],
                    'assignments' => [
                        'label'   => Yii::t('hipanel:client', 'Assignments'),
                        'url'     => ['@client/assignments/index'],
                        'visible' => $user->can('plan.create'),
                    ],
                    'blacklist' => [
                        'label'   => Yii::t('hipanel:client', 'Blacklist'),
                        'url'     => ['/client/blacklist/index'],
                    ],
                ],
            ],
        ];
    }
}

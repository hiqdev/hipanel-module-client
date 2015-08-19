<?php

/*
 * Client Plugin for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-client
 * @package   hipanel-module-client
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2014-2015, HiQDev (https://hiqdev.com/)
 */

namespace hipanel\modules\client;

use Yii;

class SidebarMenu extends \hiqdev\menumanager\Menu
{
    protected $_addTo = 'sidebar';

    protected $_where = [
        'after'  => ['dashboard', 'header'],
        'before' => ['finance', 'tickets', 'domains', 'servers', 'hosting'],
    ];

    protected $_items = [
        'clients' => [
            'label'   => 'Clients',
            'url'     => ['/client/client/index'],
            'icon'    => 'fa-group',
        //  'visible' => function () { return Yii::$app->user->can('support'); },
            'items'   => [
                'clients' => [
                    'label' => 'Clients list',
                    'url'   => ['/client/client/index'],
                    'icon'  => 'fa-circle-o',
                ],
                'mailing' => [
                    'label' => 'Mailing',
                    'url'   => ['/client/mailing/index'],
                    'icon'  => 'fa-circle-o',
                ],
                'articles' => [
                    'label' => 'News and articles',
                    'url'   => ['/client/article/index'],
                    'icon'  => 'fa-circle-o',
                ],
                'contacts' => [
                    'label' => 'Contact list',
                    'url'   => ['/client/contact/index'],
                    'icon'  => 'fa-circle-o',
                ],
            ],
        ],
    ];

    public function init()
    {
        parent::init();
        /// XXX quick fix to be redone with 'visible'
        if (!Yii::$app->user->can('support')) {
            unset($this->_items['clients']);
        }
    }
}

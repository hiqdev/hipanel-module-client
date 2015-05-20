<?php
/**
 * @link    http://hiqdev.com/hipanel-module-client
 * @license http://hiqdev.com/hipanel-module-client/license
 * @copyright Copyright (c) 2015 HiQDev
 */

namespace hipanel\modules\client;

class SidebarMenu extends \hipanel\base\Menu
{

    protected $_addTo = 'sidebar';

    protected $_where = [
        'after'     => ['dashboard', 'header'],
        'before'    => ['finance', 'tickets', 'domains', 'servers', 'hosting'],
    ];

    protected $_items = [
        'clients' => [
            'label' => 'Clients',
            'url'   => ['/client/client/index'],
            'icon'  => 'fa-group',
            'items' => [
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

}

<?php
/**
 * Client module for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-client
 * @package   hipanel-module-client
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2017, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\client\menus;

use Yii;

class ContactActionsMenu extends \hiqdev\yii2\menus\Menu
{
    public $model;

    public function items()
    {
        return [
            'view' => [
                'label' => Yii::t('hipanel', 'View'),
                'icon' => 'fa-info',
                'url' => ['@contact/view', 'id' => $this->model->id],
                'encode' => false,
            ],
            'edit' => [
                'label' => Yii::t('hipanel', 'Edit'),
                'icon' => 'fa-pencil',
                'url' => ['@contact/update', 'id' => $this->model->id],
                'encode' => false,
            ],
            'copy' => [
                'label' => Yii::t('hipanel', 'Copy'),
                'icon' => 'fa-copy',
                'url' => ['@contact/copy', 'id' => $this->model->id],
                'encode' => false,
            ],
            'delete' => [
                'label' => Yii::t('hipanel', 'Delete'),
                'icon' => 'fa-trash',
                'url' => ['@client/delete', 'id' => $this->model->id],
                'linkOptions' => [
                    'data' => [
                        'confirm' => Yii::t('hipanel', 'Are you sure you want to delete this item?'),
                        'method' => 'POST',
                        'pjax' => '0',
                    ],
                ],
                'encode' => false,
            ],
        ];
    }
}

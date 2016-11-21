<?php

namespace hipanel\modules\client\menus;

use Yii;

class ContactActionsMenu extends \hiqdev\menumanager\Menu
{
    public $model;

    public function items()
    {
        return [
            [
                'label' => Yii::t('hipanel', 'View'),
                'icon' => 'fa-info',
                'url' => ['@contact/view', 'id' => $this->model->id],
                'encode' => false,
            ],
            [
                'label' => Yii::t('hipanel', 'Edit'),
                'icon' => 'fa-pencil',
                'url' => ['@contact/update', 'id' => $this->model->id],
                'encode' => false,
            ],
            [
                'label' => Yii::t('hipanel', 'Copy'),
                'icon' => 'fa-copy',
                'url' => ['@contact/copy', 'id' => $this->model->id],
                'encode' => false,
            ],
            [
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

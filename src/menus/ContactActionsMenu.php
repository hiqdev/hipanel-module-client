<?php

namespace hipanel\modules\client\menus;

use Yii;
use yii\helpers\Url;

class ContactActionsMenu extends \hiqdev\menumanager\Menu
{
    public $model;

    public function items()
    {
        return [
            [
                'label' => '<i class="fa fa-fw fa-info"></i> ' . Yii::t('hipanel', 'View'),
                'url' => Url::to(['@contact/view', 'id' => $this->model->id]),
                'encode' => false,
            ],
            [
                'label' => '<i class="fa fa-fw fa-pencil"></i> ' . Yii::t('hipanel', 'Edit'),
                'url' => Url::to(['@contact/update', 'id' => $this->model->id]),
                'encode' => false,
            ],
            [
                'label' => '<i class="fa fa-fw fa-copy"></i> ' . Yii::t('hipanel', 'Copy'),
                'url' => Url::to(['@contact/copy', 'id' => $this->model->id]),
                'encode' => false,
            ],
            [
                'label' => '<i class="fa fa-fw fa-trash"></i> ' . Yii::t('hipanel', 'Delete'),
                'url' => Url::to(['@client/delete', 'id' => $this->model->id]),
                'options' => [
                    'data' => [
                        'confirm' => Yii::t('hipanel', 'Are you sure you want to delete this item?'),
                        'method' => 'POST',
                        'data-pjax' => '0',
                    ],
                ],
                'encode' => false,
            ],
        ];
    }
}

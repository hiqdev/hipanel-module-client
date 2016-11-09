<?php

namespace hipanel\modules\client\menus;

use Yii;

class ClientActionsMenu extends \hiqdev\menumanager\Menu
{
    public $model;

    public function items()
    {
        return [
            [
                'label' => '<i class="fa fa-fw fa-info"></i> ' . Yii::t('hipanel', 'View'),
                'url' => ['@client/view', 'id' => $this->model->id],
                'encode' => false,
            ],
            [
                'label' => '<i class="fa fa-fw fa-trash"></i> ' . Yii::t('hipanel', 'Delete'),
                'url' => ['@client/delete', 'id' => $this->model->id],
                'linkOptions' => [
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

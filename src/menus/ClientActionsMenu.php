<?php

namespace hipanel\modules\client\menus;

use hipanel\modules\client\models\Client;
use Yii;

class ClientActionsMenu extends \hiqdev\yii2\menus\Menu
{
    /**
     * @var Client
     */
    public $model;

    /**
     * @inheritdoc
     */
    public function items()
    {
        return [
            'view' => [
                'label' => Yii::t('hipanel', 'View'),
                'icon' => 'fa-info',
                'url' => ['@client/view', 'id' => $this->model->id],
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

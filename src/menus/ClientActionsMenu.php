<?php

namespace hipanel\modules\client\menus;

use Yii;
use yii\helpers\Url;

class ClientActionsMenu extends \hiqdev\menumanager\Menu
{
    public function items()
    {
        return [
            [
                'label' => Yii::t('hipanel', 'View'),
                'url' => Url::to(['@contact/view', 'id' => $this->model->id]),
                'encode' => false,
            ],
            [
                'label' => Yii::t('hipanel', 'Delete'),
                'url' => Url::to(['@contact/delete', 'id' => $this->model->id]),
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

<?php

namespace hipanel\modules\client\grid;

use hipanel\modules\client\models\Client;
use hipanel\widgets\gridLegend\GridLegendInterface;
use Yii;

class ClientGridLegend implements GridLegendInterface
{
    /**
     * @var Client
     */
    protected $model;

    /**
     * @param $model
     */
    public function __construct(Client $model)
    {
        $this->model = $model;
    }

    /**
     * @inheritdoc
     */
    public function items()
    {
        return [
            [
                'label' => Yii::t('hipanel:client', 'Partner'),
            ],
            [
                'label' => Yii::t('hipanel:client', 'Copy'),
            ],
            [
                'label' => Yii::t('hipanel:client', 'Client'),
            ],
            [
                'label' => Yii::t('hipanel:client', 'Employee'),
            ],
            [
                'label' => Yii::t('hipanel:client', 'Reseller'),
                'color' => '#CBFFFF',
                'rule' => ($this->model->type == Client::TYPE_SELLER),
            ],
            [
                'label' => Yii::t('hipanel:client', 'Administrator'),
                'color' => '#EBEBCD',
                'rule' => ($this->model->type == Client::TYPE_ADMIN),
            ],
            [
                'label' => Yii::t('hipanel:client', 'Manager'),
            ],
            [
                'label' => Yii::t('hipanel:client', 'Owner'),
                'color' => '#FFD0CE',
                'rule' => ($this->model->type == Client::TYPE_OWNER),
            ],
            [
                'label' => Yii::t('hipanel:client', 'Support'),
            ],
        ];
    }
}

<?php
/**
 * Client module for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-client
 * @package   hipanel-module-client
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2019, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\client\models;


use hipanel\base\ModelTrait;
use hipanel\modules\client\helpers\TypedProfitColumns;
use hipanel\modules\client\models\Client;
use hipanel\modules\stock\helpers\ProfitColumns;
use hipanel\modules\stock\models\ProfitModelInterface;

/**
 * Class Client
 * @package hipanel\modules\client\models
 *
 * @property string $currency
 * @property string $rack_unit_sum
 * @property string $support_time_sum
 * @property string $overuse_traf_sum
 */
class ClientWithTypedProfit extends Client implements ProfitModelInterface
{
    use ModelTrait;

    /**
     * @inheritDoc
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [
                [
                    'currency',
                    'rack_unit_sum',
                    'support_time_sum',
                    'overuse_traf_sum',
                ],
                'safe',
            ]
        ]);
    }

    /**
     * @inheritDoc
     */
    public function attributeLabels()
    {
        return $this->mergeAttributeLabels(TypedProfitColumns::getLabels());
    }
}

<?php
/**
 * Client module for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-client
 * @package   hipanel-module-client
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2019, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\client\grid;

use hipanel\widgets\gridLegend\BaseGridLegend;
use hipanel\widgets\gridLegend\GridLegendInterface;
use Yii;

class BlacklistGridLegend extends BaseGridLegend implements GridLegendInterface
{
    /**
     * {@inheritdoc}
     */
    public function items()
    {
        return [
            [
                'label' => Yii::t('hipanel:blacklist', 'Name'),
            ],
        ];
    }
}

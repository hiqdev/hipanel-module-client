<?php
/**
 * Client module for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-client
 * @package   hipanel-module-client
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2018, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\client\grid;

use hipanel\modules\client\widgets\combo\SellerCombo;

class SellerColumn extends ClientColumn
{
    public $attribute     = 'seller_id';
    public $idAttribute   = 'seller_id';
    public $nameAttribute = 'seller';

    protected function getDefaultFilter()
    {
        return SellerCombo::widget([
            'attribute' => $this->attribute,
            'model' => $this->grid->filterModel,
            'formElementSelector' => 'td',
        ]);
    }
}

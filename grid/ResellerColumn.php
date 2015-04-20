<?php
/**
 * @link    http://hiqdev.com/hipanel-module-client
 * @license http://hiqdev.com/hipanel-module-client/license
 * @copyright Copyright (c) 2015 HiQDev
 */

namespace hipanel\modules\client\grid;

class ResellerColumn extends ClientColumn
{
    public $attribute     = 'seller_id';
    public $nameAttribute = 'seller';
    public $clientType    = 'reseller';
}

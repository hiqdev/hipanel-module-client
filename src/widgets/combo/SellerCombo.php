<?php

/*
 * Client Plugin for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-client
 * @package   hipanel-module-client
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2014-2015, HiQDev (https://hiqdev.com/)
 */

namespace hipanel\modules\client\widgets\combo;

/**
 * Class Seller.
 */
class SellerCombo extends ClientCombo
{
    /** @inheritdoc */
    public $type = 'client/seller';

    /** @inheritdoc */
    public $clientType = 'reseller';

    /** @inheritdoc */
    public $primaryFilter = 'client_like';
}

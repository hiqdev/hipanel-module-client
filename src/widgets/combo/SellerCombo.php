<?php
/**
 * Client module for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-client
 * @package   hipanel-module-client
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2019, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\client\widgets\combo;

/**
 * Class Seller.
 */
class SellerCombo extends ClientCombo
{
    /**
     * {@inheritdoc}
     */
    public $type = 'client/seller';

    /**
     * {@inheritdoc}
     */
    public $clientType = ['reseller', 'owner'];

    /**
     * {@inheritdoc}
     */
    public $primaryFilter = 'login_like';
}

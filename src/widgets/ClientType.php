<?php
/**
 * Client module for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-client
 * @package   hipanel-module-client
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2017, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\client\widgets;

class ClientType extends \hipanel\widgets\Type
{
    /** {@inheritdoc} */
    public $model         = [];
    public $values        = [];
    public $defaultValues = [
        'none'    => ['client'],
        'danger'  => ['reseller', 'owner'],
        'warning' => ['support', 'admin', 'manager'],
        'primary' => ['employee'],
        'success' => ['partner'],
    ];
    public $field = 'type';
}

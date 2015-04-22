<?php
/**
 * @link    http://hiqdev.com/hipanel-module-domain
 * @license http://hiqdev.com/hipanel-module-domain/license
 * @copyright Copyright (c) 2015 HiQDev
 */

namespace hipanel\modules\client\widgets;

use hipanel\base\Re;

class Type extends \hipanel\widgets\Type
{
    /** @inheritdoc */
    public $model = [];
    public $values = [];
    public $defaultValues = [
        'info'      => ['client'],
        'danger'    => ['reseller', 'owner'],
        'warning'   => ['admin', 'manager'],
    ];
    public $field = 'type';
}

<?php
/**
 * @link    http://hiqdev.com/hipanel-module-domain
 * @license http://hiqdev.com/hipanel-module-domain/license
 * @copyright Copyright (c) 2015 HiQDev
 */

namespace hipanel\modules\client\widgets;

use hipanel\base\Re;

class State extends \hipanel\widgets\Type
{
    /** @inheritdoc */
    public $model = [];
    public $values = [];
    public $defaultValues = [
        'info'      => ['ok'],
        'danger'    => ['blocked', 'wiped'],
        'deleted'   => ['deleted', 'real_deleted'],
        'warning'   => [],
    ];
    public $field = 'state';
}

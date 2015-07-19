<?php

/*
 * Client Plugin for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-client
 * @package   hipanel-module-client
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2014-2015, HiQDev (https://hiqdev.com/)
 */

namespace hipanel\modules\client\widgets;

class State extends \hipanel\widgets\Type
{
    /** @inheritdoc */
    public $model         = [];
    public $values        = [];
    public $defaultValues = [
        'info'    => ['ok'],
        'danger'  => ['blocked', 'wiped'],
        'deleted' => ['deleted', 'real_deleted'],
        'warning' => [],
    ];
    public $field = 'state';
}

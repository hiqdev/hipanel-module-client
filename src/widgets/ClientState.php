<?php

/*
 * Client module for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-client
 * @package   hipanel-module-client
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2016, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\client\widgets;

class ClientState extends \hipanel\widgets\Type
{
    /** {@inheritdoc} */
    public $model         = [];
    public $values        = [];
    public $defaultValues = [
        'none'    => ['ok', 'active'],
        'danger'  => ['blocked', 'wiped'],
        'deleted' => ['deleted', 'real_deleted'],
        'warning' => [],
    ];
    public $field = 'state';
    public $i18nDictionary = 'hipanel/client';
}

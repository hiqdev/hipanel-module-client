<?php declare(strict_types=1);

namespace hipanel\modules\client\widgets;

class BlacklistType extends \hipanel\widgets\Type
{
    /** {@inheritdoc} */
    public $model         = [];
    public $values        = [];
    public $defaultValues = [
        'none'    => ['purse', 'domain', 'ip', 'email'],
//        'danger'  => ['reseller', 'owner'],
//        'warning' => ['support', 'admin', 'manager'],
//        'primary' => ['purse', 'domain', 'ip', 'email'],
//        'success' => ['purse', 'domain', 'ip', 'email'],
    ];
    public $field = 'type';
}
<?php declare(strict_types=1);

namespace hipanel\modules\client\widgets;

class BlacklistState extends \hipanel\widgets\Type
{
    /** {@inheritdoc} */
    public $model         = [];
    public $values        = [];
    public $defaultValues = [
        'success'  => ['ok'],
        'danger'  => ['deleted'],
    ];
    public $field = 'state';
    public $i18nDictionary = 'hipanel:client';
}

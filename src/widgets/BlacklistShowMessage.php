<?php declare(strict_types=1);

namespace hipanel\modules\client\widgets;

use \hipanel\widgets\Type;

class BlacklistShowMessage extends Type
{
    /** {@inheritdoc} */
    public $model         = [];
    public $values        = [];
    public $defaultValues = [
        'success'  => ['yes'],
        'danger'  => ['no'],
    ];
    public $field = 'show_message_label';
    public $i18nDictionary = 'hipanel:client';

    protected function getFieldValue(): string
    {
        return $this->model->show_message ? 'yes' : 'no';
    }
}
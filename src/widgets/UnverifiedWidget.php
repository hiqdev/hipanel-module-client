<?php

/*
 * HiPanel core package
 *
 * @link      https://hipanel.com/
 * @package   hipanel-core
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2014-2016, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\client\widgets;

use yii\helpers\Html;
use hipanel\modules\client\widgets\PhoneVerificationIndicator;
use hipanel\modules\client\widgets\VerificationIndicator;
use hipanel\widgets\VerificationMark;
use Yii;

/**
 *
 * Usage:
 * UnverifiedWidget::widget([
 *      'model' => $model,
 *      'field' => 'email',
 *      'fieldConfirmed' => 'email_new',
 *      'tag' => 'span',
 *      'tagOptions' => ['class' => 'danger'],
 *      'skip' => true,
 * ]);
 *
 * @var string
 */
class UnverifiedWidget extends \yii\base\Widget
{
    /** Contact $model */
    public $model;
    /** @var string */
    public $field;
    public $fieldConfirmed;
    public $tag;
    /** @var array */
    public $tagOptions = [];
    /** @var boolean */
    public $skip = false;

    public function run()
    {
        if (!$this->model->{$this->field} || !$this->field)
        {
            return '';
        }

        $this->fieldConfirmed = $this->fieldConfirmed ? : $this->field . "_confirmed";
        $verification = $this->model->getVerification($this->field);

        $result = $this->tag
            ? (in_array($this->tag, ['a', 'mailto'])
                ? Html::{$this->tag}($this->model->{$this->field}, $this->model->{$this->field}, $this->tagOptions)
                : Html::tag($this->tag, $this->model->{$this->field}, $this->tagOptions))
            : $this->model->{$this->field};

        if ((Yii::$app->user->can('manage') && $this->model->{"{$this->fieldConfirmed}"}) || $this->skip)
        {
            if (!$verification->isConfirmed())
            {
                $result .= '<br>' . Html::tag('b', Yii::t('hipanel:client', 'change is not confirmed'), ['class' => 'text-warning']);
                $result .= '<br>' . Html::tag('span',  $this->model->{"{$this->fieldConfirmed}"}, ['class' => 'text-muted']);
            }
        }

        $result .= VerificationMark::widget(['model' => $verification]);
        return $result . (preg_match('/phone/', $this->field) ? PhoneVerificationIndicator::widget(['model' => $verification]) : VerificationIndicator::widget(['model' => $verification]));
    }
}

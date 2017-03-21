<?php
/**
 * HiPanel core package
 *
 * @link      https://hipanel.com/
 * @package   hipanel-core
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2014-2017, HiQDev (http://hiqdev.com/)
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
 *      'attribute' => 'email',
 *      'confirmedAttribute' => 'email_new',
 *      'tag' => 'span',
 *      'tagOptions' => ['class' => 'danger'],
 *      'checkPermissionsForConfirmedValue' => true,
 * ]);
 *
 * @var string
 */
class UnverifiedWidget extends \yii\base\Widget
{
    /** Contact $model */
    public $model;
    protected $verification;
    /** @var string */
    public $attribute;
    public $confirmedAttribute;
    public $tag;
    /** @var array */
    public $tagOptions = [];
    /** @var boolean: Skip checks for permitions, existing of confirmed attribute */
    public $checkPermissionsForConfirmedValue = false;
    /** @var array */
    public $indicatorMap = [
        'voice_phone' => PhoneVerificationIndicator::class,
        'fax_phone' => PhoneVerificationIndicator::class,
        '*' => VerificationIndicator::class
    ];

    public function init()
    {
        if ($this->model === null) {
            throw new InvalidConfigException('Parameter "model" is required');
        }

        if ($this->attribute === null) {
            throw new InvalidConfigException('Parameter "attribute" is required');
        }

        $this->verification = $this->model->getVerification($this->attribute);
    }

    public function run()
    {
        if ($this->getValue() === null && $this->getConfirmedValue() === null) {
            return '';
        }

        $result = $this->renderValue();
        $result .= $this->renderConfirmedValue();
        $result .= $this->renderVerificationMark();
        $result .= $this->renderVerificationIndicator();

        return $result;
    }

    protected function renderValue()
    {
        if ($this->tag === null) {
            return $this->getValue();
        }

        if (in_array($this->tag, ['a', 'mailto'])) {
            return Html::{$this->tag}($this->getValue(), $this->getValue(), $this->tagOptions);
        }

        return Html::tag($this->tag, $this->getValue(), $this->tagOptions);
    }

    protected function renderConfirmedValue()
    {
        if ($this->verification->isConfirmed() || $this->getConfirmedValue() === null) {
            return '';
        }

        if (!Yii::$app->user->can('manage') && $this->checkPermissionsForConfirmedValue === false) {
            return '';
        }

        $result = '<br>' . Html::tag('b', Yii::t('hipanel:client', 'change is not confirmed'), ['class' => 'text-warning']);
        $result .= '<br>' . Html::tag('span',  $this->getConfirmedValue(), ['class' => 'text-muted']);
        return $result;

    }

    protected function renderVerificationMark()
    {
        return VerificationMark::widget(['model' => $this->verification]);
    }

    protected function renderVerificationIndicator()
    {
        $class = $this->indicatorMap['*'];

        if (isset($this->indicatorMap[$this->attribute])) {
            $class = $this->indicatorMap[$this->attribute];
        }

        return $class::widget(['model' => $this->verification]);
    }

    protected function getValue()
    {
        return $this->getAttributeValue($this->attribute);
    }

    protected function getConfirmedValue()
    {
        return $this->getAttributeValue($this->confirmedAttribute);
    }

    protected function getAttributeValue($attribute)
    {
        return $this->model->getAttribute($attribute) ? $this->model->$attribute : null;
    }
}

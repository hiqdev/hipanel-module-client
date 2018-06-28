<?php
/**
 * Client module for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-client
 * @package   hipanel-module-client
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2018, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\client\widgets;

use hipanel\modules\client\models\Contact;
use hipanel\modules\client\models\Verification;
use hipanel\widgets\VerificationMark;
use Yii;
use yii\base\InvalidConfigException;
use yii\helpers\Html;

/**
 * Usage:
 * ```php
 * echo UnverifiedWidget::widget([
 *      'model' => $model,
 *      'attribute' => 'email',
 *      'confirmedAttribute' => 'email_new',
 *      'tag' => 'span',
 *      'tagOptions' => ['class' => 'danger'],
 *      'checkPermissionsForConfirmedValue' => true,
 * ]);
 *```.
 *
 * @var string
 */
class UnverifiedWidget extends \yii\base\Widget
{
    /**
     * @var Contact
     */
    public $model;

    /**
     * @var Verification
     */
    protected $verification;

    /**
     * @var string
     */
    public $attribute;

    /**
     * @var string
     */
    public $confirmedAttribute;

    /**
     * @var string
     */
    public $tag;

    /**
     * @var array
     */
    public $tagOptions = [];

    /**
     * @var boolean whether to check permissions for the confirmed value
     */
    public $checkPermissionsForConfirmedValue = false;

    /**
     * @var array
     */
    public $indicatorMap = [
        'voice_phone' => PhoneVerificationIndicator::class,
        'fax_phone' => PhoneVerificationIndicator::class,
        '*' => VerificationIndicator::class,
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

        if (in_array($this->tag, ['a', 'mailto'], true)) {
            $tag = $this->tag;

            return Html::$tag($this->getValue(), $this->getValue(), $this->tagOptions);
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
        $result .= '<br>' . Html::tag('span', $this->getConfirmedValue(), ['class' => 'text-muted']);

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

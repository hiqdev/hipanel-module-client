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

use hipanel\modules\client\models\Contact;
use Yii;
use yii\base\InvalidConfigException;
use yii\base\Widget;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

class ConfirmationIndicator extends Widget
{
    /**
     * @var \hipanel\modules\client\models\Confirmation
     */
    public $model;
    /**
     * @var string
     */
    public $scenario;
    /**
     * @var string
     */
    public $type;

    public function init()
    {
        if ($this->model === null) {
            throw new InvalidConfigException('Please specify the "model" property.');
        }

        if ($this->scenario === null) {
            $this->scenario = 'set-confirmation';
        }

        if ($this->type === null) {
            $this->type = $this->model->type;
        }
    }

    public function run()
    {
        if ($this->model->level === \hipanel\modules\client\models\Confirmation::LEVEL_UNCONFIRMED) {
            $this->renderConfirmationButton();
        }
    }

    public function getId($autoGenerate = true)
    {
        return $this->model->id . '-' . $this->type . '-validation-button';
    }

    protected function renderConfirmationButton()
    {
        $form = ActiveForm::begin([
            'action' => ['@contact/request-' . $this->type . '-confirmation'],
            'class' => 'form-inline'
        ]);

        echo $form->field($this->model->contact, 'id')->hiddenInput()->label(false);

        echo Html::submitButton(
            Yii::t('hipanel/client', '{icon} Verify', ['icon' => Html::tag('i', '', ['class' => 'fa fa-check'])]),
            ['class' => 'btn btn-sm btn-info']
        );

        $form->end();
    }
}

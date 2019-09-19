<?php
/**
 * Client module for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-client
 * @package   hipanel-module-client
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2019, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\client\widgets;

use Yii;
use yii\base\InvalidConfigException;
use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Inflector;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

class VerificationIndicator extends Widget
{
    /**
     * @var \hipanel\modules\client\models\Verification
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
        if (!$this->model->isConfirmed()) {
            $this->renderVerificationButton();
        }
    }

    public function getId($autoGenerate = true)
    {
        return $this->model->id . '-' . $this->type . '-validation-button';
    }

    protected function renderVerificationButton()
    {
        $form = ActiveForm::begin([
            'action' => $this->getVerificationUrl(),
            'class' => 'form-inline',
        ]);

        echo $form->field($this->model->contact, 'id')->hiddenInput()->label(false);

        echo Html::submitButton(
            Yii::t('hipanel:client', '{icon} Confirm', ['icon' => Html::tag('i', '', ['class' => 'fa fa-check'])]),
            ['class' => 'btn btn-sm btn-info']
        );

        $form->end();
    }

    private function getVerificationUrl()
    {
        if ($this->type === 'email' && (string)$this->model->id === (string)Yii::$app->user->id) {
            $back = Yii::$app->request->absoluteUrl;

            return Yii::getAlias('@HIAM_SITE') . Url::to(["/site/resend-verification-email", 'back' => $back]);
        }

        return ['@contact/request-' . Inflector::camel2id($this->type) . '-confirmation'];
    }
}

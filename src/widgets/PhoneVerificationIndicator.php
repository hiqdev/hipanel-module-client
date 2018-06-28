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

use hipanel\widgets\AjaxModal;
use Yii;
use yii\helpers\Html;

class PhoneVerificationIndicator extends VerificationIndicator
{
    protected function renderVerificationButton()
    {
        echo AjaxModal::widget([
            'id' => $this->model->id . '-' . $this->type . '-verification-link',
            'header' => Html::tag('h4', Yii::t('hipanel:client', 'Phone number confirmation'), ['class' => 'modal-title']),
            'scenario' => 'push',
            'actionUrl' => [
                '@contact/phone-confirmation-modal',
                'id' => $this->model->id,
                'type' => $this->type,
            ],
            'toggleButton' => [
                'label' => Yii::t('hipanel:client', '{icon} Confirm', ['icon' => Html::tag('i', '', ['class' => 'fa fa-check'])]),
                'class' => 'btn btn-sm btn-info',
                'style' => 'display: block',
            ],
        ]);
    }
}

<?php
/**
 * Client module for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-client
 * @package   hipanel-module-client
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2017, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\client\widgets\verification;

use hipanel\helpers\Url;
use hipanel\modules\client\models\Client;
use hiqdev\bootstrap_switch\AjaxBootstrapSwitch;
use Yii;
use yii\base\Widget;

/**
 * Class VdsOrderVerification.
 */
class ClientVerification extends Widget implements ForceVerificationWidgetInterface
{
    /**
     * @var Client
     */
    public $client;

    /**
     * @return string
     */
    public function getLabel()
    {
        return Yii::t('hipanel:client', 'Is verified');
    }

    /**
     * @return string
     */
    public function getWidget()
    {
        return AjaxBootstrapSwitch::widget([
            'model' => $this->client,
            'attribute' => 'is_verified',
            'url' => Url::to('@client/set-verified'),
            'inlineLabel' => false,
            'options' => [
                'label' => false,
            ],
            'pluginOptions' => [
                'onColor' => 'success',
                'offText' => Yii::t('hipanel:client', 'NO'),
                'onText' => Yii::t('hipanel:client', 'YES'),
            ],
        ]);
    }

    /**
     * @return bool
     */
    public function canBeRendered()
    {
        return true;
    }
}

<?php
/**
 * Client module for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-client
 * @package   hipanel-module-client
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2018, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\client\logic;

use hipanel\modules\client\models\Client;
use Yii;

class IPConfirmer
{
    /**
     * Sends confirmation data from request to API.
     */
    public function confirm()
    {
        Yii::$app->get('hiart')->disableAuth();
        return Client::perform('add-allowed-i-p', [
            'confirm_data' => Yii::$app->request->get(),
        ]);
    }
}

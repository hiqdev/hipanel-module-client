<?php
/**
 * Client module for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-client
 * @package   hipanel-module-client
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2017, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\client\logic;

use hipanel\modules\client\models\Contact;
use Yii;

class EmailConfirmer
{
    /**
     * Sends confirmation data from request to API.
     */
    public function confirm()
    {
        Contact::perform('confirm-email', [
            'confirm_data' => Yii::$app->request->get(),
        ]);

        return true;
    }
}

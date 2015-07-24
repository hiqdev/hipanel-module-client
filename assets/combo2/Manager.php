<?php
/**
 * @link    http://hiqdev.com/hipanel-module-client
 * @license http://hiqdev.com/hipanel-module-client/license
 * @copyright Copyright (c) 2015 HiQDev
 */

namespace hipanel\modules\client\assets\combo2;

use hipanel\widgets\Combo2Config;
use hipanel\helpers\ArrayHelper;
use yii\web\JsExpression;

/**
 * Class Reseller
 */
class Manager extends Client
{
    /** @inheritdoc */
    public $type = 'manager';

    /** @inheritdoc */
    public $clientType = [
        'admin',
        'manager',
        'seller',
        'owner',
    ];

    /** @inheritdoc */
    public $primaryFilter = 'client_like';
}

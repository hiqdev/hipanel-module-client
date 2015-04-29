<?php
/**
 * @link    http://hiqdev.com/hipanel-module-client
 * @license http://hiqdev.com/hipanel-module-client/license
 * @copyright Copyright (c) 2015 HiQDev
 */

namespace hipanel\modules\client\assets\combo2;

use hipanel\widgets\Combo2Config;
use hipanel\helpers\ArrayHelper;

/**
 * Class Client
 */
class Client extends Combo2Config
{
    /** @inheritdoc */
    public $type = 'client';

    /** @inheritdoc */
    public $_primaryFilter = 'login_like';

    /** @inheritdoc */
    public $url = '/client/client/search';

    /** @inheritdoc */
    public $_return = ['id'];

    /** @inheritdoc */
    public $_rename = ['text' => 'login'];

    /**
     * @var string the type of client
     */
    public $clientType;

    /** @inheritdoc */
    public function getFilter () {
        return ArrayHelper::merge(parent::getFilter(), [
            'type'  => ['format' => $this->clientType],
            'order' => ['format' => ['loginlike' => 'desc']],
        ]);
    }
}

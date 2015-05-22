<?php
/**
 * @link    http://hiqdev.com/hipanel-module-client
 * @license http://hiqdev.com/hipanel-module-client/license
 * @copyright Copyright (c) 2015 HiQDev
 */

namespace hipanel\modules\client\widgets\combo;

use hiqdev\combo\Combo;
use hipanel\helpers\ArrayHelper;

/**
 * Class Client
 */
class ClientCombo extends Combo
{
    /** @inheritdoc */
    public $type = 'client/client';

    /** @inheritdoc */
    public $name = 'login';

    /** @inheritdoc */
    public $url = '/client/client/search';

    /** @inheritdoc */
    public $_return = ['id'];

    /** @inheritdoc */
    public $_rename = ['text' => 'login'];

    /**
     * @var string the type of client
     * Used by [[getFilter]] to generate filter
     * @see getFilter()
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

<?php

/*
 * Client module for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-client
 * @package   hipanel-module-client
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2016, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\client\widgets\combo;

use hipanel\helpers\ArrayHelper;
use hiqdev\combo\Combo;

/**
 * Class Client.
 */
class ClientCombo extends Combo
{
    /** {@inheritdoc} */
    public $type = 'client/client';

    /** {@inheritdoc} */
    public $name = 'login';

    /** {@inheritdoc} */
    public $url = '/client/client/index';

    /** {@inheritdoc} */
    public $_return = ['id'];

    /** {@inheritdoc} */
    public $_rename = ['text' => 'login'];

    /**
     * @var string the type of client
     *             Used by [[getFilter]] to generate filter
     *
     * @see getFilter()
     */
    public $clientType;

    /** {@inheritdoc} */
    public function getFilter()
    {
        return ArrayHelper::merge(parent::getFilter(), [
            'type_in'  => ['format' => $this->clientType],
            'order' => ['format' => ['loginlike' => 'desc']],
            'limit' => ['format' => '50'],
        ]);
    }
}

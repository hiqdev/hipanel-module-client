<?php
/**
 * Client module for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-client
 * @package   hipanel-module-client
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2018, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\client\models\stub;

use hipanel\modules\client\models\Client;
use hipanel\modules\client\models\Contact;

class ClientRelationFreeStub extends Client
{
    public function getDomains()
    {
        return null;
    }

    public function getServers()
    {
        return null;
    }

    public function getContact()
    {
        return new Contact();
    }
}

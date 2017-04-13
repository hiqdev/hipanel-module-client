<?php

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

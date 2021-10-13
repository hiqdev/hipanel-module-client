<?php

namespace hipanel\modules\client\widgets;

use hipanel\modules\client\models\Client;
use yii\base\Widget;

class ClientReferralDetailView extends Widget
{
    public Client $client;

    public function run()
    {
        return $this->render('ClientReferralDetailView', [
            'client' => $this->client,
        ]);
    }
}
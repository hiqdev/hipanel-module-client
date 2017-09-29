<?php

namespace hipanel\modules\client\actions;

use hipanel\actions\SmartCreateAction;
use hipanel\modules\client\models\Client;
use Yii;

class ContactCreateAction extends SmartCreateAction
{
    public function init()
    {
        Yii::configure($this, [
            'view' => '@hipanel/modules/client/views/contact/create',
            'success' => Yii::t('hipanel:client', 'Contact was created'),
            'data' => function ($action) {
                return [
                    'countries' => $action->controller->getRefs('country_code'),
                    'action' => 'create',
                ];
            },
        ]);

        if (empty($this->_scenario)) {
            $this->setScenario('create');
        }

        parent::init();
    }
}

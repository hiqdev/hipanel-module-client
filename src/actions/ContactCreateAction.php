<?php
/**
 * Client module for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-client
 * @package   hipanel-module-client
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2019, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\client\actions;

use hipanel\actions\SmartCreateAction;
use hipanel\modules\client\models\BankDetails;
use Yii;

class ContactCreateAction extends SmartCreateAction
{
    public function init()
    {
        Yii::configure($this, [
            'success' => Yii::t('hipanel:client', 'Contact was created'),
            'collectionLoader' => function ($action) {
                $requestData = $action->controller->request->post($action->collection->formName);
                $bankDetails = $action->controller->request->post('BankDetails');
                $requestData['setBankDetails'] = $bankDetails;
                $action->collection->load([$requestData]);
            },
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

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

use hipanel\actions\SmartUpdateAction;
use hipanel\modules\client\helpers\HasPINCode;
use hipanel\modules\client\models\BankDetails;
use Yii;
use yii\base\Event;

class ContactUpdateAction extends SmartUpdateAction
{
    /**
     * @var HasPINCode
     */
    private $hasPINCode;

    public function __construct($id, $controller, HasPINCode $hasPINCode, $config = [])
    {
        parent::__construct($id, $controller, $config);
        $this->hasPINCode = $hasPINCode;
    }

    public function init()
    {
        Yii::configure($this, [
            'success' => Yii::t('hipanel:client', 'Contact was updated'),
            'on beforeFetch' => function ($event) {
                /** @var SmartUpdateAction $action */
                $action = $event->sender;

                $action->getDataProvider()->query
                    ->andFilterWhere(['with_localizations' => true])
                    ->joinWith(['localizations'])
                    ->joinWith(['bankDetails']);
            },
            'on beforeSave' => function (Event $event) {
                /** @var \hipanel\actions\Action $action */
                $action = $event->sender;

                $pincode = Yii::$app->request->post('pincode');
                if (isset($pincode)) {
                    foreach ($action->collection->models as $model) {
                        $model->pincode = $pincode;
                    }
                }
            },
            'collectionLoader' => function ($action) {
                $requestData = $action->controller->request->post($action->collection->formName);
                $bankDetails = $action->controller->request->post('BankDetails');
                $requestData['setBankDetails'] = $bankDetails;
                $action->collection->load([$requestData]);
            },
            'data' => function ($action) {
                return [
                    'countries' => $action->controller->getRefs('country_code'),
                    'currencies' => $action->controller->getRefs('type,currency'),
                    'askPincode' => $this->hasPINCode->__invoke(),
                    'action' => 'update',
                ];
            },
        ]);

        if (empty($this->_scenario)) {
            $this->setScenario('update');
        }

        parent::init();
    }
}

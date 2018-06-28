<?php
/**
 * Client module for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-client
 * @package   hipanel-module-client
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2018, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\client\actions;

use hipanel\actions\SmartUpdateAction;
use hipanel\modules\client\models\Client;
use Yii;
use yii\base\Event;

class ContactUpdateAction extends SmartUpdateAction
{
    public function init()
    {
        Yii::configure($this, [
            'success' => Yii::t('hipanel:client', 'Contact was updated'),
            'view' => '@hipanel/modules/client/views/contact/update',
            'on beforeFetch' => function ($event) {
                /** @var SmartUpdateAction $action */
                $action = $event->sender;

                $action->getDataProvider()->query
                    ->andFilterWhere(['with_localizations' => true])
                    ->joinWith('localizations');
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
            'data' => function ($action) {
                return [
                    'countries' => $action->controller->getRefs('country_code'),
                    'askPincode' => $this->getUserHasPincode(),
                    'action' => 'update',
                ];
            },
        ]);

        if (empty($this->_scenario)) {
            $this->setScenario('update');
        }

        parent::init();
    }

    protected function getUserHasPincode()
    {
        return Yii::$app->cache->getOrSet(['user-pincode-enabled', Yii::$app->user->id], function () {
            $pincodeData = Client::perform('has-pincode', ['id' => Yii::$app->user->id]);

            return $pincodeData['pincode_enabled'];
        }, 3600);
    }
}

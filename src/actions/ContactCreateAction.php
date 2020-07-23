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
use Yii;

class ContactCreateAction extends SmartCreateAction
{
    public function init()
    {
        Yii::configure($this, [
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

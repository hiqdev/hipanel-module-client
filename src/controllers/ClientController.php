<?php

/*
 * Client Plugin for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-client
 * @package   hipanel-module-client
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2014-2015, HiQDev (https://hiqdev.com/)
 */

namespace hipanel\modules\client\controllers;

use hipanel\models\Ref;
use Yii;
use yii\web\Response;

class ClientController extends \hipanel\base\CrudController
{
    public function actions()
    {
        return [
            'index' => [
                'class' => 'hipanel\actions\IndexAction',
                'data' => function ($action) {
                    return [
                        'states' => $action->controller->getStates(),
                    ];
                }
            ],
            'create' => [
                'class' => 'hipanel\actions\SmartCreateAction',
                'success' => Yii::t('app', 'Client is created'),
            ],
            'update' => [
                'class'     => 'hipanel\actions\SmartUpdateAction',
                'success'   => Yii::t('app', 'Client is updated'),
            ],
            'delete' => [
                'class' => 'hipanel\actions\SmartPerformAction',
                'success' => Yii::t('app', 'Client is deleted'),
            ],
            'enable-block' => [
                'class'         => 'hipanel\actions\SmartPerformAction',
                'success'       => Yii::t('app', 'Client is blocked'),
            ],
            'disable-block'=> [
                'class'         => 'hipanel\actions\SmartPerformAction',
                'success'       => Yii::t('app', 'Client is unblocked'),
            ],
            'view' => [
                'class' => 'hipanel\actions\ViewAction',
                'findOptions' => [
                    'with_tickets_count'  => 1,
                    'with_domains_count'  => Yii::getAlias('@domain', false) ? 1 : 0,
                    'with_servers_count'  => 1,
                    'with_hosting_count'  => 1,
                    'with_contacts_count' => 1,
                    'with_last_seen'      => 1,
                    'with_contact'        => 1,
                ],
            ],
            'validate-form' => [
                'class' => 'hipanel\actions\ValidateFormAction',
            ],
            'set-credit' => [
                'class' => 'hipanel\actions\SmartUpdateAction',
                'success' => Yii::t('app', 'Credit changed'),
            ]
        ];
    }

    public function getStates()
    {
        return Ref::getList('state,client');
    }

//    public function actionTicketSettings()
//    {
//        \hipanel\modules\client\models\Client::perform('SetClassValues', ['class' => 'client,ticket_settings', 'values' => [
//            'ticket_emails'     => $this->ticket_emails,
//            'send_message_text' => $this->send_message_text,
//        ]]);
//    }
}

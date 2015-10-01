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

use hipanel\base\CrudController;
use hipanel\modules\client\models\Client;
use hipanel\modules\client\models\Contact;
use Yii;
use yii\base\Exception;
use yii\web\HttpException;
use yii\web\MethodNotAllowedHttpException;

class ContactController extends CrudController
{
    public function actions()
    {
        return [
            'index'         => [
                'class' => 'hipanel\actions\IndexAction',
            ],
            'view'          => [
                'class'         => 'hipanel\actions\ViewAction',
                'findOptions'   => ['with_counters' => 1],
            ],
            'validate-form' => [
                'class'         => 'hipanel\actions\ValidateFormAction',
            ],
            'create'        => [
                'class'         => 'hipanel\actions\SmartCreateAction',
                'scenario'      => 'create',
                'data'          => function ($action) {
                    return [
                        'countries'     => $action->controller->getRefs('country_code'),
                        'scenario'      => 'create',
                    ];
                },
                'success'       => Yii::t('app', 'Contact was created'),
            ],
            'delete'        => [
                'class'         => 'hipanel\actions\SmartDeleteAction',
                'success' => Yii::t('app', 'Contact was deleted'),
            ],
            'update'        => [
                'class'         => 'hipanel\actions\SmartUpdateAction',
                'scenario'      => 'update',
                'success' => Yii::t('app', 'Contact was updated'),
                'data'          => function ($action) {
                    return [
                        'countries'     => $action->controller->getRefs('country_code'),
                        'askPincode'    => Client::perform('HasPincode'),
                        'scenario'      => 'update',
                    ];
                },
            ],
            'copy'          => [
                'class'         => 'hipanel\actions\SmartUpdateAction',
                'scenario'      => 'create',
                'data'          => function ($action) {
                    return [
                        'countries'     => $action->controller->getRefs('country_code'),
                        'scenario'      => 'create',
                    ];
                }
            ],
        ];
    }
}

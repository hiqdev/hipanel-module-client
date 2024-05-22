<?php declare(strict_types=1);
/**
 * Client module for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-client
 * @package   hipanel-module-client
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2019, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\client\controllers;

use hipanel\actions\ComboSearchAction;
use hipanel\actions\IndexAction;
use hipanel\actions\PrepareBulkAction;
use hipanel\actions\SmartCreateAction;
use hipanel\actions\SmartDeleteAction;
use hipanel\actions\SmartUpdateAction;
use hipanel\actions\ValidateFormAction;
use hipanel\actions\ViewAction;
use hipanel\base\CrudController;
use hipanel\models\Ref;
use Yii;

class BlacklistController extends CrudController
{
    public function actions(): array
    {
        return array_merge(parent::actions(), [
            'index' => [
                'class' => IndexAction::class,
                'data' => function ($action) {
                    return [
                        'types' => $this->getRefs('type,blacklisted', 'hipanel:client'),
                        'states' => $this->getRefs('state,blacklisted', 'hipanel:client'),
                    ];
                },
                /*'filterStorageMap' => [
                    'state' => 'client.blacklist.state',
                    'states' => 'client.blacklist.states',
                    'type' => 'client.blacklist.type',
                ],*/
            ],
            'search' => [
                'class' => ComboSearchAction::class,
            ],
            'view' => [
                'class' => ViewAction::class,
            ],
            'update' => [
                'class' => SmartUpdateAction::class,
                'success' => Yii::t('hipanel:client', 'Blacklist was updated'),
//                'data' => function ($action, $data) {
//                    return array_merge($data, [
//                        'currencies' => Ref::getList('type,currency'),
//                    ]);
//                },
            ],
            'create' => [
                'class' => SmartCreateAction::class,
                'success' => Yii::t('hipanel:client', 'Blacklist was created'),
                'data' => function ($action, $data) {
                    return array_merge($data, [
                        'types' => Ref::getList('type,blacklisted'),
                    ]);
                },
            ],
            'validate-form' => [
                'class' => ValidateFormAction::class,
            ],
            'delete' => [
                'class' => SmartDeleteAction::class,
                'success' => Yii::t('hipanel:client', 'Blacklist(s) were deleted'),
                'error' => Yii::t('hipanel:client', 'Failed to delete Blacklist(s)'),
            ],

            'bulk-delete-modal' => [
                'class' => PrepareBulkAction::class,
                'view' => '_bulkDelete',
            ],
        ]);
    }
}
<?php

namespace hipanel\modules\client\controllers;

use hipanel\actions\IndexAction;
use hipanel\actions\SmartUpdateAction;
use hipanel\base\CrudController;
use hipanel\filters\EasyAccessControl;
use hipanel\modules\client\models\Client;
use yii\base\Event;

class AssignmentsController extends CrudController
{
    public static function modelClassName()
    {
        return Client::class;
    }

    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'access-control' => [
                'class' => EasyAccessControl::class,
                'actions' => [
                    'create' => 'plan.create',
                    'update' => 'plan.update',
                    'delete' => 'plan.delete',
                    '*'      => 'plan.read',
                ],
            ],
        ]);
    }

    public function actions()
    {
        return array_merge(parent::actions(), [
            'index' => [
                'class' => IndexAction::class,
                'on beforePerform' => function (Event $event) {
                    /** @var \hipanel\actions\SearchAction $action */
                    $action = $event->sender;
                    $dataProvider = $action->getDataProvider();
                    $dataProvider->query
                        ->joinWith(['assignments'])
                        ->addSelect('assignments');
                },
            ],
            'update' => [
                'class' => SmartUpdateAction::class,
            ],
        ]);
    }
}

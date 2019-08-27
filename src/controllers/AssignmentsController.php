<?php

namespace hipanel\modules\client\controllers;

use hipanel\actions\IndexAction;
use hipanel\actions\SmartUpdateAction;
use hipanel\actions\ViewAction;
use hipanel\base\CrudController;
use hipanel\filters\EasyAccessControl;
use hipanel\helpers\ArrayHelper;
use hipanel\modules\client\models\Client;
use hipanel\modules\finance\models\Plan;
use hipanel\modules\finance\models\TariffProfile;
use Yii;
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
                    '*' => 'plan.read',
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
                'on beforeFetch' => function (Event $event) {
                    /** @var \hipanel\actions\SearchAction $action */
                    $action = $event->sender;
                    $dataProvider = $action->getDataProvider();
                    $dataProvider->query
                        ->joinWith(['assignments'])
                        ->addSelect('assignments');
                },
                'data' => function ($action) {
                    /** @var Client $client */
                    $plans = ArrayHelper::index(Plan::find()->where(['client_id' => Yii::$app->user->id])->limit(-1)->all(), 'id', 'type');
                    unset($plans['template']);
                    $profiles = TariffProfile::find()->where(['client' => Yii::$app->user->identity->username])->limit(-1)->all();

                    return compact('plans', 'profiles');
                },
            ],
            'view' => [
                'class' => ViewAction::class,
            ],
        ]);
    }

    public function actionAssign()
    {
        $data = [];
        $model = new Client(['scenario' => 'set-tariffs']);
        $request = Yii::$app->request;
        $session = Yii::$app->session;
        $model->load($request->post());

        if ($model->validate()) {
            $tariff_ids = [];
            if ($model->tariff_ids) {
                foreach ($model->tariff_ids as $tariffIds) {
                    $tariff_ids = array_merge($tariff_ids, $tariffIds);
                }
            }
            $profile_ids = $model->profile_ids ?? [];
            foreach ($model->ids as $id) {
                $model->id = $id;
                $model->tariff_ids = array_filter($tariff_ids);
                $model->profile_ids = array_filter($profile_ids);
                $data[$id] = array_filter($model->attributes);
            }
            try {
                $resp = Client::batchPerform('set-tariffs', $data);
                $session->addFlash('success', Yii::t('hipanel', 'Assignments have been successfully applied.'));
            } catch (\Exception $e) {
                $session->addFlash('error', $e->getMessage());
            }

            return $this->redirect('index');
        }
    }
}

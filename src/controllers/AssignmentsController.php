<?php

namespace hipanel\modules\client\controllers;

use hipanel\actions\IndexAction;
use hipanel\actions\SearchAction;
use hipanel\actions\SmartUpdateAction;
use hipanel\actions\ViewAction;
use hipanel\base\CrudController;
use hipanel\filters\EasyAccessControl;
use hipanel\helpers\ArrayHelper;
use hipanel\models\User;
use hipanel\modules\client\models\Client;
use hipanel\modules\finance\models\Plan;
use hipanel\modules\finance\models\PlanType;
use hipanel\modules\finance\models\TariffProfile;
use RuntimeException;
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
                    /** @var SearchAction $action */
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
                    /** @var SearchAction $action */
                    $action = $event->sender;
                    $dataProvider = $action->getDataProvider();
                    $dataProvider->query
                        ->joinWith(['assignments'])
                        ->addSelect('assignments');
                },
                'data' => function ($action, array $data) {
                    $errorMassage = null;
                    /** @var User $identity */
                    $identity = Yii::$app->user->identity;
                    $sellers = array_unique(array_column($data['models'], 'seller_id'));
                    if (count($sellers) > 1) {
                        $errorMassage = Yii::t('hipanel:client', 'You cannot manage more than one reseller\'s assignments, select records with the same reseller');

                        return compact('errorMassage');
                    }
                    if (!in_array(implode("", $sellers), [(string)$identity->seller_id, (string)$identity->id])) {
                        $errorMassage = Yii::t('hipanel:client', 'To manage the assigned tariffs of this client, login as the seller of this client!');

                        return compact('errorMassage');
                    }
                    $mainSeller = $this->getSellerFromIdentity($identity);
                    $planTypes = array_filter(PlanType::find()
                        ->select(null)
                        ->where(['client_id' => $mainSeller['id'], 'groupby' => 'plan_types'])
                        ->limit(-1)
                        ->all(), static fn(PlanType $planType): bool => $planType->name !== Plan::TYPE_TEMPLATE);
                    $plansIds = $this->flatten(ArrayHelper::getColumn($data['models'], 'tariffAssignment.planIds'));
                    $plansByType = empty($plansIds) ? [] : ArrayHelper::map(Plan::find()
                        ->where(['ids' => $plansIds, 'client_id' => $mainSeller['id']])
                        ->limit(-1)
                        ->all(), 'id', 'name', 'type');
                    $profiles = TariffProfile::find()->where(['client' => $mainSeller['login']])->limit(-1)->all();

                    return ['plansByType' => $plansByType, 'planTypes' => $planTypes, 'profiles' => $profiles, 'errorMassage' => $errorMassage];
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
                    $tariff_ids = array_merge($tariff_ids, ($tariffIds ?: []));
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
                Client::batchPerform('set-tariffs', $data);
                $session->addFlash('success', Yii::t('hipanel', 'Assignments have been successfully applied.'));
            } catch (RuntimeException $e) {
                $session->addFlash('error', $e->getMessage());
            }

            return $this->redirect('index');
        }
    }

    private function flatten(array $array): array
    {
        $return = [];
        array_walk_recursive($array, static function ($a) use (&$return) {
            $return[] = $a;
        });

        return array_unique($return);
    }

    private function getSellerFromIdentity(User $identity): array
    {
        if ($identity->type === Client::TYPE_SELLER) {
            return [
                'id' => $identity->id,
                'login' => $identity->username,
            ];
        }

        return [
            'id' => $identity->seller_id,
            'login' => $identity->seller,
        ];
    }
}

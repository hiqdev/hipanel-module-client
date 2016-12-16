<?php

namespace hipanel\modules\client\menus;

use hipanel\modules\client\models\Client;
use hipanel\widgets\BlockModalButton;
use hipanel\widgets\SettingsModal;
use hiqdev\menumanager\Menu;
use Yii;

class ClientDetailMenu extends Menu
{
    /**
     * @var Client
     */
    public $model;

    public function items()
    {
        $actions = ClientActionsMenu::create([
            'model' => $this->model,
        ])->items();

        $items = array_merge([
            [
                'label' => Yii::t('hipanel:client', 'You can change your avatar at Gravatar.com'),
                'icon' => 'fa-user', // 'fa-user-circle-o',
                'url' => 'http://gravatar.com',
                'linkOptions' => [
                    'target' => '_blank',
                ]
            ],
            [
                'label' => SettingsModal::widget([
                    'model' => $this->model,
                    'title' => Yii::t('hipanel', 'Change password'),
                    'icon' => 'fa-key fa-flip-horizontal fa-fw',
                    'scenario' => 'change-password',
                ]),
                'encode' => false,
                'visible' => Yii::$app->user->is($this->model->id),
            ],
            [
                'label' => SettingsModal::widget([
                    'model' => $this->model,
                    'title' => Yii::t('hipanel:client', 'Temporary password'),
                    'icon' => 'fa-key fa-flip-horizontal fa-fw',
                    'scenario' => 'set-tmp-password',
                ]),
                'encode' => false,
                'visible' => Yii::$app->user->not($this->model->id) && Yii::$app->user->can('manage'),
            ],
            [
                'label' => SettingsModal::widget([
                    'model' => $this->model,
                    'title' => Yii::t('hipanel:client', 'Pincode settings'),
                    'icon' => 'fa-puzzle-piece fa-fw',
                    'scenario' => 'pincode-settings',
                ]),
                'encode' => false,
                'visible' => Yii::$app->user->is($this->model->id),
            ],
            [
                'label' => SettingsModal::widget([
                    'model' => $this->model,
                    'title' => Yii::t('hipanel:client', 'IP address restrictions'),
                    'icon' => 'fa-arrows-alt fa-fw',
                    'scenario' => 'ip-restrictions',
                ]),
                'encode' => false,
                'visible' => Yii::$app->user->is($this->model->id),
            ],
            [
                'label' => SettingsModal::widget([
                    'model' => $this->model,
                    'title' => Yii::t('hipanel:client', 'Notification settings'),
                    'icon' => 'fa-envelope fa-fw',
                    'scenario' => 'mailing-settings',
                ]),
                'encode' => false,
            ],
            [
                'label' => Yii::t('hipanel:client', 'Change contact information'),
                'icon' => 'fa-edit fa-fw',
                'url' => ['@contact/update', 'id' => $this->model->id],
                'encode' => false,
                'visible' => false,
            ],
            [
                'label' => SettingsModal::widget([
                    'model' => $this->model,
                    'title' => Yii::t('hipanel:client', 'Domain settings'),
                    'icon' => 'fa-globe fa-fw',
                    'scenario' => 'domain-settings',
                ]),
                'encode' => false,
                'visible' => Yii::getAlias('@domain', false),
            ],
            [
                'label' => SettingsModal::widget([
                    'model' => $this->model,
                    'title' => Yii::t('hipanel:ticket', 'Ticket settings'),
                    'icon' => 'fa-ticket fa-fw',
                    'scenario' => 'ticket-settings',
                ]),
                'encode' => false,
                'visible' => Yii::getAlias('@ticket', false),
            ],
            [
                'label' => BlockModalButton::widget(['model' => $this->model]),
                'encode' => false,
                'visible' => Yii::$app->user->can('support') && Yii::$app->user->not($this->model->id),
            ],
        ], $actions);

        unset($items['view']);

        return $items;
    }
}

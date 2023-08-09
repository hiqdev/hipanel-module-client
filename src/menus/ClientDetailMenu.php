<?php
/**
 * Client module for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-client
 * @package   hipanel-module-client
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2019, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\client\menus;

use hipanel\helpers\FontIcon;
use hipanel\modules\client\models\Client;
use hipanel\widgets\AjaxModal;
use hipanel\widgets\AjaxModalWithTemplatedButton;
use hipanel\widgets\BlockModalButton;
use hipanel\widgets\ImpersonateButton;
use hipanel\widgets\SettingsModal;
use hipanel\widgets\SimpleOperation;
use Yii;
use yii\bootstrap\Html;
use yii\bootstrap\Modal;
use yii\helpers\Url;

class ClientDetailMenu extends \hipanel\menus\AbstractDetailMenu
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

        $user = Yii::$app->user;
        $totp_enabled = $this->model->totp_enabled;

        $items = array_merge([
            [
                'label' => Yii::t('hipanel:client', 'You can change your avatar at Gravatar.com'),
                'icon' => 'fa-user', // 'fa-user-circle-o',
                'url' => 'http://gravatar.com',
                'linkOptions' => [
                    'target' => '_blank',
                ],
                'visible' => $user->is($this->model->id),
            ],
            [
                'label' => Yii::t('hipanel:client', 'Edit Permissions'),
                'url' => ['/client/permission/view', 'id' => $this->model->id],
                'icon' => 'fa-id-card-o',
                'visible' => $user->can('client.set-roles'),
            ],
            [
                'label' => SettingsModal::widget([
                    'model' => $this->model,
                    'title' => Yii::t('hipanel', 'Change password'),
                    'headerOptions' => ['class' => 'label-info'],
                    'icon' => 'fa-key fa-flip-horizontal fa-fw',
                    'scenario' => 'change-password',
                ]),
                'encode' => false,
                'visible' => $user->is($this->model->id),
            ],
            [
                'label' => $totp_enabled ? Yii::t('hipanel:client', 'Disable two factor authorization') : Yii::t('hipanel:client', 'Enable two factor authorization'),
                'icon' => 'fa-lock',
                'url' => Yii::getAlias('@HIAM_SITE', false) . Url::to(['/mfa/totp/' . ($totp_enabled ? 'disable' : 'enable'), 'back' => Url::to('', true)]),
                'visible' => $user->is($this->model->id),
            ],
            [
                'label' => SettingsModal::widget([
                    'model' => $this->model,
                    'title' => Yii::t('hipanel:client', 'Temporary password'),
                    'headerOptions' => ['class' => 'label-warning'],
                    'icon' => 'fa-key fa-flip-horizontal fa-fw',
                    'scenario' => 'set-tmp-password',
                ]),
                'encode' => false,
                'visible' => $user->not($this->model->id)
                                && $user->can('client.set-tmp-pwd')
                                && !$this->model->isDeleted()
                                && $this->model->type === 'client',
            ],
            [
                'label' => ImpersonateButton::widget(['model' => $this->model]),
                'encode' => false,
                'visible' => $user->can('client.impersonate') && $user->not($this->model->id) && !$this->model->isDeleted(),
            ],
            [
                'label' => SettingsModal::widget([
                    'model' => $this->model,
                    'title' => Yii::t('hipanel:client', 'Pincode settings'),
                    'headerOptions' => ['class' => 'label-warning'],
                    'icon' => 'fa-puzzle-piece fa-fw',
                    'scenario' => 'pincode-settings',
                ]),
                'encode' => false,
                'visible' => $user->is($this->model->id),
            ],
            [
                'label' => SettingsModal::widget([
                    'model' => $this->model,
                    'title' => Yii::t('hipanel:client', 'IP address restrictions'),
                    'headerOptions' => ['class' => 'label-warning'],
                    'icon' => 'fa-arrows-alt fa-fw',
                    'scenario' => 'ip-restrictions',
                    'toggleButton' => [
                        'data-anchor' => 'ip_restriction_settings',
                    ],
                ]),
                'encode' => false,
                'visible' => $user->is($this->model->id) || ($user->can('client.set-others-allowed-ips') && !$this->model->isDeleted()),
            ],
            [
                'label' => SettingsModal::widget([
                    'model' => $this->model,
                    'title' => Yii::t('hipanel:client', 'Notification settings'),
                    'headerOptions' => ['class' => 'label-info'],
                    'icon' => 'fa-envelope fa-fw',
                    'scenario' => 'mailing-settings',
                    'toggleButton' => [
                        'data-anchor' => 'notification_settings',
                    ],
                ]),
                'encode' => false,
                'visible' => $this->model->type !== Client::TYPE_EMPLOYEE && !$this->model->isDeleted(),
            ],
            [
                'label' => Yii::t('hipanel:client', 'Change contact information'),
                'icon' => 'fa-edit fa-fw',
                'url' => ['@contact/update', 'id' => $this->model->id],
                'encode' => false,
                'visible' => false,
            ],
            [
                'label' => Yii::t('hipanel:client', 'User edit'),
                'icon' => 'fa-edit fa-fw',
                'url' => ['@client/update', 'id' => $this->model->id],
                'encode' => false,
                'visible' => $user->can('client.update') && !$this->model->isDeleted() && $this->model->notMyself() && $this->model->notMySeller(),
            ],
            [
                'label' => SettingsModal::widget([
                    'model' => $this->model,
                    'title' => Yii::t('hipanel:client', 'Domain settings'),
                    'headerOptions' => ['class' => 'label-info'],
                    'icon' => 'fa-globe fa-fw',
                    'scenario' => 'domain-settings',
                ]),
                'encode' => false,
                'visible' => Yii::getAlias('@domain', false) && !$this->model->isDeleted(),
            ],
            [
                'label' => SettingsModal::widget([
                    'model' => $this->model,
                    'title' => Yii::t('hipanel:client', 'Financial settings'),
                    'headerOptions' => ['class' => 'label-info'],
                    'icon' => 'fa fa-fw fa-money',
                    'scenario' => 'finance-settings',
                ]),
                'encode' => false,
                'visible' => !$this->model->isDeleted(),
            ],
            [
                'label' => SettingsModal::widget([
                    'model' => $this->model,
                    'title' => Yii::t('hipanel:ticket', 'Ticket settings'),
                    'headerOptions' => ['class' => 'label-info'],
                    'icon' => 'fa-ticket fa-fw',
                    'scenario' => 'ticket-settings',
                ]),
                'encode' => false,
                'visible' => Yii::getAlias('@ticket', false) && $this->model->type !== Client::TYPE_EMPLOYEE && !$this->model->isDeleted(),
            ],
            [
                'label' => BlockModalButton::widget(['model' => $this->model]),
                'encode' => false,
                'visible' => $this->model->canBeBlocked() || $this->model->canBeUnblocked(),
            ],
            [
                'label' => SimpleOperation::widget([
                    'model' => $this->model,
                    'scenario' => 'delete',
                    'buttonLabel' => '<i class="fa fa-fw fa-trash-o"></i>' . Yii::t('hipanel', 'Delete'),
                    'buttonClass' => '',
                    'body' => Yii::t('hipanel:client', 'Are you sure you want to delete client {name}?', ['name' => $this->model->client]),
                    'modalHeaderLabel' => Yii::t('hipanel:client', 'Confirm client deleting'),
                    'modalHeaderOptions' => ['class' => 'label-danger'],
                    'modalFooterLabel' => Yii::t('hipanel:client', 'Delete client'),
                    'modalFooterLoading' => Yii::t('hipanel:client', 'Deleting client'),
                    'modalFooterClass' => 'btn btn-danger',
                ]),
                'encode' => false,
                'visible' => $this->model->canBeDeleted(),
            ],
            [
                'label' => SimpleOperation::widget([
                    'model' => $this->model,
                    'scenario' => 'restore',
                    'buttonLabel' => '<i class="fa fa-fw fa-trash-o"></i>' . Yii::t('hipanel', 'Restore'),
                    'buttonClass' => '',
                    'body' => Yii::t('hipanel:client', 'Are you sure you want to restore client {name}?', ['name' => $this->model->client]),
                    'modalHeaderLabel' => Yii::t('hipanel:client', 'Confirm client restoring'),
                    'modalHeaderOptions' => ['class' => 'label-danger'],
                    'modalFooterLabel' => Yii::t('hipanel:client', 'Restore client'),
                    'modalFooterLoading' => Yii::t('hipanel:client', 'Restoring client'),
                    'modalFooterClass' => 'btn btn-danger',
                ]),
                'encode' => false,
                'visible' => $this->model->canBeRestored(),
            ],
            !$this->model->hasReferralTariff() && $this->model->notMyself() ? [
                'label' => AjaxModalWithTemplatedButton::widget([
                    'ajaxModalOptions' => [
                        'bulkPage' => false,
                        'usePost' => true,
                        'id' => 'client-set-referral-tariff',
                        'scenario' => 'sell',
                        'actionUrl' => ['set-referral-tariff', 'id' => $this->model->id],
                        'handleSubmit' => Url::toRoute(['set-referral-tariff']),
                        'size' => Modal::SIZE_SMALL,
                        'header' => Html::tag('h4', Yii::t('hipanel:client', 'Referral program'), ['class' => 'modal-title']),
                        'toggleButton' => [
                            'tag' => 'a',
                            'label' => '<i class="fa fa-fw fa-percent"></i>' . Yii::t('hipanel:client', 'Enable referral program'),
                            'class' => 'clickable',
                        ],
                    ],
                    'toggleButtonTemplate' => '{toggleButton}',
                ]),
                'encode' => false,
            ] : [],
            [
                'label' => AjaxModal::widget([
                    'actionUrl' => ['@client/set-attributes', 'id'=> $this->model->id],
                    'header' => Html::tag('h4', Yii::t('hipanel:client', 'Additional information'), ['class' => 'model-title']),
                    'scenario' => 'update',
                    'toggleButton' => [
                        'tag' => 'a',
                        'label' => FontIcon::i('fa-edit fa-fw') . " " . Yii::t('hipanel:client', 'Set additional information'),
                        'class' => 'clickable',
                    ],
                ]),
                'encode' => false,
                'visible' => $user->can('client.update'),
            ],
        ], $actions);

        unset($items['view']);

        return $items;
    }
}

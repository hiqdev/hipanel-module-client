<?php
/**
 * Client module for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-client
 * @package   hipanel-module-client
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2019, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\client\grid;

use DateTime;
use hipanel\grid\BoxedGridView;
use hipanel\grid\DataColumn;
use hipanel\grid\MainColumn;
use hipanel\grid\RefColumn;
use hipanel\grid\XEditableColumn;
use hipanel\helpers\Url;
use hipanel\modules\client\helpers\ClientProfitColumns;
use hipanel\modules\client\menus\ClientActionsMenu;
use hipanel\modules\client\models\Client;
use hipanel\modules\client\widgets\ClientState;
use hipanel\modules\client\widgets\ClientType;
use hipanel\modules\finance\controllers\BillController;
use hipanel\modules\finance\grid\BalanceColumn;
use hipanel\modules\finance\grid\CreditColumn;
use hipanel\modules\finance\widgets\ColoredBalance;
use hipanel\modules\stock\helpers\ProfitColumns;
use hipanel\widgets\ArraySpoiler;
use hiqdev\yii2\menus\grid\MenuColumn;
use Yii;
use yii\helpers\Html;
use yii\helpers\Inflector;

class ClientGridView extends BoxedGridView
{
    /**
     * @return array
     */
    private function getProfitColumns(): array
    {
        return class_exists(ProfitColumns::class) ? ClientProfitColumns::getGridColumns($this, 'client_id') : [];
    }

    /**
     * @inheritDoc
     */
    public function columns()
    {
        $formatter = Yii::$app->formatter;
        $thisMonthDt = (new DateTime())->modify('first day of this month')->format('Y-m-d 00:00:00');

        return array_merge(parent::columns(), $this->getProfitColumns(), [
            'id' => [
                'class' => ClientColumn::class,
                'attribute' => 'id',
                'nameAttribute' => 'login',
                'label' => Yii::t('hipanel', 'Client'),
            ],
            'requisites' => [
                'attribute' => 'purses',
                'label' => Yii::t('hipanel:client', 'Requisites'),
                'format' => 'raw',
                'value' => function ($model) {
                    foreach ($model->purses as $purse) {
                        if ($purse->currency === 'usd' && !empty($purse->requisite)) {
                            return Html::a(Html::encode($purse->requisite['name']), ['@contact/view', 'id' => $purse->requisite['id']]);
                        }
                    }

                    return null;
                },
            ],
            'referer_id' => [
                'class' => ClientColumn::class,
                'idAttribute' => 'referer_id',
                'attribute' => 'referer_id',
                'nameAttribute' => 'referer',
            ],
            'balance_eur' => [
                'attribute' => 'purses',
                'label' => Yii::t('hipanel:client', 'Balance EUR'),
                'format' => 'raw',
                'value' => function ($model) {
                    $html = '';
                    if ($model->purses) {
                        foreach ($model->purses as $purse) {
                            if ($purse->currency === 'eur') {
                                $html = ColoredBalance::widget(['model' => $purse]);
                            }
                        }
                    }

                    return $html;
                },
            ],
            'balance_other' => [
                'attribute' => 'purses',
                'label' => Yii::t('hipanel:client', 'Other balances'),
                'format' => 'raw',
                'value' => function ($model) {
                    $html = '';
                    if ($model->purses) {
                        foreach ($model->purses as $purse) {
                            if (!in_array($purse->currency, ['usd', 'eur'], true)) {
                                $html .= ColoredBalance::widget(['model' => $purse]);
                                $html .= '<br>';
                            }
                        }
                    }

                    return $html;
                },
            ],
            'login' => [
                'class' => MainColumn::class,
                'attribute' => 'login',
                'filterAttribute' => 'login_like',
                'note' => Yii::$app->user->can('manage') ? 'note' : null,
                'noteOptions' => [
                    'url' => Url::to('@client/set-note'),
                ],
                'footer' => '<b>' . Yii::t('hipanel:client', 'TOTAL on screen') . '</b>',
            ],
            'login_without_note' => [
                'class' => MainColumn::class,
                'attribute' => 'login',
                'filterAttribute' => 'login_ilike',
            ],
            'note' => [
                'class' => XEditableColumn::class,
                'pluginOptions' => [
                    'url' => Url::to('@client/set-note'),
                ],
                'widgetOptions' => [
                    'linkOptions' => [
                        'data-type' => 'textarea',
                    ],
                ],
                'visible' => Yii::$app->user->can('support'),
            ],
            'name' => [
                'filterAttribute' => 'name_ilike',
            ],
            'name_language' => [
                'filterAttribute' => 'name_ilike',
                'label' => Yii::t('hipanel', 'Client'),
                'format' => 'raw',
                'value' => function ($model) {
                    $flag = Html::tag('span', $model->getLanguage(), ['class' => 'label bg-olive']);

                    return sprintf('<div style="display: flex; justify-content: space-between;"><div>%s</div><div>%s</div></div>', Html::encode($model->name), $flag);
                },
            ],
            'state' => [
                'class' => RefColumn::class,
                'filterAttribute' => 'states',
                'filterOptions' => ['class' => 'narrow-filter'],
                'format' => 'raw',
                'gtype' => 'state,client',
                'i18nDictionary' => 'hipanel:client',
                'value' => function ($model) {
                    return ClientState::widget(compact('model'));
                },
            ],
            'type' => [
                'class' => RefColumn::class,
                'filterAttribute' => 'types',
                'filterOptions' => ['class' => 'narrow-filter'],
                'format' => 'raw',
                'gtype' => 'type,client',
                'i18nDictionary' => 'hipanel:client',
                'value' => function ($model) {
                    return ClientType::widget(compact('model'));
                },
            ],
            'balance' => [
                'class' => BalanceColumn::class,
            ],
            'balances' => [
                'label' => Yii::t('hipanel:client', 'Balances'),
                'format' => 'raw',
                'value' => function ($model) {
                    $balances = [];
                    if ($model->purses) {
                        foreach ($model->sortedPurses as $purse) {
                            $billSearchUrl = BillController::getSearchUrl(['client_id' => $model->client_id, 'purse_id' => $purse->id, 'currency_in' => [$purse->currency]]);
                            $balance = ColoredBalance::widget(['model' => $purse, 'url' => $billSearchUrl]);
                            array_push($balances, $balance);
                        }
                    }

                    return join('<br>', $balances);
                },
                'contentOptions' => ['class' => 'text-small text-right'],
            ],
            'credit' => CreditColumn::resolveConfig(),
            'country' => [
                'attribute' => 'contact',
                'label' => Yii::t('hipanel:client', 'Country'),
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::tag('span', '', ['class' => 'flag-icon flag-icon-' . Html::encode($model->contact['country'])]) .
                        '&nbsp;&nbsp;' . Html::encode($model->contact['country_name']);
                },
            ],
            'create_date' => [
                'attribute' => 'create_time',
                'format' => 'date',
                'filter' => false,
                'contentOptions' => ['class' => 'text-nowrap'],
            ],
            'create_time' => [
                'attribute' => 'create_time',
                'format' => 'datetime',
                'filter' => false,
            ],
            'update_date' => [
                'attribute' => 'update_time',
                'format' => 'date',
                'filter' => false,
                'contentOptions' => ['class' => 'text-nowrap'],
            ],
            'update_time' => [
                'attribute' => 'update_time',
                'format' => 'datetime',
                'filter' => false,
            ],
            'last_seen' => [
                'attribute' => 'last_seen',
                'format' => 'date',
                'filter' => false,
                'contentOptions' => ['class' => 'text-nowrap'],
                'value' => '',
            ],
            'tickets' => [
                'format' => 'raw',
                'label' => Yii::t('hipanel', 'Tickets'),
                'value' => function ($model) {
                    $num = $model->count['tickets'];
                    $url = Url::toRoute(['@ticket/index', 'ThreadSearch' => ['recipient_id' => $model->id]]);

                    return $num ? Html::a(Yii::t('hipanel', '{0, plural, one{# ticket} other{# tickets}}', $num), $url) : '';
                },
            ],
            'servers' => [
                'format' => 'raw',
                'visible' => Yii::getAlias('@server', false) !== false,
                'label' => Yii::t('hipanel', 'Servers'),
                'value' => function ($model) {
                    /** @var Client $model */
                    $result = [];

                    if ($num = $model->count['servers']) {
                        $result[] = Html::a(
                            Yii::t('hipanel', '{0, plural, one{# server} other{# servers}}', $num),
                            Url::toSearch('server', ['client_id' => $model->id])
                        );
                    }

                    if (Yii::$app->user->can('resell') && $num = $model->count['pre_ordered_servers']) {
                        $result[] = Html::a(
                            Yii::t('hipanel:client', '{0, plural, one{# pre-ordered server} other{# pre-ordered servers}}', $num),
                            Url::to(['@pre-order', 'ChangeSearch' => ['client_id' => $model->id]])
                        );
                    }

                    return implode(', ', $result);
                },
            ],
            'targets' => [
                'format' => 'raw',
                'visible' => Yii::getAlias('@target', false) !== false,
                'label' => Yii::t('hipanel', 'Targets'),
                'value' => function ($model) {
                    /** @var Client $model */
                    $result = [];

                    if ($num = $model->count['targets']) {
                        $result[] = Html::a(
                            Yii::t('hipanel', '{0, plural, one{# target} other{# targets}}', $num),
                            Url::toSearch('target', ['client_id' => $model->id])
                        );
                    }

                    return implode(', ', $result);
                },
            ],
            'domains' => [
                'format' => 'raw',
                'visible' => Yii::getAlias('@domain', false) !== false,
                'label' => Yii::t('hipanel', 'Domains'),
                'value' => function ($model) {
                    /** @var Client $model */
                    $num = $model->count['domains'];
                    $url = Url::toSearch('domain', ['client_id' => $model->id]);

                    return $num ? Html::a(Yii::t('hipanel', '{0, plural, one{# domain} other{# domains}}', $num), $url) : '';
                },
            ],
            'domains_spoiler' => [
                'format' => 'raw',
                'visible' => Yii::getAlias('@domain', false) !== false,
                'label' => Yii::t('hipanel', 'Domains'),
                'value' => function ($model) {
                    /** @var Client $model */
                    return ArraySpoiler::widget([
                        'id' => uniqid('ds'),
                        'data' => $model->domains,
                        'visibleCount' => 1,
                        'button' => [
                            'label' => '+' . ($model->count['domains'] - 1),
                            'popoverOptions' => [
                                'html' => true,
                            ],
                        ],
                        'formatter' => function ($item, $key) use ($model) {
                            static $index = 0;
                            ++$index;

                            $value = Html::a(Html::encode($item->domain), ['@domain/view', 'id' => $item->id]);
                            if ($model->count['domains'] > count($model->domains) && $index === count($model->domains)) {
                                $text = Yii::t('hipanel:client', 'and {n} more', ['n' => $model->count['domains'] - count($model->domains)]);
                                $value .= ' ' . Html::a($text, Url::toSearch('domain', ['client_id' => $model->id]), ['class' => 'border-bottom-dashed']);
                            }

                            return $value;
                        },
                    ]);
                },
            ],
            'servers_spoiler' => [
                'format' => 'raw',
                'label' => Yii::t('hipanel', 'Servers'),
                'value' => function ($model) {
                    return ArraySpoiler::widget([
                        'id' => uniqid('ss'),
                        'data' => $model->servers,
                        'visibleCount' => 1,
                        'button' => [
                            'label' => '+' . ($model->count['servers'] - 1),
                            'popoverOptions' => [
                                'html' => true,
                            ],
                        ],
                        'formatter' => function ($item, $key) use ($model) {
                            static $index;
                            ++$index;

                            $value = Html::a(Html::encode($item->name), ['@server/view', 'id' => $item->id]);
                            if ($model->count['servers'] > count($model->servers) && $index === count($model->servers)) {
                                $text = Yii::t('hipanel:client', 'and {n} more', ['n' => $model->count['servers'] - count($model->servers)]);
                                $value .= ' ' . Html::a($text, Url::toSearch('server', ['client_id' => $model->id]), ['class' => 'border-bottom-dashed']);
                            }

                            return $value;
                        },
                    ]);
                },
            ],
            'targets_spoiler' => [
                'format' => 'raw',
                'label' => Yii::t('hipanel', 'Targets'),
                'value' => function ($model) {
                    return ArraySpoiler::widget([
                        'id' => uniqid('ss'),
                        'data' => $model->targets,
                        'visibleCount' => 1,
                        'button' => [
                            'label' => '+' . ($model->count['targets'] - 1),
                            'popoverOptions' => [
                                'html' => true,
                            ],
                        ],
                        'formatter' => function ($item, $key) use ($model) {
                            static $index;
                            ++$index;

                            $value = Html::a(Html::encode($item->name), ['@target/view', 'id' => $item->id]);
                            if ($model->count['targets'] > count($model->targets) && $index === count($model->servers)) {
                                $text = Yii::t('hipanel:client', 'and {n} more', ['n' => $model->count['targets'] - count($model->targets)]);
                                $value .= ' ' . Html::a($text, Url::toSearch('target', ['client_id' => $model->id]), ['class' => 'border-bottom-dashed']);
                            }

                            return $value;
                        },
                    ]);
                },
            ],
            'contacts' => [
                'format' => 'raw',
                'label' => Yii::t('hipanel', 'Contacts'),
                'value' => function ($model) {
                    $num = $model->count['contacts'];
                    $url = Url::toSearch('contact', ['client_id' => $model->id]);

                    return $num ? Html::a(Yii::t('hipanel', '{0, plural, one{# contact} other{# contacts}}', $num), $url) : '';
                },
            ],
            'accounts_count' => [
                'format' => 'raw',
                'label' => Yii::t('hipanel', 'Accounts'),
                'value' => function ($model) {
                    $num = $model->count['accounts'];
                    $url = Url::toSearch('account', ['client_id' => $model->id]);

                    return $num ? Html::a(Yii::t('hipanel', '{0, plural, one{# account} other{# accounts}}', $num), $url) : '';
                },
            ],
            'hosting' => [
                'format' => 'raw',
                'label' => Yii::t('hipanel', 'Hosting'),
                'value' => function ($model) {
                    $res = '';
                    $num = $model->count['accounts'];
                    $url = Url::toSearch('account', ['client_id' => $model->id]);
                    $res .= $num ? Html::a(Yii::t('hipanel', '{0, plural, one{# account} other{# accounts}}', $num), $url) : '';
                    $num = $model->count['hdomains'];
                    $url = Url::toSearch('hdomain', ['client_id' => $model->id]);
                    $res .= $num ? Html::a(Yii::t('hipanel', '{0, plural, one{# domain} other{# domains}}', $num), $url) : '';
                    $num = $model->count['dbs'];
                    $url = Url::toSearch('db', ['client_id' => $model->id]);
                    $res .= $num ? Html::a(Yii::t('hipanel', '{0, plural, one{# database} other{# databases}}', $num), $url) : '';

                    return $res;
                },
            ],
            'messengers' => [
                'format' => 'raw',
                'label' => Yii::t('hipanel:client', 'Messengers'),
                'value' => function ($model) {
                    return $model->contact->messengers;
                },
            ],
            'registered_and_last_update' => [
                'format' => 'raw',
                'label' => Yii::t('hipanel:client', 'Registered / Last Update'),
                'value' => function ($model) {
                    $formatter = Yii::$app->formatter;

                    return Yii::t('hipanel:client', '{registered}<br>{last_update}', [
                        'registered' => $formatter->asDatetime($model->create_time),
                        'last_update' => $formatter->asDatetime($model->update_time),
                    ]);
                },
                'contentOptions' => [
                    'style' => 'white-space: nowrap;',
                ],
            ],
            'actions' => [
                'class' => MenuColumn::class,
                'menuClass' => ClientActionsMenu::class,
            ],
            'payment_ticket' => [
                'format' => 'raw',
                'label' => Yii::t('hipanel', 'Ticket'),
                'filter' => false,
                'value' => function ($model) {
                    if (!$model->payment_ticket_id) {
                        return '';
                    }

                    if ($model->balance >= 0 && $model->payment_ticket->state === 'opened') {
                        $class = 'text-red';
                    } elseif ($model->balance >= 0) {
                        $class = 'text-purple';
                    } elseif ($model->payment_ticket->state === 'closed') {
                        $class = 'text-red bold';
                    } elseif ($model->payment_ticket->status === 'wait_admin') {
                        $class = 'text-green';
                    } else {
                        $class = 'text-blue';
                    }

                    return Html::a($model->payment_ticket_id, Url::to(['@ticket/view', 'id' => $model->payment_ticket_id]), compact('class'));
                },
            ],
            'description' => [
                'class' => XEditableColumn::class,
                'label' => Yii::t('hipanel', 'Description'),
                'pluginOptions' => [
                    'url' => Url::to('@client/set-description'),
                ],
                'widgetOptions' => [
                    'linkOptions' => [
                        'data-type' => 'textarea',
                    ],
                ],
                'visible' => Yii::$app->user->can('support'),
            ],
            'last_deposit' => [
                'label' => Yii::t('hipanel:client', 'Last deposit'),
                'attribute' => 'last_deposit_time',
                'format' => 'date',
                'filter' => false,
            ],
            'language' => [
                'format' => 'raw',
                'value' => function ($model) {
                    $language = $model->getLanguage();

                    return Html::tag('span', strtoupper($language), ['class' => 'label bg-olive']) . '&nbsp;&nbsp;' . Yii::t('hipanel:client', $language);
                },
                'filter' => false,
            ],
            'debt_depth' => [
                'filter' => false,
                'format' => 'raw',
                'value' => function ($model) {
                    if ($model->balance >= 0) {
                        return '';
                    }
                    if ($model->debt_depth === null || (int)$model->debt_depth > 1000) {
                        return Html::tag('span', Yii::t('hipanel:client', '&#8734;'), ['class' => 'text-red']);
                    }

                    return Html::tag('span', sprintf('%01.2f', "{$model->debt_depth}"), ['class' => 'text-blue']);
                },
            ],
            'lang' => [
                'format' => 'raw',
                'label' => Yii::t('hipanel', 'Language'),
                'value' => function ($model) {
                    return Html::tag('span', strtoupper($model->getLanguage()), ['class' => 'label bg-olive']);
                },
                'filter' => false,
            ],
            'sold_services' => [
                'format' => 'raw',
                'filter' => false,
                'label' => Yii::t('hipanel:client', 'SubType'),
                'value' => function ($model) {
                    foreach (json_decode($model->sold_services, true, 512, JSON_THROW_ON_ERROR) as $sold_service => $value) {
                        $sold_services[] = Html::tag('span', strtoupper(substr($sold_service, 0, 1)), ['class' => $value ? 'text-green text-bold' : 'text-red']);
                    }

                    return implode(' / ', $sold_services);
                },
            ],
            'assignments' => [
                'format' => 'raw',
                'filter' => false,
                'label' => Yii::t('hipanel:client', 'Assignments'),
                'value' => function (Client $model): string {
                    $html = '';
                    foreach ($model->assignments as $assignment) {
                        $typeLabel = Yii::t('hipanel', Inflector::titleize($assignment->type));
                        $html .= "<b>$typeLabel</b>: ";
                        if ($assignment->isInherited()) {
                            $route = ['@tariffprofile/view', 'id' => Yii::$app->user->id];
                            $html .= Html::a(Yii::t('hipanel:client', 'Inherited from seller\'s defaults'), $route);
                        } else {
                            $html .= Html::encode($assignment->tariff_names ?? $assignment->profile_name);
                        }
                    }

                    return $html;
                },
            ],
            'referrals' => [
                'class' => DataColumn::class,
                'label' => Yii::t('hipanel:client', 'Referrals'),
                'value' => static fn(Client $client): ?string => Yii::t('hipanel:client', '{this_month} / {total}', [
                    'this_month' => $client->referral['history'][$thisMonthDt]['registered'] ?? 0,
                    'total' => $client->referral['totals']['referrals'] ?? 0,
                ]),
            ],
            'earnings' => [
                'class' => DataColumn::class,
                'label' => Yii::t('hipanel:client', 'Earning'),
                'value' => static function (Client $client) use ($formatter, $thisMonthDt): ?string {
                    $currency = $client->referral['totals']['currency'] ?? null;
                    $total = $client->referral['totals']['earnings'] ?? 0;
                    $thisMonth = $client->referral['history'][$thisMonthDt] ?? [];

                    return empty($total) && empty($thisMonth) ? '' : Yii::t('hipanel:client', '{this_month} / {total}', [
                        'this_month' => $formatter->asCurrency($thisMonth['earnings'] ?? 0, $thisMonth['currency'] ?? null),
                        'total' => $formatter->asCurrency($total, $currency),
                    ]);
                },
            ],
            'referral_tariff' => [
                'class' => DataColumn::class,
                'label' => Yii::t('hipanel:client', 'Referral tariff'),
                'format' => 'raw',
                'value' => static function(Client $client): ?string {
                    $tariff = Html::encode($client->referral['tariff']);
                    return $tariff && $client->referral['tariff_id']
                        ? Html::a($tariff, ['@plan/view', 'id' => $client->referral['tariff_id']])
                        : '';
                },
            ],
        ]);
    }
}

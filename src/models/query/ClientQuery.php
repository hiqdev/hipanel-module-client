<?php
/**
 * Client module for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-client
 * @package   hipanel-module-client
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2019, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\client\models\query;

use hiqdev\hiart\ActiveQuery;
use Yii;

class ClientQuery extends ActiveQuery
{
    public function withServers()
    {
        if (Yii::getAlias('@server', false)) {
            $this->andWhere([
                'with_servers_count' => 1,
                'with_hosting_count' => 1,
            ]);
            $this->joinWith('servers');
        }

        return $this;
    }

    public function withDomains()
    {
        if (Yii::getAlias('@domain', false)) {
            $this->andWhere(['with_domains_count' => 1]);
            $this->with([
                'domains' => function ($query) {
                    $query->limit(21);
                },
            ]);
        }

        return $this;
    }

    public function withContact()
    {
        $this->joinWith([
            'contact' => function ($query) {
                if (Yii::$app->user->can('document.read')) {
                    $query->joinWith('documents');
                }

                $query->joinWith('localizations');
            },
        ]);

        return $this;
    }

    public function withPurses()
    {
        $this->joinWith([
            'purses' => function ($query) {
                $query->joinWith('contact')->joinWith('requisite');
                if (Yii::$app->user->can('document.read')) {
                    $query->joinWith('documents');
                }
            },
        ]);

        return $this;
    }

    public function withPaymentTicket()
    {
        return $this->joinWith([
            'payment_ticket',
        ]);
    }
}

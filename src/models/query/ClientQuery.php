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
    public function withServers(): self
    {
        if (Yii::getAlias('@server', false)) {
            $this->joinWith('servers');
            $this->andWhere(['with_servers_count' => 1]);
        }

        return $this;
    }

    public function withServersCount(): self
    {
        if (Yii::getAlias('@server', false)) {
            $this->andWhere(['with_servers_count' => 1]);
        }

        return $this;
    }

    public function withHostingCount(): self
    {
        if (class_exists(\hipanel\modules\hosting\Module::class)) {
            $this->andWhere(['with_hosting_count' => 1]);
        }

        return $this;
    }

    public function withDomains(): self
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


    public function withDomainsCount(): self
    {
        if (Yii::getAlias('@domain', false)) {
            $this->andWhere(['with_domains_count' => 1]);
        }

        return $this;
    }

    public function withContact(): self
    {
        $this->joinWith([
            'contact' => function ($query) {
                if (Yii::getAlias('@document', false) && Yii::$app->user->can('document.read')) {
                    $query->joinWith('documents');
                }
                if (Yii::getAlias('@kyc', false)) {
                    $query->withKyc();
                }

                $query->joinWith('localizations');
            },
        ]);

        return $this;
    }

    public function withPurses(): self
    {
        $this->joinWith([
            'purses' => function ($query) {
                $query->joinWith('contact')->joinWith('requisite');
                if (Yii::getAlias('@document', false) && Yii::$app->user->can('document.read')) {
                    $query->joinWith('documents');
                }
            },
        ]);

        return $this;
    }

    public function withPaymentTicket(): self
    {
        return $this->joinWith([
            'payment_ticket',
        ]);
    }

    /**
     * @return $this
     */
    public function withProfit(): self
    {
        $this->joinWith('profit');
        $this->andWhere(['with_profit' => true]);

        return $this;
    }

    public function withReferral(): self
    {
        $this->addSelect('referral');

        return $this;
    }
}

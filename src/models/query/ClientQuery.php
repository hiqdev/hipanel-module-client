<?php

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
            $this->with([
                'servers' => function ($query) {
                    $query->limit(21);
                }
            ]);
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
                }
            ]);
        }

        return $this;
    }
}

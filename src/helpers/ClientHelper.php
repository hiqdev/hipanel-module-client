<?php

namespace hipanel\modules\client\helpers;

use hipanel\modules\client\grid\ClientGridView;
use hipanel\modules\client\models\Client;
use hipanel\modules\client\models\ClientSearch;
use hipanel\modules\finance\helpers\ResourceConfigurator;
use hipanel\modules\finance\models\ClientResource;
use Yii;

class ClientHelper
{

    public static function getReferralResourceConfig(): ResourceConfigurator
    {
        return ResourceConfigurator::build()
            ->setToObjectUrl('@client/resource-detail')
            ->setModelClassName(Client::class)
            ->setSearchModelClassName(ClientSearch::class)
            ->setGridClassName(ClientGridView::class)
            ->setResourceModelClassName(ClientResource::class)
            ->setSearchView('@vendor/hiqdev/hipanel-module-client/src/views/client/_search')
            ->setColumns(['referral']);
    }
}
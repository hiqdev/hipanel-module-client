<?php declare(strict_types=1);

namespace hipanel\modules\client\controllers;

use hipanel\modules\client\helpers\blacklist\BlacklistCategoryInterface;
use hipanel\modules\client\helpers\blacklist\WhitelistCategory;
use Yii;

class WhitelistController extends BlacklistController
{
    protected function getCategory(): BlacklistCategoryInterface
    {
        return new WhitelistCategory();
    }

    public function getViewPath()
    {
        return Yii::getAlias('@hipanel/modules/client/views/blacklist');
    }
}
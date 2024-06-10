<?php declare(strict_types=1);

namespace hipanel\modules\client\models\query;

use hipanel\modules\client\helpers\blacklist\WhitelistCategory;
use hiqdev\hiart\ActiveQuery;

class WhitelistQuery extends ActiveQuery
{
    public function init()
    {
        parent::init();
        $this->andWhere(['category' => (new WhitelistCategory())->getExternalValue()]);
    }
}
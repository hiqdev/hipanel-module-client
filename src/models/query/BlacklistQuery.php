<?php declare(strict_types=1);

namespace hipanel\modules\client\models\query;

use hipanel\modules\client\helpers\blacklist\BlacklistCategory;
use hiqdev\hiart\ActiveQuery;

class BlacklistQuery extends ActiveQuery
{
    public function init()
    {
        parent::init();
        $this->andWhere(['category' => (new BlacklistCategory())->getExternalValue()]);
    }
}
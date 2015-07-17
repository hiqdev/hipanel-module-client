<?php
/**
 * @link    http://hiqdev.com/hipanel-module-client
 * @license http://hiqdev.com/hipanel-module-client/license
 * @copyright Copyright (c) 2015 HiQDev
 */

namespace hipanel\modules\client\models;

use hipanel\helpers\ArrayHelper;
use hipanel\base\SearchModelTrait;

class ClientSearch extends Client
{
    use SearchModelTrait {
        searchAttributes as defaultSearchAttributes;
    }

    public function searchAttributes() {
        return ArrayHelper::merge($this->defaultSearchAttributes(), [
            'client_like',
        ]);
    }
}

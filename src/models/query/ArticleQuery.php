<?php

/*
 * Client module for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-client
 * @package   hipanel-module-client
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2016, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\client\models\query;

use hiqdev\hiart\ActiveQuery;
use Yii;

class ArticleQuery extends ActiveQuery
{
    public function ticketTemplates()
    {
        $this->andWhere([
            'realm' => 'ticket_template',
            'with_data' => true
        ]);

        return $this;
    }
}

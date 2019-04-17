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

class ArticleQuery extends ActiveQuery
{
    public function ticketTemplates()
    {
        $this->andWhere([
            'realm' => 'ticket_template',
            'with_data' => true,
        ]);

        return $this;
    }
}

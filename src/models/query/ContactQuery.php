<?php
/**
 * Client module for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-client
 * @package   hipanel-module-client
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2017, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\client\models\query;

use hiqdev\hiart\ActiveQuery;

class ContactQuery extends ActiveQuery
{
    public function withLocalizations()
    {
        $this->joinWith('localizations');
        $this->andWhere(['with_localizations' => true]);

        return $this;
    }

    public function withDocuments()
    {
        $this->joinWith('documents');
        $this->andWhere(['with_documents' => true]);

        return $this;
    }
}

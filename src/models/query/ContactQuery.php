<?php declare(strict_types=1);
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

class ContactQuery extends ActiveQuery
{
    public function init()
    {
        parent::init();
        $this->joinWith('bankDetails');
    }

    public function withLocalizations(): static
    {
        $this->joinWith('localizations');
        $this->andWhere(['with_localizations' => true]);

        return $this;
    }

    public function withDocuments(): static
    {
        $this->joinWith('documents');
        $this->andWhere(['with_documents' => true]);

        return $this;
    }

    public function withKyc(): static
    {
        $this->addSelect('kyc');
        $this->joinWith('kyc');

        return $this;
    }

    public function withBalances(): static
    {
        $this->addSelect('balances');

        return $this;
    }
}

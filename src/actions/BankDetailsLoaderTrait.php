<?php
declare(strict_types=1);

namespace hipanel\modules\client\actions;

use hipanel\modules\client\models\BankDetails;
use hiqdev\hiart\Collection;

trait BankDetailsLoaderTrait
{
    public function loadCollectionWithBankDetails(Collection $collection, array $requestData): Collection
    {
        $collectionData = $requestData[$collection->formName];
        $collectionData['setBankDetails'] = $this->extractBankDetails($requestData);
        $collection->load([$collectionData]);

        return $collection;
    }

    public function extractBankDetails(array $requestData): array
    {
        $defaultModel = new BankDetails(['scenario' => 'force-validate']);
        $rawBankDetailsData = array_filter($requestData, static fn($k) => str_contains($k, $defaultModel->formName()), ARRAY_FILTER_USE_KEY);
        $bankDetails = [];
        foreach ($rawBankDetailsData as $contactBankDetailsData) {
            foreach ($contactBankDetailsData as $datum) {
                $model = clone $defaultModel;
                $model->hydrateWithData($datum);
                if ($model->validate()) {
                    $bankDetails[] = $model->toArray();
                }
            }
        }

        return $bankDetails;
    }
}

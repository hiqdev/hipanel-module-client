<?php


namespace hipanel\modules\client\helpers;


use hipanel\modules\stock\helpers\ProfitColumns;
use Yii;

/**
 * Class TypedProfitColumns
 * @package hipanel\modules\client\helpers
 */
class TypedProfitColumns extends ProfitColumns
{
    /**
     * @inheritDoc
     */
    public static function getColumnNames(array $commonColumns = []): array
    {
        $columns = [];
        foreach (['rack', 'support', 'overuse'] as $attr) {
            foreach (['usd', 'eur'] as $cur) {
                $columns[] = "{$attr}_charge.$cur";
            }
        }

        return array_merge($commonColumns, $columns, parent::getColumnNames());
    }

    /**
     * @inheritDoc
     */
    public static function getLabels(): array
    {
        $labels = [];
        foreach ([
            'rack'     => 'rack',
            'support'  => 'support',
            'overuse'  => 'overuse',
        ] as $name => $label) {
            foreach (['usd', 'eur'] as $cur) {
                $labels["$name.$cur"] = Yii::t('hipanel.stock.order', $label.' Charge '.strtoupper($cur));
            }
        }

        return array_merge($labels, parent::getLabels());
    }
}

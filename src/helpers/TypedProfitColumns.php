<?php


namespace hipanel\modules\client\helpers;


use hipanel\modules\stock\helpers\ProfitColumns;
use Yii;

class TypedProfitColumns extends ProfitColumns
{
    protected static $profitAttribute = 'typedProfit';

    /**
     * @inheritDoc
     */
    public static function getColumnNames(array $commonColumns = []): array
    {
        $columns = [];
        foreach (['rack_unit_sum', 'support_time_sum', 'overuse_traf_sum'] as $attr) {
            foreach (['usd', 'eur'] as $cur) {
                $columns[] = "$attr.$cur";
            }
        }

        return array_merge($commonColumns, $columns);
    }

    /**
     * @inheritDoc
     */
    public static function getLabels(): array
    {
        $labels = [];
        foreach ([
            'rack_unit_sum'     => 'rack_unit_sum',
            'support_time_sum'    => 'support_time_sum',
            'overuse_traf_sum'     => 'overuse_traf_sum',
        ] as $name => $label) {
            foreach (['usd', 'eur'] as $cur) {
                $labels["$name.$cur"] = Yii::t('hipanel.stock.order', $label.' '.strtoupper($cur));
            }
        }

        return $labels;
    }
}

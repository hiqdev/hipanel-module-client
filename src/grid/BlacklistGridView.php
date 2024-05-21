<?php declare(strict_types=1);

namespace hipanel\modules\client\grid;

use hipanel\grid\BoxedGridView;
use hipanel\grid\MainColumn;

class BlacklistGridView extends BoxedGridView
{
    public function columns()
    {
        return array_merge(parent::columns(), [
            'name' => [
                'class' => MainColumn::class,
                'filterAttribute' => 'name_like',
                'extraAttribute' => 'name',
                'exportedColumns' => ['tags'],
            ],
        ]);
    }
}
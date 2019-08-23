<?php

namespace hipanel\modules\client\grid;

use hipanel\grid\BoxedGridView;
use hipanel\grid\MainColumn;

class AssignmentsGridView extends BoxedGridView
{
    public function columns()
    {
        return array_merge(parent::columns(), [
            'name' => [
                'class' => MainColumn::class,
            ],
            'post_date' => [
                'format' => 'date',
            ],
        ]);
    }
}

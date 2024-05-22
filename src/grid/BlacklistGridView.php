<?php declare(strict_types=1);

namespace hipanel\modules\client\grid;

use hipanel\grid\BoxedGridView;
use hipanel\grid\DataColumn;
use hipanel\grid\MainColumn;
use hipanel\grid\RefColumn;
use hipanel\modules\client\widgets\BlacklistState;
use hipanel\modules\client\widgets\BlacklistType;

class BlacklistGridView extends BoxedGridView
{
    public function columns(): array
    {
        return array_merge(parent::columns(), [
            'name' => [
                'class' => MainColumn::class,
                'attribute' => 'name',
                //'extraAttribute' => 'name',
            ],
            'type' => [
                'class' => RefColumn::class,
                'filterAttribute' => 'types',
                'filterOptions' => ['class' => 'narrow-filter'],
                'format' => 'raw',
                'gtype' => 'type,blacklisted',
                'i18nDictionary' => 'hipanel:client',
                'value' => function ($model) {
                    return BlacklistType::widget(compact('model'));
                },
            ],
            'state' => [
                'class' => RefColumn::class,
                'filterAttribute' => 'states',
                'filterOptions' => ['class' => 'narrow-filter'],
                'format' => 'raw',
                'gtype' => 'state,blacklisted',
                'i18nDictionary' => 'hipanel:client',
                'value' => function ($model) {
                    return BlacklistState::widget(compact('model'));
                },
            ],
            'create_time' => [
                'attribute' => 'create_time',
                'format' => 'datetime',
                'filter' => false,
                'label' => 'Created',
                'filterAttribute' => 'created',
                'sortAttribute' => 'created',
            ],
        ]);
    }
}

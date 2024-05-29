<?php declare(strict_types=1);

namespace hipanel\modules\client\grid;

use hipanel\grid\BoxedGridView;
use hipanel\grid\MainColumn;
use hipanel\grid\RefColumn;
use hipanel\modules\client\helpers\blacklist\BlacklistCategoryFactory;
use hipanel\modules\client\widgets\BlacklistShowMessage;
use hipanel\modules\client\widgets\BlacklistState;
use hipanel\modules\client\widgets\BlacklistType;
use Yii;

class BlacklistedGridView extends BoxedGridView
{
    public function columns(): array
    {
        $category = BlacklistCategoryFactory::getInstance(Yii::$app->request->get('category'));

        return array_merge(parent::columns(), [
            'name' => [
                'class' => MainColumn::class,
                'attribute' => 'name',
                'filterAttribute' => 'name_ilike',
            ],
            'type' => [
                'class' => RefColumn::class,
                'filterAttribute' => 'types',
                'filterOptions' => ['class' => 'narrow-filter'],
                'format' => 'raw',
                'gtype' => $category->getRefsName(),
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
            'show_message' => [
                'class' => MainColumn::class,
                'value' => function ($model) {
                    return BlacklistShowMessage::widget(compact('model'));
                },
                'filter' => false,
                'enableSorting' => false,
            ],
            'client' => [
                'class' => ClientColumn::class,
                'attribute' => 'client',
                'filter' => false,
                'enableSorting' => false,
            ],
            'message' => [
                'attribute' => 'message',
            ],
        ]);
    }
}

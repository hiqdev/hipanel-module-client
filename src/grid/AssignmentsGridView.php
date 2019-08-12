<?php

namespace hipanel\modules\client\grid;

use hipanel\grid\ActionColumn;
use hipanel\grid\BoxedGridView;
use hipanel\grid\MainColumn;
use Yii;
use yii\helpers\Html;

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
            'action' => [
                'class' => ActionColumn::class,
                'template' => '{view} {block} {delete}', // {state}
                'header' => Yii::t('hipanel', 'Actions'),
                'buttons' => [
                    'block' => function ($url, $model, $key) {
                        return Html::a('Close', ['block', 'id' => $model->id]);
                    },
                ],
            ],
        ]);
    }
}

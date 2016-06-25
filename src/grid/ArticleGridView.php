<?php

/*
 * Client module for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-client
 * @package   hipanel-module-client
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2016, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\client\grid;

use hipanel\grid\ActionColumn;
use hipanel\grid\BoxedGridView;
use hipanel\grid\MainColumn;
use Yii;
use yii\helpers\Html;

class ArticleGridView extends BoxedGridView
{
    public static function defaultColumns()
    {
        return [
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
        ];
    }
}

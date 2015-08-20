<?php
namespace hipanel\modules\client\grid;

use hipanel\grid\ActionColumn;
use hipanel\grid\BoxedGridView;
use hipanel\grid\MainColumn;
use hiqdev\combo\StaticCombo;
use Yii;
use yii\helpers\Html;

class ArticleGridView extends BoxedGridView
{
    public static function defaultColumns()
    {
        return [
            'article_name' => [
                'class' => MainColumn::className(),
            ],
            'post_date' => [
                'format' => 'date',
            ],

            'action' => [
                'class' => ActionColumn::className(),
                'template' => '{view} {block} {delete}', // {state}
                'header' => Yii::t('app', 'Actions'),
                'buttons' => [
                    'block' => function ($url, $model, $key) {
                        return Html::a('Close', ['block', 'id' => $model->id]);
                    },
                ],
            ],
        ];
    }
}

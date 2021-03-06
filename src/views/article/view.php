<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = Html::encode($model->article_name);
$this->params['breadcrumbs'][] = ['label' => 'News and articles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="event-view">

    <p>
        <?= Html::a(Yii::t('hipanel', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('hipanel', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data'  => [
                'confirm' => Yii::t('hipanel', 'Are you sure you want to delete this item?'),
                'method'  => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model'      => $model,
        'attributes' => [
            'id',
            'article_name',
            [
                'attribute' => 'data',
            ],
            [
                'attribute' => 'post_date',
                'format'    => ['date', 'yyyy-mm-dd'],
            ],
        ],
    ]) ?>

</div>

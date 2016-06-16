<?php

use hiqdev\combo\StaticCombo;

/**
 * @var \hipanel\widgets\AdvancedSearch
 */
?>
<div class="col-md-12" style="margin-top: 1em;">
    <div class="row">
        <div class="col-md-4 col-sm-6 col-xs-12">
            <?= $search->field('article_name') ?>
        </div>
        <div class="col-md-4 col-sm-6 col-xs-12">
            <?= $search->field('post_date') ?>
        </div>
        <div class="col-md-4 col-sm-6 col-xs-12">
            <?= $search->field('is_published')->widget(StaticCombo::class, [
                'data' => [
                    't' => Yii::t('app', 'Published'),
                    'f' => Yii::t('app', 'Unpublished'),
                ],
                'hasId' => true,
                'mutliple' => true,
            ]) ?>
        </div>
    </div>
</div>

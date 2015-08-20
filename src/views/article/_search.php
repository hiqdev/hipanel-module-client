<?php
use hiqdev\combo\StaticCombo;

?>
<div class="col-md-12" style="margin-top: 1em;">
    <div class="row">
        <div class="col-md-4">
            <?= $search->field('article_name') ?>
        </div>
        <div class="col-md-4">
            <?= $search->field('post_date') ?>
        </div>
        <div class="col-md-4">
            <?= $search->field('is_published')->widget(StaticCombo::classname(), [
                'data' => [
                    't' => Yii::t('app', 'Published'),
                    'f' => Yii::t('app', 'Unpublished'),
                ],
                'hasId' => true,
                'pluginOptions' => [
                    'select2Options' => [
                        'multiple' => false,
                    ],
                ],
            ]) ?>
        </div>
    </div>
</div>

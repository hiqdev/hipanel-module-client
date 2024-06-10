<?php

use hipanel\widgets\AdvancedSearch;
use hiqdev\combo\StaticCombo;

/**
 * @var AdvancedSearch $search
 * @var array $types
 */
?>

<div class="col-md-4 col-sm-6 col-xs-12">
    <?= $search->field('name_ilike') ?>
</div>

<div class="col-md-4 col-sm-6 col-xs-12">
    <?= $search->field('types')->widget(StaticCombo::class, [
        'data' => $types,
        'hasId' => true,
        'multiple' => true,
    ]) ?>
</div>

<div class="col-md-4 col-sm-6 col-xs-12">
    <?= $search->field('message') ?>
</div>
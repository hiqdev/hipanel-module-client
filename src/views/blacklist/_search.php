<?php

use hipanel\widgets\AdvancedSearch;
use hiqdev\combo\StaticCombo;

/**
 * @var AdvancedSearch $search
 * @var array $types
 * @var array $states
 */
?>

<div class="col-md-4 col-sm-6 col-xs-12">
    <?= $search->field('name_like') ?>
</div>

<div class="col-md-4 col-sm-6 col-xs-12">
    <?= $search->field('types')->widget(StaticCombo::class, [
        'data' => $types,
        'hasId' => true,
        'multiple' => true,
    ]) ?>
</div>

<div class="col-md-4 col-sm-6 col-xs-12">
    <?= $search->field('states')->widget(StaticCombo::class, [
        'data' => $states,
        'hasId' => true,
        'multiple' => true,
    ]) ?>
</div>
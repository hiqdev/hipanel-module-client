<?php

use hipanel\modules\client\widgets\combo\SellerCombo;
use hipanel\widgets\AdvancedSearch;
use hipanel\modules\client\widgets\combo\ClientCombo;

?>

<?php $form = AdvancedSearch::begin(compact('model')) ?>

<div class="col-md-6">
    <?= $form->field('client_name') ?>
    <?= $form->field('email') ?>
</div>

<div class="col-md-6">
    <?= $form->field('client_id')->widget(ClientCombo::classname()) ?>
    <?= $form->field('seller_id')->widget(SellerCombo::classname()) ?>
</div>

<?php $form::end() ?>

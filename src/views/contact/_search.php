<?php

use hipanel\modules\client\widgets\combo\SellerCombo;
use hipanel\modules\client\widgets\combo\ClientCombo;

?>

<div class="col-md-6">
    <?= $search->field('client_name') ?>
    <?= $search->field('email') ?>
</div>

<div class="col-md-6">
    <?= $search->field('client_id')->widget(ClientCombo::classname()) ?>
    <?= $search->field('seller_id')->widget(SellerCombo::classname()) ?>
</div>

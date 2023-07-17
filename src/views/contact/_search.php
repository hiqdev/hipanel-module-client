<?php

use hipanel\modules\client\widgets\combo\ClientCombo;
use hipanel\modules\client\widgets\combo\SellerCombo;
use hipanel\widgets\AdvancedSearch;
use hipanel\widgets\TagsInput;

/**
 * @var AdvancedSearch $search
 */
?>

<div class="col-md-4 col-sm-6 col-xs-12">
    <?= $search->field('name_like') ?>
</div>

<div class="col-md-4 col-sm-6 col-xs-12">
    <?= $search->field('email_like') ?>
</div>

<?php if (Yii::$app->user->can('support')) : ?>
    <div class="col-md-4 col-sm-6 col-xs-12">
        <?= $search->field('client_id')->widget(ClientCombo::class) ?>
    </div>

    <div class="col-md-4 col-sm-6 col-xs-12">
        <?= $search->field('seller_id')->widget(SellerCombo::class) ?>
    </div>
<?php endif ?>

<?php if (Yii::$app->user->can('contact.update')) : ?>
    <div class="col-md-4 col-sm-6 col-xs-12">
        <?= $search->field('tags')->widget(TagsInput::class) ?>
    </div>
<?php endif ?>

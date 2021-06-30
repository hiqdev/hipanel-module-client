<?php

use hipanel\widgets\CustomAttributesViewer;
use hipanel\modules\client\models\Client;

/**
 * @var Client $model
 */

?>

<?php if (Yii::$app->user->can('access-subclients')) : ?>
    <div class="box-header">
        <h4 class="box-title">
            <?= Yii::t('hipanel:client', 'Additional information') ?>
        </h4>
    </div>
    <div class="box-footer no-padding">
        <?= CustomAttributesViewer::widget(['owner' => $model]) ?>
    </div>
<?php endif ?>


<?php

use hipanel\modules\client\widgets\combo\ClientCombo;

?>

<div class="client-switcher" style="margin-bottom: 1em;">
    <?= ClientCombo::widget([
        'model' => new \yii\base\DynamicModel(['login']),
        'attribute' => 'login',
        'hasId' => true,
        'formElementSelector' => '.client-switcher',
        'pluginOptions' => [
            'select2Options' => [
                'placeholder' => Yii::t('hipanel:client', 'Fast navigation to another client'),
                'allowClear' => false,
            ],
        ],
    ]) ?>
</div>

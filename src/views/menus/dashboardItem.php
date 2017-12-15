<?php

use hipanel\modules\client\models\ClientSearch;
use hipanel\modules\dashboard\widgets\SmallBox;
use hipanel\modules\dashboard\widgets\SearchForm;
use yii\helpers\Html;
use yii\helpers\Url;

?>
<div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
    <?php $box = SmallBox::begin([
        'boxTitle' => Yii::t('hipanel', 'Clients'),
        'boxIcon' => 'fa-users',
        'boxColor' => SmallBox::COLOR_FUCHSIA,
    ]) ?>
    <?php $box->beginBody() ?>
    <br>
    <br>
    <?= SearchForm::widget([
        'formOptions' => [
            'id' => 'client-search',
            'action' => Url::to('@client/index'),
        ],
        'model' => new ClientSearch(),
        'attribute' => 'login_ilike',
        'buttonColor' => SmallBox::COLOR_FUCHSIA,
    ]) ?>
    <?php $box->endBody() ?>
    <?php $box->beginFooter() ?>
    <?= Html::a(Yii::t('hipanel', 'View') . $box->icon(), '@client/index', ['class' => 'small-box-footer']) ?>
    <?php $box->endFooter() ?>
    <?php $box::end() ?>
</div>

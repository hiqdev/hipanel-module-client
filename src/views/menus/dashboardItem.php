<?php

use hipanel\modules\client\models\ClientSearch;
use hipanel\modules\dashboard\widgets\ObjectsCountWidget;
use hipanel\modules\dashboard\widgets\SearchForm;
use hipanel\modules\dashboard\widgets\SmallBox;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var string $route
 * @var int $ownCount
 * @var string $entityName
 */

?>

<div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
    <?php $box = SmallBox::begin([
        'boxTitle' => Yii::t('hipanel', 'Clients'),
        'boxIcon' => 'fa-users',
        'boxColor' => SmallBox::COLOR_FUCHSIA,
    ]) ?>
    <?php $box->beginBody() ?>
    <?= ObjectsCountWidget::widget(['route' => $route, 'ownCount' => $ownCount, 'entityName' => $entityName]) ?>
    <?= SearchForm::widget([
        'formOptions' => [
            'id' => 'client-search',
            'action' => Url::to('@client/index'),
        ],
        'model' => new ClientSearch(),
        'attribute' => 'login_like',
        'buttonColor' => SmallBox::COLOR_FUCHSIA,
    ]) ?>
    <?php $box->endBody() ?>
    <?php $box->beginFooter() ?>
    <?= Html::a(Yii::t('hipanel', 'View') . $box->icon(), '@client/index', ['class' => 'small-box-footer']) ?>
    <?php if (Yii::$app->user->can('client.create')) : ?>
        <?= Html::a(Yii::t('hipanel', 'Create') . $box->icon('fa-plus'), '@client/create', ['class' => 'small-box-footer']) ?>
    <?php endif ?>
    <?php $box->endFooter() ?>
    <?php $box::end() ?>
</div>

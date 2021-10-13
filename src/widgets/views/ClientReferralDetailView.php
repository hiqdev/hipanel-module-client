<?php

use hipanel\helpers\Url;
use hipanel\modules\client\models\Client;
use hipanel\widgets\AjaxModalWithTemplatedButton;
use yii\bootstrap\Modal;
use yii\helpers\Html;

/** @var Client $client */

$dt = (new DateTime())->modify('first day of this month')->format('Y-m-d 00:00:00');
$formatter = Yii::$app->formatter;
$referral = $client->referral;
?>

<?php if (isset($referral['tariff_id'])) : ?>
    <div class="box box-default">
        <div class="box-header">
            <h4 class="box-title">
                <?= Yii::t('hipanel:client', 'Referrals') ?>
            </h4>
            <div class="box-tools pull-right">
                <?= AjaxModalWithTemplatedButton::widget([
                    'ajaxModalOptions' => [
                        'bulkPage' => false,
                        'usePost' => true,
                        'id' => 'client-set-referral-tariff',
                        'scenario' => 'sell',
                        'actionUrl' => ['set-referral-tariff', 'id' => $client->id],
                        'handleSubmit' => Url::toRoute(['set-referral-tariff']),
                        'size' => Modal::SIZE_SMALL,
                        'header' => Html::tag('h4', Yii::t('hipanel:client', 'Set referral tariff'), ['class' => 'modal-title']),
                        'toggleButton' => [
                            'tag' => 'button',
                            'label' => Yii::t('hipanel:client', 'Set referral tariff'),
                            'class' => 'btn bg-default btn-xs',
                        ],
                    ],
                    'toggleButtonTemplate' => '{toggleButton}',
                ]) ?>
            </div>
        </div>
        <div class="box-body no-padding">
            <table class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th colspan="1">&nbsp;</th>
                    <th><?= Yii::t('hipanel:client', 'This month') ?></th>
                    <th><?= Yii::t('hipanel:client', 'Total') ?></th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <th><?= Yii::t('hipanel:client', 'Referrals') ?></th>
                    <td><?= $referral['history'][$dt]['registered'] ?? 0 ?></td>
                    <td class="text-success"><?= $referral['totals']['referrals'] ?? 0 ?></td>
                </tr>
                <tr>
                    <th><?= Yii::t('hipanel:client', 'Earning') ?></th>
                    <td><?= $formatter->asCurrency($referral['history'][$dt]['earnings'] ?? 0, $referral['history'][$dt]['currency'] ?? null) ?></td>
                    <td class="text-success"><?= $formatter->asCurrency($referral['totals']['earnings'] ?? 0, $referral['totals']['currency'] ?? null) ?></td>
                </tr>
                <tr>
                    <th><?= Yii::t('hipanel:client', 'Referral tariff') ?></th>
                    <td colspan="2"><?= Html::a($client->referral['tariff'], ['@plan/view', 'id' => $client->referral['tariff_id']]) ?></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
<?php endif ?>
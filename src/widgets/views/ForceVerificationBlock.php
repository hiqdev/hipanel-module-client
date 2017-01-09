<?php

use yii\helpers\Html;
use hipanel\widgets\Box;
use hipanel\modules\client\widgets\Verification;

/**
 * @var \hipanel\modules\client\models\Contact $model
 * @var string $title
 * @var string $scenrio
 * @var string $submitUrl
 * @var array $attributes
 */

?>
<?php $box = Box::begin(['renderBody' => false]) ?>
    <?php $box->beginHeader() ?>
        <?= $box->renderTitle($title) ?>
    <?php $box->endHeader() ?>
    <?php $box->beginBody() ?>
        <table class='table table-striped table-borderetable table-striped table-bordered'>
            <tbody>
                <?php foreach ($attributes as $attribute) : ?>
                    <?php if (!empty($model->$attribute)) : ?>
                        <tr>
                            <th><?= $model->getAttributeLabel($attribute) ?></th>
                            <td>
                                <?= Verification::widget([
                                    'model' => $model->getVerification($attribute),
                                    'scenario' => $scenario,
                                    'submitUrl' => $submitUrl,
                                ]) ?>
                            </td>
                        </tr>
                    <?php endif ?>
                <?php endforeach ?>
            </tbody>
        </table>
    <?php $box->endBody() ?>
<?php $box->end() ?>

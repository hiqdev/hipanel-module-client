<?php

use hipanel\widgets\Box;

/**
 * @var \hipanel\modules\client\models\Contact
 * @var string $title
 * @var \hipanel\modules\client\widgets\verification\ForceVerificationWidgetInterface[] $widgets
 */
?>
<?php $box = Box::begin(['renderBody' => false, 'bodyOptions' => ['class' => 'no-padding']]) ?>
    <?php $box->beginHeader() ?>
        <?= $box->renderTitle($title) ?>
    <?php $box->endHeader() ?>
    <?php $box->beginBody() ?>
        <table class='table table-striped table-bordered'>
            <tbody>
                <?php foreach ($widgets as $widget) : ?>
                    <?php if ($widget->canBeRendered()) : ?>
                        <tr>
                            <th><?= $widget->getLabel() ?></th>
                            <td><?= $widget->getWidget() ?></td>
                        </tr>
                    <?php endif ?>
                <?php endforeach ?>
            </tbody>
        </table>
    <?php $box->endBody() ?>
<?php $box->end() ?>

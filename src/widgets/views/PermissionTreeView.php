<?php

/** @var string $tableId */

$this->registerCss("
    #$tableId table { background-color: #FFFFFF; }
    #$tableId thead { background-color: #FFFFFF; } 
    #$tableId tr > td:first-child { white-space: nowrap; } 
");
?>

<table id="<?= $tableId ?>" class="table table-condensed">
    <thead>
    <tr>
        <th><?= Yii::t('hipanel', 'Name') ?></th>
        <th><?= Yii::t('hipanel', 'Description') ?></th>
    </tr>
    </thead>
    <tbody>
    </tbody>
</table>

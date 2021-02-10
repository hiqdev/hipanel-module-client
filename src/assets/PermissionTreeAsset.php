<?php

namespace hipanel\modules\client\assets;

use hipanel\assets\TreeTable;
use yii\web\AssetBundle;
use yii\web\JqueryAsset;

class PermissionTreeAsset extends AssetBundle
{
    public $sourcePath = '@npm/jquery-treetable';

    public $css = [
        'css/jquery.treetable.theme.default.css',
    ];

    public $depends = [
        JqueryAsset::class,
        TreeTable::class,
    ];
}

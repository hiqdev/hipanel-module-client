<?php

use hipanel\modules\client\models\Permission;
use hipanel\modules\client\widgets\PermissionTree;
use yii\helpers\Html;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $assignUrl string */
/* @var $revokeUrl string */
/* @var $opts string */
/** @var Permission $model */

$userName = $model->client->login;
$this->title = Yii::t('hipanel:client', 'Permissions for : {0}', $userName);
$this->params['breadcrumbs'][] = ['label' => Yii::t('hipanel:client', 'Clients'), 'url' => ['@client/index']];
$this->params['breadcrumbs'][] = ['label' => $userName, 'url' => ['@client/view', 'id' => $model->clientId]];
$this->params['breadcrumbs'][] = Yii::t('hipanel:client', 'Assign permissions');

$this->registerJsVar('_opts', ['items' => $model->getItems()], View::POS_BEGIN);
$this->registerJs(<<<'JS'
function updateItems(response) {
    // todo
    // _opts.items.available = response.available;
    // _opts.items.assigned = response.assigned;
    search('available');
    search('assigned');
}

$('.btn-assign').click(function () {
    const $this = $(this);
    const target = $this.data('target');
    const url = $this.data('url');
    const items = $('select.list[data-target="' + target + '"]').val();
    let data = {};

    if (items && items.length) {
        data[target] = items;
        // $.post(url, {items: items}, function (r) {
        //     updateItems(r);
        // });
    }

    return false;
});

$('.search[data-target]').keyup(function () {
    search($(this).data('target'));
});

$('.btn.clear').click(function () {
    const input = $(this).parents(".input-group").find(".search[data-target]");
    input.val('');
    search(input.data('target'));
});

function search(target) {
    const $list = $('select.list[data-target="' + target + '"]');
    $list.html('');
    const q = $('.search[data-target="' + target + '"]').val();

    const groups = {
        role: [$('<optgroup label="Roles">'), false],
        permission: [$('<optgroup label="Permission">'), false],
        route: [$('<optgroup label="Routes">'), false],
    };
    $.each(_opts.items[target], function (name, group) {
        if (name.indexOf(q) >= 0) {
            $('<option>').text(name).val(name).appendTo(groups[group][0]);
            groups[group][1] = true;
        }
    });
    $.each(groups, function () {
        if (this[1]) {
            $list.append(this[0]);
        }
    });
}

// initial
search('available');
search('assigned');
JS
);
?>

<div class="row">
    <div class="col-lg-5">
        <div class="row">
            <div class="col-md-12">
                <div class="input-group">
                    <input type="text" class="form-control search" data-target="available"
                           placeholder="<?= Yii::t('hipanel:client', 'Search for available') ?>"/>
                    <span class="input-group-btn"><button class="btn btn-default clear" type="button"><i
                                    class="fa fa-times fa-fw"></i></button></span>
                </div>
                <br/>
                <select multiple size="10" class="form-control list" data-target="available"></select>
            </div>
            <div class="col-md-12">
                <?= PermissionTree::widget(['model' => $model, 'selector' => 'select[data-target=available]']) ?>
            </div>
        </div>
    </div>
    <div class="col-lg-2">
        <div class="move-buttons">
            <?= Html::button('&gt;&gt;', [
                'class' => 'btn btn-success btn-block btn-assign',
                'data-target' => 'available',
                'data-url' => $assignUrl,
                'title' => Yii::t('hipanel:client', 'Assign'),
            ]) ?>
            <?= Html::button('&lt;&lt;', [
                'class' => 'btn btn-danger btn-block btn-assign',
                'data-target' => 'assigned',
                'data-url' => $revokeUrl,
                'title' => Yii::t('hipanel:client', 'Remove'),
            ]) ?>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="row">
            <div class="col-md-12">
                <div class="input-group">
                    <input type="text" class="form-control search" data-target="assigned"
                           placeholder="<?= Yii::t('hipanel:client', 'Search for assigned') ?>"/>
                    <span class="input-group-btn">
                        <button class="btn btn-default clear" type="button"><i class="fa fa-times fa-fw"></i></button>
                    </span>
                </div>
                <br/>
                <select multiple size="10" class="form-control list" data-target="assigned"></select>
            </div>
            <div class="col-md-12">
                <?= PermissionTree::widget(['model' => $model, 'selector' => 'select[data-target=assigned]']) ?>
            </div>
        </div>
    </div>
</div>
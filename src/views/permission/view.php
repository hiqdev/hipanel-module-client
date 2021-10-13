<?php

use hipanel\modules\client\models\Permission;
use hipanel\modules\client\widgets\PermissionTree;
use yii\helpers\Html;
use yii\helpers\Url;
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
const saveBtn = document.querySelector('.btn-save');
var confirmIt = e => {
    if (!confirm(saveBtn.dataset.confirmText)) {
        e.preventDefault();

        return false;
    }
    const assigned = Array.prototype.slice.call(document.querySelectorAll("select.list[data-target=assigned] option"), 0).map((v) => v.value);
    const inputs = $(':input');
    inputs.attr('disabled', 'disabled');
    $(saveBtn).button('loading');
    $.post(saveBtn.dataset.assignUrl, {roles: assigned}, resp => {
        if (resp.success === true) {
            hipanel.notify.success(resp.message);
        } else {
            hipanel.notify.error(resp.message);
        }
    }).fail(resp => {
        hipanel.notify.error('Something went wrong');
        console.log(resp);
    }).always(() => {
        inputs.attr('disabled', false);
        $(saveBtn).button('reset');
    });
};
saveBtn.addEventListener('click', confirmIt, false);

$('.btn-assign').click(function () {
    const $this = $(this);
    const target = $this.data('target');
    const items = $('select.list[data-target="' + target + '"]').val();
    for (let idx = 0; idx < items.length; idx++) {
      if (target === "available") {
        _opts.items['assigned'][items[idx]] = _opts.items["available"][items[idx]];
      }
      if (target === "assigned") {
        delete _opts.items['assigned'][items[idx]];
      }
    }
    search('assigned');

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
            <?= Html::button(Yii::t('hipanel:client', 'Save changes'), [
                'class' => 'btn btn-success btn-block btn-save',
                'style' => ['margin-bottom' => '6em'],
                'data' => [
                    'assign-url' => Url::to(['/client/permission/assign', 'id' => $model->clientId]),
                    'confirm-text' => Yii::t('hipanel', 'Are you sure you want to assign this roles and permissions?'),
                    'loading-text' => '<i class="fa fa-fw fa-refresh fa-spin"></i>',
                ],
            ]) ?>
            <?= Html::button('&gt;&gt;', [
                'class' => 'btn btn-info btn-block btn-assign',
                'data-target' => 'available',
                'title' => Yii::t('hipanel:client', 'Assign'),
            ]) ?>
            <?= Html::button('&lt;&lt;', [
                'class' => 'btn btn-danger btn-block btn-assign',
                'data-target' => 'assigned',
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
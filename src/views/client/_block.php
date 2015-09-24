<?php
use hipanel\helpers\Url;
use yii\helpers\Html;
use hipanel\widgets\ModalButton;
use hipanel\modules\client\controllers\ClientController;
?>
<?php
$modalButton = ModalButton::begin([
    'model'     => $model,
    'scenario'  => $model->state == 'blocked' ? 'disable-block' : 'enable-block',
    'button'    => [
        'label'                 => $showButtom === false ? '' : ($model->state == 'blocked'
            ? '<i class="fa ion-unlocked"></i>' . Yii::t('app', 'Disable block')
            : '<i class="fa ion-locked"></i>' . Yii::t('app', 'Enable block')
    ),],
    'form'      => [
        'enableAjaxValidation'  => true,
        'validationUrl'         => Url::toRoute(['validate-form', 'scenario' =>  $model->state == 'blocked' ? 'disable-block' : 'enable-block']),
    ],
    'modal'     => [
        'header'                => Html::tag(
            'h4', Yii::t('app', 'Confirm {state, plural, =0{block} other{unblock}} client {client}', ['state' => $model->state == 'blocked','client' => $model->login ])
        ),
        'headerOptions'         => ['class' => $model->state == 'blocked' ? 'label-info' : 'label-danger'],
        'footer'                => [
            'label'                 => Yii::t('app', $model->state == 'blocked' ? 'Disable block' : 'Enable block'),
            'data-loading-text'     => Yii::t('app', $model->state == 'blocked' ? 'Disabling block...'  :'Enabling block...'),
            'class'                 => $model->state == 'blocked' ? 'btn btn-info' : 'btn btn-danger',
        ]
    ]
]); ?>

<?php echo $modalButton->form->field($model, 'type')->dropDownList($reasons); ?>
<?php echo $modalButton->form->field($model, 'comment'); ?>

<?php $modalButton->end(); ?>


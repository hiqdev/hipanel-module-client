<?php

use yii\helpers\Html;

$this->title = Yii::t('app', 'Change {contactType} contact for {domainName}', ['contactType' => Html::encode($contactType), 'domainName' => Html::encode($domainName)]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Contact'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

echo $this->render('_form', compact('model', 'domainName', 'domainId', 'contactType'));

<?php

use hipanel\modules\client\models\Contact;
use yii\bootstrap\Html;

/**
 * @var \yii\web\View $this
 * @var Contact $model
 * @var \yii\bootstrap\ActiveForm $form
 */

?>

<?php \yii\bootstrap\Modal::begin([
    'id' => 'gdpr-consent-modal',
    'header' => '<h4>Policy of storage and usage of personal data changes</h4>',
    'size' => \yii\bootstrap\Modal::SIZE_LARGE,
    'options' => ['style' => ['z-index' => 2000]],
]) ?>

<h3>Dear user!</h3>

<p>
    The European Union (EU) General Data Protection Regulation (GDPR) that changes the policy of
    storage and usage of personal data comes into force on May 25th. Please provide us with the following personal data.
    This is the only information we are going to use in each case under or in relation to this document.
</p>

<ul>
    <li>personal name, phone number, private address;</li>
    <li>email address, skype address and other addresses/contact details/identifiers used in electronic
        communications;
    </li>
    <li>TIN/Identity number (including documents and information that certify the individual's identity);</li>
    <li>information about the products or services that you purchased or consider purchasing from Us, IP addresses
        assigned by Us, customer ID or any other information related to your account;
    </li>
    <li>information about enquiries made to us to resolve a technical or administrative query;</li>
</ul>

<p>We are going to use your personal data solely for the purposes listed below:</p>

<ul>
    <li>to process of orders and provision of services;</li>
    <li>to allow the technical support personnel assist you if needed to allow the technical support personnel manage
        Our infrastructure, systems, databases and other applications or tools;
    </li>
    <li>to perform any of the features on Our website, e.g. conducting surveys, mail outs;</li>
    <li>to improve the quality of Our website, Our products and services;</li>
    <li>to develop or add Our additional products and services;</li>
    <li>to conduct statistical analysis of the usage of Our website, applications and tools that are accessed via the
        website as well as to conduct market research and sales research;
    </li>
    <li>to ensure security of persons and to find and prevent fraud;</li>
    <li>for law compliance purposes.</li>
</ul>

<p>
    We do not provide your Personal Data to third parties, except cases regulated in accordance with this Privacy
    Policy,
    any agreement we have with you or as required by law. You consent to Us using any Personal Data that We collect for
    any one of the purposes stated in this <?= Html::a('Privacy Policy', Yii::$app->params['legals']['privacy_policy']) ?>
</p>

<hr/>

<p>
    <?= $form->field($model, 'privacy_policy')->checkbox()->label(
        'I agree to the ' . Html::a('Privacy Policy', Yii::$app->params['legals']['privacy_policy'])
    ) ?>
    <?= $form->field($model, 'gdpr_agreement')->checkbox()->label(
        'I consent to provide any Personal Data for the purposes indicated in this '
            . Html::a('Privacy Policy', Yii::$app->params['legals']['privacy_policy'])
    ) ?>
</p>

<?= Html::button(Yii::t('hipanel', 'Go check and actualize my contact data'),
    ['class' => 'btn btn-success gdpr-acception']); ?>

<?php \yii\bootstrap\Modal::end() ?>


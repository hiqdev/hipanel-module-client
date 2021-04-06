<?php

namespace hipanel\modules\client\widgets\combo;

class PartnerCombo extends ClientCombo
{
    /**
     * {@inheritdoc}
     */
    public $type = 'client/partner';

    /**
     * {@inheritdoc}
     */
    public $clientType = ['partner'];

    /**
     * {@inheritdoc}
     */
    public $primaryFilter = 'login_like';
}

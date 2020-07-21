<?php

namespace hipanel\modules\client\widgets\combo;

class RefererCombo extends ClientCombo
{
    /**
     * {@inheritdoc}
     */
    public $type = 'client/referer';

    /**
     * {@inheritdoc}
     */
    public $primaryFilter = 'login_like';
}

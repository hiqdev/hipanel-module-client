<?php

/*
 * Client Plugin for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-client
 * @package   hipanel-module-client
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2014-2015, HiQDev (https://hiqdev.com/)
 */

namespace hipanel\modules\client\models;

class Mailing extends \yii\db\ActiveRecord
{
    public $from;
    public $subject;
    public $message;
    public $types;

    public function rules()
    {
        return [
            [['from','subject','message','types'],'required'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'from'    => 'From',
            'subject' => 'Subject',
            'message' => 'Message',
            'types'   => 'Type',
        ];
    }
}

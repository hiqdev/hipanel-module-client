<?php
/**
 * Client module for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-client
 * @package   hipanel-module-client
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2017, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\client\models;

use Yii;

class ClientTicketSettings extends \hipanel\base\Model
{
    use \hipanel\base\ModelTrait;

    public static function joinIndex()
    {
        return 'ticket_settings';
    }

    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['client'], 'safe'],
            // Ticket settings
            [['ticket_emails'], 'string', 'max' => 128, 'on' => 'ticket-settings'],
            [['ticket_emails'], 'email', 'on' => 'ticket-settings'],
        ];
    }

    public function attributeLabels()
    {
        return $this->mergeAttributeLabels([
            'ticket_emails' => Yii::t('hipanel:ticket', 'Email for tickets'),
            'send_message_text' => Yii::t('hipanel:ticket', 'Send message text'),
        ]);
    }
}

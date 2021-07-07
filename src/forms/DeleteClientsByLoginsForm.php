<?php

declare(strict_types=1);

namespace hipanel\modules\client\forms;

use hipanel\base\Model;
use hipanel\helpers\ArrayHelper;
use hipanel\modules\client\models\Client;
use Yii;

final class DeleteClientsByLoginsForm extends Model
{
    public function rules()
    {
        return [
            ['logins', 'string'],
            ['logins', 'required'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'logins' => Yii::t('hipanel:client', 'Logins'),
        ];
    }

    public function getClients(): array
    {
        $logins = ArrayHelper::htmlEncode(preg_split('/[\s,;]+/', trim($this->logins)));

        return $this->findClients($logins);
    }

    private function findClients(array $logins): array
    {
        return Yii::$app->cache->getOrSet([__CLASS__, __METHOD__, $logins], fn(): array => Client::find()->where([
            'logins' => $logins,
        ])->limit(-1)->all(), 3600);
    }
}

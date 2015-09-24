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

use Yii;

class Client extends \hipanel\base\Model
{
    use \hipanel\base\ModelTrait;

    public function rules()
    {
        return [
            [['id', 'seller_id', 'state_id', 'type_id', 'tariff_id', 'profile_id'], 'integer'],
            [['login', 'seller', 'state', 'type', 'tariff', 'profile'], 'safe'],
            [['state_label', 'type_label'], 'safe'],
            [['balance', 'credit'], 'number'],
            [['count', 'confirm_url', 'language', 'comment', 'name', 'contact', 'currency'], 'safe'],
            [['create_time', 'update_time'], 'date'],
            [['id', 'credit'], 'required', 'on' => 'set-credit'],
            [['id', 'type', 'comment'], 'required', 'on' => ['set-block', 'enable-block', 'disable-block']],
            [['id', 'language'], 'required', 'on' => 'set-language'],
            [['id', 'seller_id'], 'required', 'on' => 'set-seller'],

            [['password', 'client', 'seller_id', 'email'], 'required', 'on' => ['create', 'update']],
            [['email'], 'email', 'on' => ['create', 'update']],
        ];
    }

    public function attributeLabels()
    {
        return $this->mergeAttributeLabels([
            'client_like' => Yii::t('app', 'Client'),
            'seller_like' => Yii::t('app', 'Reseller'),
            'create_time' => Yii::t('app', 'Registered'),
            'update_time' => Yii::t('app', 'Last update'),
        ]);
    }

    public static function canBeSelf ($model) {
        return Yii::$app->user->is($model->id) || (!Yii::$app->user->can('resell') && Yii::$app->user->can('support') && Yii::$app->user->identity->seller_id== $model->id);
    }
}

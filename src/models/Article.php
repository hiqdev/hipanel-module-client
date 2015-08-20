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

use hipanel\models\Ref;
use Yii;

class Article extends \hipanel\base\Model
{
    use \hipanel\base\ModelTrait;

    public function rules()
    {
        return [
            [['is_published', 'type', 'post_date', 'data', 'texts'],                             'safe'],
            [['id', 'client_id', 'type_id'],                                                       'integer'],
            [['article_name', 'type', 'data', 'texts', 'client', 'name', 'realm'],                 'safe'],
            [['html_title', 'html_keywords', 'html_description', 'title', 'short_text', 'text'],  'safe'],
            [['is_published', 'is_common'],                                                        'safe'],
            [['post_date'],                                                                       'date'],
            [['name', 'type'],                                                                    'required'],
        ];
    }

    /**
     * @return array the list of attributes for this record
     */
    public static function getApiLangs($select = null)
    {
        if ($select !== null) {
            return Ref::find()->where(['gtype' => 'type,lang', 'select' => $select])->getList();
        } else {
            return Ref::find()->where(['gtype' => 'type,lang'])->getList();
        }
    }

    public function rest()
    {
        return \yii\helpers\ArrayHelper::merge(parent::rest(), ['resource' => 'article']);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'           => Yii::t('app', 'ID'),
            'article_name' => Yii::t('app', 'Article Name'),
            'post_date'    => Yii::t('app', 'Post Date'),
            'data'         => Yii::t('app', 'Data'),
        ];
    }
}

<?php
/**
 * Client module for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-client
 * @package   hipanel-module-client
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2018, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\client\models;

use hipanel\models\Ref;
use hipanel\modules\client\models\query\ArticleQuery;

/**
 * Class Article.
 */
class Article extends \hipanel\base\Model
{
    use \hipanel\base\ModelTrait;

    public function rules()
    {
        return [
            [['is_published', 'type', 'post_date', 'data', 'texts'], 'safe'],
            [['id', 'client_id', 'type_id'], 'integer'],
            [['name', 'type', 'data', 'texts', 'client', 'name', 'realm'], 'safe'],
            [['html_title', 'html_keywords', 'html_description', 'title', 'short_text', 'text'], 'safe'],
            [['is_published', 'is_common'], 'safe'],
            [['post_date'], 'date'],
            [['name', 'type'], 'required', 'on' => ['create', 'update']],
        ];
    }

    /**
     * {@inheritdoc}
     * @return ArticleQuery
     */
    public static function find($options = [])
    {
        return new ArticleQuery(get_called_class(), [
            'options' => $options,
        ]);
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
}

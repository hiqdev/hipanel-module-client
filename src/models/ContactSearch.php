<?php
/**
 * Client module for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-client
 * @package   hipanel-module-client
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2019, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\client\models;

use hipanel\base\SearchModelTrait;
use yii\helpers\ArrayHelper;

/**
 * GallerySearch represents the model behind the search form about `app\models\Gallery`.
 */
class ContactSearch extends Contact
{
    use SearchModelTrait {
        searchAttributes as defaultSearchAttributes;
    }

    public static function tableName()
    {
        return Contact::tableName();
    }

    public function searchAttributes()
    {
        return ArrayHelper::merge($this->defaultSearchAttributes(), [
            'limit',
            'tags',
        ]);
    }
}

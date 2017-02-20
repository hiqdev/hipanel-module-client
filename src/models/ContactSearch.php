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

use hipanel\base\SearchModelTrait;

/**
 * GallerySearch represents the model behind the search form about `app\models\Gallery`.
 */
class ContactSearch extends Contact
{
    use SearchModelTrait {
        searchAttributes as defaultSearchAttributes;
    }
}

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

/**
 * GallerySearch represents the model behind the search form about `app\models\Gallery`.
 */
class ContactSearch extends Contact
{
    use \hipanel\base\SearchModelTrait;
}

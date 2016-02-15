<?php

/*
 * Client module for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-client
 * @package   hipanel-module-client
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2016, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\client\controllers;

class ArticleController extends \hipanel\base\CrudController
{
    public function beforeAction($action)
    {
        if (isset($_POST['Article']['data'])) {
            $_POST['Article']['texts'] = $_POST['Article']['data'];
            unset($_POST['Article']['data']);
        }

        return parent::beforeAction($action);
    }
}

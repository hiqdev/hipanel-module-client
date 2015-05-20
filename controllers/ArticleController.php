<?php
/**
 * @link    http://hiqdev.com/hipanel-module-client
 * @license http://hiqdev.com/hipanel-module-client/license
 * @copyright Copyright (c) 2015 HiQDev
 */

namespace hipanel\modules\client\controllers;

use Yii;
use yii\web\Response;

class ArticleController extends \hipanel\base\CrudController
{


    public function beforeAction ($action) {
        if (isset($_POST['Article']['data'])) {
            $_POST['Article']['texts'] = $_POST['Article']['data'];
            unset($_POST['Article']['data']);
        }
        return parent::beforeAction($action);
    }
}

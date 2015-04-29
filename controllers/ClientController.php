<?php
/**
 * @link    http://hiqdev.com/hipanel-module-client
 * @license http://hiqdev.com/hipanel-module-client/license
 * @copyright Copyright (c) 2015 HiQDev
 */

namespace hipanel\modules\client\controllers;

use Yii;
use yii\web\Response;

class ClientController extends \hipanel\base\CrudController
{
    /// TODO: implement
    public function actionCheckLogin($login)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return $out;
    }

    public function actionView($id)
    {
        $model = $this->findModel([
            'id'                  => $id,
            'with_domains_count'  => 1,
            'with_servers_count'  => 1,
            'with_contacts_count' => 1,
            'with_contact'        => 1
        ]);
        return $this->render('view', ['model' => $model]);
    }

}

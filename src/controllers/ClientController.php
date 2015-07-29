<?php

/*
 * Client Plugin for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-client
 * @package   hipanel-module-client
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2014-2015, HiQDev (https://hiqdev.com/)
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
            'with_tickets_count'  => 1,
            'with_domains_count'  => 1,
            'with_servers_count'  => 1,
            'with_contacts_count' => 1,
            'with_last_seen'      => 1,
            'with_contact'        => 1,
        ]);

        return $this->render('view', ['model' => $model]);
    }
}

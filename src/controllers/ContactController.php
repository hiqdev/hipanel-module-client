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

use hipanel\base\CrudController;
use hipanel\modules\client\models\Contact;
use Yii;
use yii\web\HttpException;

class ContactController extends CrudController
{
    public function actions()
    {
        return [
            'validate-form' => [
                'class' => 'hipanel\actions\FormValidateAction',
            ],
        ];
    }

    public function actionView($id)
    {
        $model = $this->findModel([
            'id'            => $id,
            'with_counters' => 1,
        ]);

        return $this->render('view', ['model' => $model]);
    }

    public function actionCreate()
    {
        $model = new Contact();
        $model->setScenario('create');
        $countries = $this->getRefs('country_code');

        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                throw new HttpException($model->getFirstError());
            }
        }

        return $this->render('create', [
            'model'     => $model,
            'countries' => $countries,
        ]);
    }

    public function actionUpdate($id)
    {
        $model     = $this->findModel($id);
        $countries = $this->getRefs('country_code');
        if (Yii::$app->request->isPost) {
            \yii\helpers\VarDumper::dump($_POST, 10, true);
            die();
        }

        return $this->render('create', [
            'model'     => $model,
            'countries' => $countries,
        ]);
    }

    public function actionCopy()
    {
    }
}

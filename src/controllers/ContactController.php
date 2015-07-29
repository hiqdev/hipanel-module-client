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
use hipanel\modules\client\models\Client;
use hipanel\modules\client\models\Contact;
use Yii;
use yii\base\Exception;
use yii\web\HttpException;
use yii\web\MethodNotAllowedHttpException;
use yii\widgets\ActiveForm;

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
        $model = $this->findModel($id);
        $model->setScenario('update');
        if (Yii::$app->request->isPost) {
            $model->load(Yii::$app->request->post());
            if ($model->validate()) {
                try {
                    $model->save();
                } catch (Exception $e) {
                    Yii::$app->session->addFlash('error', [
                        'text' => $e->getMessage() . '<br>' . ucfirst($e->errorInfo)
                    ]);
                    return $this->refresh();
                }
                return $this->redirect(['view', 'id' => $model->id]);
            } else
                throw new HttpException($model->getFirstError());
        }
        $countries = $this->getRefs('country_code');
        $askPincode = Client::perform('HasPincode');
        return $this->render('update', [
            'model' => $model,
            'countries' => $countries,
            'askPincode' => $askPincode,
        ]);
    }

    public function actionCopy()
    {
    }

    public function actionDelete()
    {
        $request = Yii::$app->request;
        if ($request->isPost) {
            $condition = $request->get('id') ? : $request->post('selection');
            if (!empty($condition)) {
                $models = $this->findModels($condition);
                foreach ($models as $model) {
                    $model->delete();
                }
            }
            return $this->redirect('index');
        } else {
            throw new MethodNotAllowedHttpException(Yii::t('app', 'Method not allowed'));
        }
    }
}

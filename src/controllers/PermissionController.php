<?php

namespace hipanel\modules\client\controllers;

use Exception;
use hipanel\modules\client\models\Client;
use hipanel\modules\client\models\Permission;
use Yii;
use yii\base\DynamicModel;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class PermissionController extends Controller
{
    public function actionView(int $id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionAssign(int $id)
    {
        $this->response->format = Response::FORMAT_JSON;
        $roles = $this->request->post('roles', []);
        $permissionModel =  $this->findModel($id);
        $defaultRole = 'role:' . $permissionModel->client->type;
        $roles = array_diff($roles, [$defaultRole]);
        $validateModel = DynamicModel::validateData(['id' => $id, 'roles' => $roles], [
            [['id', 'roles'], 'required'],
        ]);
        if ($validateModel->hasErrors()) {
            $error = $validateModel->getFirstErrors();

            return [
                'success' => false,
                'message' => reset($error),
            ];
        }
        try {
            Client::perform('set-roles', $validateModel->attributes);

            return [
                'success' => true,
                'message' => Yii::t('hipanel:client', 'Permissions assigned successfully'),
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    protected function findModel(int $id): ?Permission
    {
        $client = Client::find()->where(['id' => $id])->select(['roles'])->one();

        if ($client) {
            return new Permission($client);
        }

        throw new NotFoundHttpException(Yii::t('hipanel:client', 'The requested client does not exist.'));
    }
}
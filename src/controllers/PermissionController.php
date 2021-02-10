<?php

namespace hipanel\modules\client\controllers;

use hipanel\modules\client\models\Client;
use hipanel\modules\client\models\Permission;
use RuntimeException;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

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
        throw new RuntimeException('not implemented');
    }

    public function actionRevoke(int $id)
    {
        throw new RuntimeException('not implemented');
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
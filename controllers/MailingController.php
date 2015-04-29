<?php

namespace hipanel\modules\client\controllers;

use hipanel\modules\client\models\Mailing;
use yii\web\Controller;
use Yii;


class MailingController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index', ['model' => new Mailing]);
    }
}

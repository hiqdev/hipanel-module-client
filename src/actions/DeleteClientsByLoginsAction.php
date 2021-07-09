<?php

declare(strict_types=1);

namespace hipanel\modules\client\actions;

use Exception;
use hipanel\modules\client\forms\DeleteClientsByLoginsForm;
use hipanel\modules\client\models\Client;
use RuntimeException;
use Yii;
use yii\base\Action;
use yii\web\Controller;
use yii\web\Response;
use yii\web\Session;

final class DeleteClientsByLoginsAction extends Action
{
    private Session $session;

    public function __construct($id, Controller $controller, Session $session, array $config = [])
    {
        parent::__construct($id, $controller, $config);
        $this->session = $session;
    }

    public function run(): Response
    {
        $form = new DeleteClientsByLoginsForm();
        $controller = $this->controller;
        try {
            if ($controller->request->isPost && $form->load($controller->request->post()) ?? $form->validate()) {
                $clients = $form->getClients();
                $payload = [];
                foreach ($clients as $client) {
                    $id = $client->id;
                    $payload[$id] = ['id' => $id];
                }
                Client::batchPerform('delete', $payload);
                $this->session->setFlash('success', Yii::t('hipanel:client', '{0, plural, one{# client} few{# clients} other{# clients}} clients has been deleted', count($clients)));
            } else {
                throw new RuntimeException('The from data is broken, try again please');
            }
        } catch (Exception $e) {
            $this->session->setFlash('error', $e->getMessage());
        }

        return $controller->redirect(['@client/index']);
    }
}

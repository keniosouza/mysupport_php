<?php

/** Importação de classes */
use vendor\model\Notifications;
use vendor\controller\notifications\NotificationsValidate;

/** Instânciamento de classes */
$Notifications = new Notifications();
$NotificationsValidate = new NotificationsValidate();

/** Parâmetros de entrada */
$NotificationsValidate->setNotificationId(@(int)filter_input(INPUT_POST, 'NOTIFICATION_ID', FILTER_SANITIZE_SPECIAL_CHARS));
$NotificationsValidate->setDestinyUserId(@(int)filter_input(INPUT_POST, 'DESTINY_USER_ID', FILTER_SANITIZE_SPECIAL_CHARS));
$NotificationsValidate->setStatus(@(int)filter_input(INPUT_POST, 'STATUS', FILTER_SANITIZE_SPECIAL_CHARS));

/** Verifico a existência de erros */
if (!empty($NotificationsValidate->getErrors())) {

    /** Caso existam erro(s), retorna os mesmos **/
    throw new InvalidArgumentException($NotificationsValidate->getErrors());

} else {

    /** Verifico se o usuário foi localizado */
    if ($Notifications->SaveStatus($NotificationsValidate->getNotificationId(), $NotificationsValidate->getDestinyUserId(), $NotificationsValidate->getStatus())) {

        /** Result **/
        $result = [

            'code' => 200,
            'data' => $NotificationsValidate->getStatus() === 3 ? 'Mensagem Visualizada' : 'Marcado como não lido',
            'toast' => true

        ];

    } else {

        /** Retorno mensagem de erro */
        throw new InvalidArgumentException('Não foi possivel salvar o registro', 0);

    }

}

/** Devolvo o json com as informações **/
echo json_encode($result);

/** Paro o procedimento **/
exit;
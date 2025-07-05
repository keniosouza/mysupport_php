<?php

/** Importação de classes  */
use vendor\model\Notifications;
use vendor\controller\notifications\NotificationsValidate;
use vendor\model\Messages;
use vendor\controller\messages\MessagesValidate;
use vendor\model\CallsActivitiesUsers;
use vendor\model\Calls;
use vendor\controller\calls\CallsValidate;

/** Instânciamento de classes  */
$Notifications = new Notifications();
$NotificationsValidate = new NotificationsValidate();
$Messages = new Messages();
$MessagesValidate = new MessagesValidate();
$CallsActivitiesUsers = new CallsActivitiesUsers();
$Calls = new Calls();
$CallsValidate = new CallsValidate();

/** Parametros de entrada  */
$callId = @(int)filter_input(INPUT_POST, 'call_id', FILTER_SANITIZE_NUMBER_INT);

/** Validando os campos de entrada */
$CallsValidate->setCallId($callId);

/** Verifico a existência de erros */
if (!empty($CallsValidate->getErrors())) {

    /** Retorno mensagem de erro */
    throw new InvalidArgumentException($CallsValidate->getErrors(), 0);

} else {

    /** Busco o registro desejado */
    $CallsGetResult = $Calls->get($CallsValidate->getCallId());

    /** Verifico se o registro foi localizado */
    if (@(int)$CallsGetResult->call_id > 0) {

        /** Efetua um novo cadastro ou salva os novos dados */
        if ($Calls->SaveClose($CallsValidate->getCallId(), $CallsValidate->getDateClose())) {

            /** Busco os colaboradores para serem notificados */
            $CallsActivitiesUsersAllUserIdByCallIdResult = $CallsActivitiesUsers->AllUserIdByCallId($CallsGetResult->call_id);

            /** Verificos se devo realizar a notificação dos colaboradores */
            if (count($CallsActivitiesUsersAllUserIdByCallIdResult) > 0)
            {

                /** perocorro a lista dos colaboradores localizados */
                foreach ($CallsActivitiesUsersAllUserIdByCallIdResult as $key => $result)
                {

                    /** Parâmetros de entrada */
                    $NotificationsValidate->setNotificationId(0);
                    $NotificationsValidate->setCompanyId((int)$_SESSION['USERSCOMPANYID']);
                    $NotificationsValidate->setUserId((int)$_SESSION['USERSID']);
                    $NotificationsValidate->setDestinyUserId((int)$result->user_id);
                    $NotificationsValidate->setTable('calls');
                    $NotificationsValidate->setRegisterId((int)$result->call_id);
                    $NotificationsValidate->setStatus(1);
                    $NotificationsValidate->setData(json_encode(['TITLE' => 'Reativado!', 'MESSAGE' => 'Chamado "'. '#' . $result->call_id . ' - ' . $result->name . '" Reativado!', 'CLASS' => 'success', 'ICON' => 'image/default/checked.svg'], JSON_PRETTY_PRINT));
                    $NotificationsValidate->setDateRegister(date('Y/m/d H:i:s'));

                    /** Notificação de Operação */
                    $Notifications->Save($NotificationsValidate->getNotificationId(), $NotificationsValidate->getCompanyId(), $NotificationsValidate->getUserId(), $NotificationsValidate->getDestinyUserId(), $NotificationsValidate->getTable(), $NotificationsValidate->getRegisterId(), $NotificationsValidate->getStatus(), $NotificationsValidate->getData(), $NotificationsValidate->getDateRegister());

                }

            }

            /** Defino o texto que será postado */
            $MessagesValidate->setUserId((int)$_SESSION['USERSID']);
            $MessagesValidate->setTable('calls');
            $MessagesValidate->setRegisterId((int)$CallsGetResult->call_id);
            $MessagesValidate->setReceived(0);
            $MessagesValidate->setViewed(0);
            $MessagesValidate->setData('Reativando Chamado: ' . '#' . $CallsGetResult->call_id . ' - ' . $CallsGetResult->name);
            $MessagesValidate->setDateRegister(date('Y/m/d H:i:s'));

            /** Publico uma mensagem */
            $Messages->Save(0, $MessagesValidate->getUserId(), $MessagesValidate->getTable(), $MessagesValidate->getRegisterId(), $MessagesValidate->getData(), $MessagesValidate->getDateRegister());

            /** Log de requisições */
            $Logs->Save($LogsValidate->getLogId(), 4, $LogsValidate->getCompanyId(), $LogsValidate->getUserId(), 'calls', $CallsGetResult->call_id, md5('calls' . $CallsGetResult->call_id), $LogsHandling->getDefaultData('Reativado!', 'Chamado "<b>' . $CallsGetResult->name . '</b>" Reativado!', 'warning'), $LogsValidate->getDateRegister());

            /** Result **/
            $result = [

                'code' => 200,
                'title' => 'Chamado reativado!',
                'data' => 'Chamado reativado!',
                'toast' => true,
                'redirect' => [
                    [
                        'url' => 'FOLDER=VIEW&TABLE=CALLS&ACTION=CALLS_DATAGRID'
                    ]
                ]

            ];

        } else {

            /** Retorno mensagem de erro */
            throw new InvalidArgumentException('Não foi possível encerrar o chamado', 0);

        }

    } else {

        /** Retorno mensagem de erro */
        throw new InvalidArgumentException('Não foi possível localizar o chamado', 0);

    }

}

/** Envio **/
echo json_encode($result);

/** Paro o procedimento **/
exit;
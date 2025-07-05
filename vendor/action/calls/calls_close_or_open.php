<?php

/** Importação de classes */
use vendor\model\Notifications;
use vendor\controller\notifications\NotificationsValidate;
use vendor\model\Calls;
use vendor\model\CallsActivitiesUsers;
use vendor\controller\calls\CallsValidate;
use vendor\model\Messages;
use vendor\controller\messages\MessagesValidate;

/** Instânciamento de classes */
$Notifications = new Notifications();
$NotificationsValidate = new NotificationsValidate();
$Calls = new Calls();
$CallsActivitiesUsers = new CallsActivitiesUsers();
$CallsValidate = new CallsValidate();
$Messages = new Messages();
$MessagesValidate = new MessagesValidate();

/** Parâmetros de entrada */
$CallsValidate->setCallId(@(int)filter_input(INPUT_POST, 'CALL_ID', FILTER_SANITIZE_NUMBER_INT));
$CallsValidate->setDateClose(date('Y.m.d h:m:s'));

/** Verifico a existência de erros */
if (!empty($CallsValidate->getErrors())) {

    /** Retorno mensagem de erro */
    throw new InvalidArgumentException($CallsValidate->getErrors(), 0);

} else {

    /** Busco o registro desejado */
    $CallsGetResult = $Calls->Get($CallsValidate->getCallId());

    /** Verifico se o registro foi localizado */
    if ($CallsGetResult->call_id > 0)
    {

        /** Verifico se devo realizar o encerramento ou reativação da atividade */
        if (empty($CallsGetResult->date_close))
        {

            /** Encerramento da atividade */
            if ($Calls->SaveClose($CallsValidate->getCallId(), $CallsValidate->getDateClose())) {

                /** Busco os colaboradores para serem notificados */
                $CallsUsersAllByActivityIdResult = $CallsActivitiesUsers->AllUserIdByCallId($CallsValidate->getCallId());

                /** Verificos se devo realizar a notificação dos colaboradores */
                if (count($CallsUsersAllByActivityIdResult) > 0)
                {

                    /** perocorro a lista dos colaboradores localizados */
                    foreach ($CallsUsersAllByActivityIdResult as $key => $result)
                    {

                        /** Parâmetros de entrada */
                        $NotificationsValidate->setNotificationId(0);
                        $NotificationsValidate->setCompanyId((int)$_SESSION['USERSCOMPANYID']);
                        $NotificationsValidate->setUserId((int)$_SESSION['USERSID']);
                        $NotificationsValidate->setDestinyUserId((int)$result->user_id);
                        $NotificationsValidate->setTable('calls_activities');
                        $NotificationsValidate->setRegisterId((int)$result->call_id);
                        $NotificationsValidate->setStatus(1);
                        $NotificationsValidate->setData(json_encode(['TITLE' => 'Encerrado!', 'MESSAGE' => 'Chamado "'. '#' . $result->call_id . ' - ' . $result->activity_name . '" Encerrado!', 'CLASS' => 'success', 'ICON' => 'image/default/checked.svg'], JSON_PRETTY_PRINT));
                        $NotificationsValidate->setDateRegister(date('Y/m/d H:i:s'));

                        /** Notificação de Operação */
                        $Notifications->Save($NotificationsValidate->getNotificationId(), $NotificationsValidate->getCompanyId(), $NotificationsValidate->getUserId(), $NotificationsValidate->getDestinyUserId(), $NotificationsValidate->getTable(), $NotificationsValidate->getRegisterId(), $NotificationsValidate->getStatus(), $NotificationsValidate->getData(), $NotificationsValidate->getDateRegister());

                    }

                }

                /** Defino o texto que será postado */
                $MessagesValidate->setUserId((int)$_SESSION['USERSID']);
                $MessagesValidate->setTable('calls_activities');
                $MessagesValidate->setRegisterId((int)$CallsGetResult->call_id);
                $MessagesValidate->setReceived(0);
                $MessagesValidate->setViewed(0);
                $MessagesValidate->setData('Encerrando Chamado: ' . '#' . $CallsGetResult->call_id . ' - ' . $CallsGetResult->name);
                $MessagesValidate->setDateRegister(date('Y/m/d H:i:s'));

                /** Publico uma mensagem */
                $Messages->Save(0, $MessagesValidate->getUserId(), $MessagesValidate->getTable(), $MessagesValidate->getRegisterId(), $MessagesValidate->getData(), $MessagesValidate->getDateRegister());

                /** Salvo o Log do Procedimento Realizado */
                $Logs->Save($LogsValidate->getLogId(), 4, $LogsValidate->getCompanyId(), $LogsValidate->getUserId(), 'calls', $CallsValidate->getCallId(), md5('calls' . $CallsGetResult->call_id), $LogsHandling->getDefaultData('Encerrado!', 'Chamado <b>"' . $CallsGetResult->name . '"</b> Encerrado!', 'success'), $LogsValidate->getDateRegister());

                /** Result **/
                $result = [

                    'code' => 200,
                    'title' => 'Sucesso',
                    'data' => 'Chamado Encerrado',
                    'toast' => true

                ];

            } else {

                /** Retorno mensagem de erro */
                throw new InvalidArgumentException('Não foi possivel salvar o registro', 0);

            }

        }
        elseif (!empty($CallsGetResult->date_close))
        {

            /** Verifico se o registro foi localizado */
            if ($Calls->SaveOpen($CallsValidate->getCallId())){

                /** Busco os colaboradores para serem notificados */
                $CallsUsersAllByActivityIdResult = $CallsActivitiesUsers->AllUserIdByCallId($CallsValidate->getCallId());

                /** Verificos se devo realizar a notificação dos colaboradores */
                if (count($CallsUsersAllByActivityIdResult) > 0)
                {

                    /** perocorro a lista dos colaboradores localizados */
                    foreach ($CallsUsersAllByActivityIdResult as $key => $result)
                    {

                        /** Parâmetros de entrada */
                        $NotificationsValidate->setNotificationId(0);
                        $NotificationsValidate->setCompanyId((int)$_SESSION['USERSCOMPANYID']);
                        $NotificationsValidate->setUserId((int)$_SESSION['USERSID']);
                        $NotificationsValidate->setDestinyUserId((int)$result->user_id);
                        $NotificationsValidate->setTable('calls_activities');
                        $NotificationsValidate->setRegisterId((int)$result->call_id);
                        $NotificationsValidate->setStatus(1);
                        $NotificationsValidate->setData(json_encode(['TITLE' => 'Reativado!', 'MESSAGE' => 'Chamado "'. '#' . $result->call_id . ' - ' . $result->activity_name . '" Reativado!', 'CLASS' => 'danger', 'ICON' => 'image/default/alert.png'], JSON_PRETTY_PRINT));
                        $NotificationsValidate->setDateRegister(date('Y/m/d H:i:s'));

                        /** Notificação de Operação */
                        $Notifications->Save($NotificationsValidate->getNotificationId(), $NotificationsValidate->getCompanyId(), $NotificationsValidate->getUserId(), $NotificationsValidate->getDestinyUserId(), $NotificationsValidate->getTable(), $NotificationsValidate->getRegisterId(), $NotificationsValidate->getStatus(), $NotificationsValidate->getData(), $NotificationsValidate->getDateRegister());

                    }

                }

                /** Defino o texto que será postado */
                $MessagesValidate->setUserId((int)$_SESSION['USERSID']);
                $MessagesValidate->setTable('calls_activities');
                $MessagesValidate->setRegisterId((int)$CallsGetResult->call_id);
                $MessagesValidate->setReceived(0);
                $MessagesValidate->setViewed(0);
                $MessagesValidate->setData('Reativando Chamado: ' . '#' . $CallsGetResult->call_id . ' - ' . $CallsGetResult->name);
                $MessagesValidate->setDateRegister(date('Y/m/d H:i:s'));

                /** Publico uma mensagem */
                $Messages->Save(0, $MessagesValidate->getUserId(), $MessagesValidate->getTable(), $MessagesValidate->getRegisterId(), $MessagesValidate->getData(), $MessagesValidate->getDateRegister());

                /** Log de requisições */
                $Logs->Save($LogsValidate->getLogId(), 4, $LogsValidate->getCompanyId(), $LogsValidate->getUserId(), 'calls', $CallsValidate->getCallId(), md5('calls' . $CallsGetResult->call_id), $LogsHandling->getDefaultData('Reativado!', 'Chamado <b>"' . $CallsGetResult->name . '"</b> Reativado!', 'warning'), $LogsValidate->getDateRegister());

                /** Result **/
                $result = [

                    'code' => 200,
                    'title' => 'Sucesso',
                    'data' => 'Chamado Reativado',
                    'toast' => true

                ];

            } else {

                /** Retorno mensagem de erro */
                throw new InvalidArgumentException('Não foi possivel salvar o registro', 0);

            }

        }

    }
    else{

        /** Retorno mensagem de erro */
        throw new InvalidArgumentException('Não foi possivel localizar o registro', 0);

    }

}

/** Envio **/
echo json_encode($result);

/** Paro o procedimento **/
exit;
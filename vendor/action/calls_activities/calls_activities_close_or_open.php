<?php

/** Importação de classes */
use vendor\model\Notifications;
use vendor\controller\notifications\NotificationsValidate;
use vendor\model\CallsActivitiesUsers;
use vendor\model\CallsActivities;
use vendor\controller\calls_activities\CallsActivitiesValidate;
use vendor\model\Messages;
use vendor\controller\messages\MessagesValidate;

/** Instânciamento de classes */
$Notifications = new Notifications();
$NotificationsValidate = new NotificationsValidate();
$CallsActivitiesUsers = new CallsActivitiesUsers();
$CallsActivities = new CallsActivities();
$CallsActivitiesValidate = new CallsActivitiesValidate();
$Messages = new Messages();
$MessagesValidate = new MessagesValidate();

/** Parâmetros de entrada */
$CallsActivitiesValidate->setCallActivityId(@(int)filter_input(INPUT_POST, 'CALL_ACTIVITY_ID', FILTER_SANITIZE_NUMBER_INT));
$CallsActivitiesValidate->setDateClose(date('Y.m.d h:m:s'));

/** Verifico a existência de erros */
if (!empty($CallsActivitiesValidate->getErrors())) {

    /** Retorno mensagem de erro */
    throw new InvalidArgumentException($CallsActivitiesValidate->getErrors(), 0);

} else {

    /** Busco o registro desejado */
    $CallsActivitiesGetResult = $CallsActivities->Get($CallsActivitiesValidate->getCallActivityId());

    /** Verifico se o registro foi localizado */
    if ($CallsActivitiesGetResult->call_activity_id > 0)
    {

        /** Verifico se devo realizar o encerramento ou reativação da atividade */
        if (empty($CallsActivitiesGetResult->date_close))
        {

            /** Encerramento da atividade */
            if ($CallsActivities->SaveClose($CallsActivitiesValidate->getCallActivityId(), $CallsActivitiesValidate->getDateClose())) {

                /** Busco os colaboradores para serem notificados */
                $CallsActivitiesUsersAllByActivityIdResult = $CallsActivitiesUsers->AllByActivityId($CallsActivitiesValidate->getCallActivityId());

                /** Verificos se devo realizar a notificação dos colaboradores */
                if (count($CallsActivitiesUsersAllByActivityIdResult) > 0)
                {

                    /** perocorro a lista dos colaboradores localizados */
                    foreach ($CallsActivitiesUsersAllByActivityIdResult as $key => $result)
                    {

                        /** Parâmetros de entrada */
                        $NotificationsValidate->setNotificationId(0);
                        $NotificationsValidate->setCompanyId((int)$_SESSION['USERSCOMPANYID']);
                        $NotificationsValidate->setUserId((int)$_SESSION['USERSID']);
                        $NotificationsValidate->setDestinyUserId((int)$result->user_id);
                        $NotificationsValidate->setTable('calls_activities');
                        $NotificationsValidate->setRegisterId((int)$result->call_activity_id);
                        $NotificationsValidate->setStatus(1);
                        $NotificationsValidate->setData(json_encode(['TITLE' => 'Encerrado!', 'MESSAGE' => 'Atividade "'. '#' . $result->call_activity_id . ' - ' . $result->activity_name . '" Encerrada!', 'CLASS' => 'success', 'ICON' => 'image/default/checked.svg'], JSON_PRETTY_PRINT));
                        $NotificationsValidate->setDateRegister(date('Y/m/d H:i:s'));

                        /** Notificação de Operação */
                        $Notifications->Save($NotificationsValidate->getNotificationId(), $NotificationsValidate->getCompanyId(), $NotificationsValidate->getUserId(), $NotificationsValidate->getDestinyUserId(), $NotificationsValidate->getTable(), $NotificationsValidate->getRegisterId(), $NotificationsValidate->getStatus(), $NotificationsValidate->getData(), $NotificationsValidate->getDateRegister());

                    }

                }

                /** Defino o texto que será postado */
                $MessagesValidate->setUserId((int)$_SESSION['USERSID']);
                $MessagesValidate->setTable('calls_activities');
                $MessagesValidate->setRegisterId((int)$CallsActivitiesGetResult->call_activity_id);
                $MessagesValidate->setReceived(0);
                $MessagesValidate->setViewed(0);
                $MessagesValidate->setData('Encerrando Atividade: ' . '#' . $CallsActivitiesGetResult->call_activity_id . ' - ' . $CallsActivitiesGetResult->name);
                $MessagesValidate->setDateRegister(date('Y/m/d H:i:s'));

                /** Publico uma mensagem */
                $Messages->Save(0, $MessagesValidate->getUserId(), $MessagesValidate->getTable(), $MessagesValidate->getRegisterId(), $MessagesValidate->getData(), $MessagesValidate->getDateRegister());

                /** Salvo o Log do Procedimento Realizado */
                $Logs->Save($LogsValidate->getLogId(), 4, $LogsValidate->getCompanyId(), $LogsValidate->getUserId(), 'calls_activities', $CallsActivitiesValidate->getCallActivityId(), md5('calls' . $CallsActivitiesGetResult->call_id), $LogsHandling->getDefaultData('Encerrado!', 'Atividade <b>"' . $CallsActivitiesGetResult->name . '"</b> Encerrada!', 'success'), $LogsValidate->getDateRegister());

                /** Result **/
                $result = [

                    'code' => 200,
                    'title' => 'Sucesso',
                    'data' => 'Atividade Encerrada',
                    'toast' => true

                ];

            } else {

                /** Retorno mensagem de erro */
                throw new InvalidArgumentException('Não foi possivel salvar o registro', 0);

            }

        }
        elseif (!empty($CallsActivitiesGetResult->date_close))
        {

            /** Verifico se o registro foi localizado */
            if ($CallsActivities->SaveOpen($CallsActivitiesValidate->getCallActivityId())){

                /** Busco os colaboradores para serem notificados */
                $CallsActivitiesUsersAllByActivityIdResult = $CallsActivitiesUsers->AllByActivityId($CallsActivitiesValidate->getCallActivityId());

                /** Verificos se devo realizar a notificação dos colaboradores */
                if (count($CallsActivitiesUsersAllByActivityIdResult) > 0)
                {

                    /** perocorro a lista dos colaboradores localizados */
                    foreach ($CallsActivitiesUsersAllByActivityIdResult as $key => $result)
                    {

                        /** Parâmetros de entrada */
                        $NotificationsValidate->setNotificationId(0);
                        $NotificationsValidate->setCompanyId((int)$_SESSION['USERSCOMPANYID']);
                        $NotificationsValidate->setUserId((int)$_SESSION['USERSID']);
                        $NotificationsValidate->setDestinyUserId((int)$result->user_id);
                        $NotificationsValidate->setTable('calls_activities');
                        $NotificationsValidate->setRegisterId((int)$result->call_activity_id);
                        $NotificationsValidate->setStatus(1);
                        $NotificationsValidate->setData(json_encode(['TITLE' => 'Reativada!', 'MESSAGE' => 'Atividade "'. '#' . $result->call_activity_id . ' - ' . $result->activity_name . '" Reativada!', 'CLASS' => 'danger', 'ICON' => 'image/default/alert.png'], JSON_PRETTY_PRINT));
                        $NotificationsValidate->setDateRegister(date('Y/m/d H:i:s'));

                        /** Notificação de Operação */
                        $Notifications->Save($NotificationsValidate->getNotificationId(), $NotificationsValidate->getCompanyId(), $NotificationsValidate->getUserId(), $NotificationsValidate->getDestinyUserId(), $NotificationsValidate->getTable(), $NotificationsValidate->getRegisterId(), $NotificationsValidate->getStatus(), $NotificationsValidate->getData(), $NotificationsValidate->getDateRegister());

                    }

                }

                /** Defino o texto que será postado */
                $MessagesValidate->setUserId((int)$_SESSION['USERSID']);
                $MessagesValidate->setTable('calls_activities');
                $MessagesValidate->setRegisterId((int)$CallsActivitiesGetResult->call_activity_id);
                $MessagesValidate->setReceived(0);
                $MessagesValidate->setViewed(0);
                $MessagesValidate->setData('Reativando Atividade: ' . '#' . $CallsActivitiesGetResult->call_activity_id . ' - ' . $CallsActivitiesGetResult->name);
                $MessagesValidate->setDateRegister(date('Y/m/d H:i:s'));

                /** Publico uma mensagem */
                $Messages->Save(0, $MessagesValidate->getUserId(), $MessagesValidate->getTable(), $MessagesValidate->getRegisterId(), $MessagesValidate->getData(), $MessagesValidate->getDateRegister());

                /** Log de requisições */
                $Logs->Save($LogsValidate->getLogId(), 4, $LogsValidate->getCompanyId(), $LogsValidate->getUserId(), 'calls_activities', $CallsActivitiesValidate->getCallActivityId(), md5('calls' . $CallsActivitiesGetResult->call_id), $LogsHandling->getDefaultData('Reativado!', 'Atividade <b>"' . $CallsActivitiesGetResult->name . '"</b> Reativada!', 'warning'), $LogsValidate->getDateRegister());

                /** Result **/
                $result = [

                    'code' => 200,
                    'title' => 'Sucesso',
                    'data' => 'Atividade Reativada',
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
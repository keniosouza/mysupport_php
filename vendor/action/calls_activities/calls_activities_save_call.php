<?php

/** Importação de classes */
use vendor\model\Notifications;
use vendor\controller\notifications\NotificationsValidate;
use vendor\model\Calls;
use vendor\model\CallsActivities;
use vendor\controller\calls_activities\CallsActivitiesValidate;
use vendor\model\CallsActivitiesUsers;
use vendor\model\Messages;
use vendor\controller\messages\MessagesValidate;

/** Instânciamento de classes */
$Notifications = new Notifications();
$NotificationsValidate = new NotificationsValidate();
$Calls = new Calls();
$CallsActivities = new CallsActivities();
$CallsActivitiesValidate = new CallsActivitiesValidate();
$CallsActivitiesUsers = new CallsActivitiesUsers();
$Messages = new Messages();
$MessagesValidate = new MessagesValidate();

/** Parâmetros de entrada */
$CallsActivitiesValidate->setCallActivityId(@(int)filter_input(INPUT_POST, 'call_activity_id', FILTER_SANITIZE_NUMBER_INT));
$CallsActivitiesValidate->setCallId(@(int)filter_input(INPUT_POST, 'call_id', FILTER_SANITIZE_NUMBER_INT));

/** Verifico a existência de erros */
if (!empty($CallsActivitiesValidate->getErrors())) {

    /** Retorno mensagem de erro */
    throw new InvalidArgumentException($CallsActivitiesValidate->getErrors(), 0);

} else {

    /** Busco o registro desejado */
    $CallsActivitiesGetResult = $CallsActivities->Get($CallsActivitiesValidate->getCallActivityId());
    $CallsGetResult = $Calls->get($CallsActivitiesValidate->getCallId());

    /** Verifico se o registro foi localizado */
    if ($CallsActivities->SaveCallId($CallsActivitiesValidate->getCallActivityId(), $CallsActivitiesValidate->getCallId())) {

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
                $NotificationsValidate->setData(json_encode(['TITLE' => 'Alterado!', 'MESSAGE' => 'Chamado da Atividade "'. '#' . $result->call_activity_id . ' - ' . $result->activity_name . '" Alterada para : ' . $CallsGetResult->name . '!', 'CLASS' => 'success', 'ICON' => 'image/default/checked.svg'], JSON_PRETTY_PRINT));
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
        $MessagesValidate->setData('Alterando o chamado da atividade para: ' . $CallsGetResult->name);
        $MessagesValidate->setDateRegister(date('Y/m/d H:i:s'));

        /** Publico uma mensagem */
        $Messages->Save($MessagesValidate->getMessageId(), $MessagesValidate->getUserId(), $MessagesValidate->getTable(), $MessagesValidate->getRegisterId(), $MessagesValidate->getData(), $MessagesValidate->getDateRegister());

        /** Log de requisições */
        $Logs->Save($LogsValidate->getLogId(), 4, $LogsValidate->getCompanyId(), $LogsValidate->getUserId(), 'calls_activities', $CallsActivitiesValidate->getCallActivityId(), md5('calls' . $CallsActivitiesGetResult->call_id), $LogsHandling->getDefaultData('Chamado!', 'Chamado da atividade <b>"' . $CallsGetResult->name . '"</b> Alterado!', 'warning'), $LogsValidate->getDateRegister());

        /** Result **/
        $result = [

            'code' => 200,
            'procedure' => [
                [
                    'name' => 'PutHtml',
                    'options' => [
                        'target' => 'CallActivityCall' . $CallsActivitiesValidate->getCallActivityId(),
                        'data' => $CallsGetResult->name
                    ]
                ]
            ],
        ];

    } else {

        /** Retorno mensagem de erro */
        throw new InvalidArgumentException('Não foi possivel salvar o registro', 0);

    }

}

/** Envio **/
echo json_encode($result);

/** Paro o procedimento **/
exit;
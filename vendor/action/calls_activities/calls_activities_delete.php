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
$CallsActivitiesValidate->setCallId(@(int)filter_input(INPUT_POST, 'CALL_ID', FILTER_SANITIZE_NUMBER_INT));

/** Verifico a existência de erros */
if (!empty($CallsActivitiesValidate->getErrors())) {

    /** Retorno mensagem de erro */
    throw new InvalidArgumentException($CallsActivitiesValidate->getErrors(), 0);

} else {

    /** Busco o registro desejado */
    $CallsActivitiesGetResult = $CallsActivities->Get($CallsActivitiesValidate->getCallActivityId());

    /** Verifico se o registro é existente */
    if ($CallsActivitiesGetResult->call_activity_id > 0) {

        /** Busco os colaboradores para serem notificados */
        $CallsActivitiesUsersAllByActivityIdResult = $CallsActivitiesUsers->AllByActivityId($CallsActivitiesGetResult->call_activity_id);

        /** Verifico se o usuário foi localizado */
        if ($CallsActivities->delete($CallsActivitiesValidate->getCallActivityId())) {

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
                    $NotificationsValidate->setData(json_encode(['TITLE' => 'Removido!', 'MESSAGE' => 'Atividade "'. '#' . $result->call_activity_id . ' - ' . $result->activity_name . '" Removida!', 'CLASS' => 'danger', 'ICON' => 'image/default/delete.svg'], JSON_PRETTY_PRINT));
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
            $MessagesValidate->setData('Removendo Atividade: ' . '#' . $CallsActivitiesGetResult->call_activity_id . ' - ' . $CallsActivitiesGetResult->name);
            $MessagesValidate->setDateRegister(date('Y/m/d H:i:s'));

            /** Publico uma mensagem */
            $Messages->Save(0, $MessagesValidate->getUserId(), $MessagesValidate->getTable(), $MessagesValidate->getRegisterId(), $MessagesValidate->getData(), $MessagesValidate->getDateRegister());

            /** Log de requisições */
            $Logs->Save($LogsValidate->getLogId(), 4, $LogsValidate->getCompanyId(), $LogsValidate->getUserId(), 'calls_activities', $CallsActivitiesValidate->getCallActivityId(), md5('calls' . $CallsActivitiesGetResult->call_id), $LogsHandling->getDefaultData('Excluído!', 'Atividade <b>"' . $CallsActivitiesGetResult->name . '"</b> Excluída!', 'danger'), $LogsValidate->getDateRegister());

            /** Result **/
            $result = [

                'code' => 200,
                'procedure' => [
                    [
                        'name' => 'RemoveHtml',
                        'options' => [
                            'target' => 'CallActivityContextMenuZone' . $CallsActivitiesValidate->getCallActivityId(),
                        ]
                    ]
                ]

            ];

        } else {

            /** Result **/
            $result = [

                'code' => 0,
                'toast' => [
                    'create' => true,
                    'background' => 'danger',
                    'data' => 'Não foi possível remover a atividade!'
                ]

            ];

        }

    } else {

        /** Result **/
        $result = [

            'code' => 0,
            'toast' => [
                'create' => true,
                'background' => 'danger',
                'data' => 'Não foi possível localizar a atividade!'
            ]

        ];

    }

}

/** Envio **/
echo json_encode($result);

/** Paro o procedimento **/
exit;
<?php

/** Importação de classes */
use vendor\model\Notifications;
use vendor\controller\notifications\NotificationsValidate;
use vendor\model\Messages;
use vendor\controller\messages\MessagesValidate;
use vendor\model\CallsActivities;
use vendor\model\CallsActivitiesUsers;
use vendor\controller\calls_activities_users\CallsActivitiesUsersValidate;

/** Instânciamento de classes */
$Notifications = new Notifications();
$NotificationsValidate = new NotificationsValidate();
$Messages = new Messages();
$MessagesValidate = new MessagesValidate();
$CallsActivities = new CallsActivities();
$CallsActivitiesUsers = new CallsActivitiesUsers();
$CallsActivitiesUsersValidate = new CallsActivitiesUsersValidate();

/** Parâmetros de entrada */
$MessagesValidate->setMessageId(@(int)filter_input(INPUT_POST, 'message_id', FILTER_SANITIZE_SPECIAL_CHARS));
$MessagesValidate->setUserId($_SESSION['USERSID']);
$MessagesValidate->setTable(@(string)filter_input(INPUT_POST, 'message_table', FILTER_SANITIZE_SPECIAL_CHARS));
$MessagesValidate->setRegisterId(@(int)filter_input(INPUT_POST, 'message_register_id', FILTER_SANITIZE_SPECIAL_CHARS));
$MessagesValidate->setReceived(@(int)filter_input(INPUT_POST, 'received', FILTER_SANITIZE_SPECIAL_CHARS));
$MessagesValidate->setViewed(@(int)filter_input(INPUT_POST, 'viewed', FILTER_SANITIZE_SPECIAL_CHARS));
$MessagesValidate->setData($_POST['data']);
$MessagesValidate->setDateRegister(date('Y/m/d H:i:s'));

/** Verifico a existência de erros */
if (!empty($MessagesValidate->getErrors())) {

    /** Retorno mensagem de erro */
    throw new InvalidArgumentException($MessagesValidate->getErrors(), 0);

} else {

    /** Busco o registro desejado */
    $CallsActivitiesGetResult = $CallsActivities->Get($MessagesValidate->getRegisterId());

    /** Verifico se o usuário foi localizado */
    if ($Messages->Save($MessagesValidate->getMessageId(), $MessagesValidate->getUserId(), $MessagesValidate->getTable(), $MessagesValidate->getRegisterId(), $MessagesValidate->getData(), $MessagesValidate->getDateRegister())) {

        /** Busco os colaboradores para serem notificados */
        $CallsActivitiesUsersAllByActivityIdResult = $CallsActivitiesUsers->AllByActivityId($MessagesValidate->getRegisterId());

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
                $NotificationsValidate->setData(json_encode(['TITLE' => 'Nova Mensagem!', 'MESSAGE' => trim(strip_tags($MessagesValidate->getData())) . ' - Atividade "'. '#' . $result->call_activity_id . ' - ' . $result->activity_name . '"', 'CLASS' => 'success', 'ICON' => 'image/default/message.svg'], JSON_PRETTY_PRINT));
                $NotificationsValidate->setDateRegister(date('Y/m/d H:i:s'));

                /** Notificação de Operação */
                $Notifications->Save($NotificationsValidate->getNotificationId(), $NotificationsValidate->getCompanyId(), $NotificationsValidate->getUserId(), $NotificationsValidate->getDestinyUserId(), $NotificationsValidate->getTable(), $NotificationsValidate->getRegisterId(), $NotificationsValidate->getStatus(), $NotificationsValidate->getData(), $NotificationsValidate->getDateRegister());

            }

        }

        /** Log de requisições */
        $Logs->Save($LogsValidate->getLogId(), 4, $LogsValidate->getCompanyId(), $LogsValidate->getUserId(), 'calls_activities', $CallsActivitiesGetResult->call_activity_id, md5('calls' . $CallsActivitiesGetResult->call_id), $LogsHandling->getDefaultData('Mensagem!', 'Nova mensagem publicada', 'warning'), $LogsValidate->getDateRegister());

        /** Result **/
        $result = [

            'code' => 200,
            'title' => 'Sucesso',
            'data' => 'Registro Salvo com Sucesso',
            'redirect' => [
                [
                    'url' => 'FOLDER=VIEW&TABLE=CALLS_ACTIVITIES&ACTION=CALLS_ACTIVITIES_MESSAGES&CALL_ACTIVITY_ID=' . $MessagesValidate->getRegisterId(),
                    'target' => 'CallsActivitiesDetailsWrapper' . $MessagesValidate->getRegisterId(),
                ]
            ],
            'toast' => true,

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
<?php

/** Importação de classes */
use vendor\model\Users;
use vendor\model\Notifications;
use vendor\controller\notifications\NotificationsValidate;
use vendor\model\Messages;
use vendor\controller\messages\MessagesValidate;
use vendor\model\CallsActivities;
use vendor\model\CallsActivitiesUsers;
use vendor\controller\calls_activities_users\CallsActivitiesUsersValidate;

/** Instânciamento de classes */
$Users = new Users();
$Notifications = new Notifications();
$NotificationsValidate = new NotificationsValidate();
$Messages = new Messages();
$MessagesValidate = new MessagesValidate();
$CallsActivities = new CallsActivities();
$CallsActivitiesUsers = new CallsActivitiesUsers();
$CallsActivitiesUsersValidate = new CallsActivitiesUsersValidate();

/** Percorro todos os registros */
foreach ($_POST['call_user_id'] as $keyResult => $result) {

    /** Instânciamento de classes */
    $CallsActivities = new CallsActivities();
    $CallsActivitiesUsers = new CallsActivitiesUsers();
    $CallsActivitiesUsersValidate = new CallsActivitiesUsersValidate();

    /** Parâmetros de entrada */
    $CallsActivitiesUsersValidate->setCallActivityId(@(int)filter_input(INPUT_POST, 'call_activity_id', FILTER_SANITIZE_SPECIAL_CHARS));
    $CallsActivitiesUsersValidate->setUserId($result);
    $CallsActivitiesUsersValidate->setCompanyId(@(int)$_SESSION['USERSCOMPANYID']);

    /** Busco o registro especifico */
    $resultCallsActivities = $CallsActivities->Load($CallsActivitiesUsersValidate->getCallActivityId());
    $UsersGetResult = $Users->Get($result);

    /** Verifico a existência de erros */
    if (!empty($CallsActivitiesUsersValidate->getErrors())) {

        /** Retorno mensagem de erro */
        throw new InvalidArgumentException($CallsActivitiesUsersValidate->getErrors(), 0);

    } else {

        /** Verifico se o usuário foi localizado */
        if ($CallsActivitiesUsers->Save($CallsActivitiesUsersValidate->getCallActivityUserId(), $CallsActivitiesUsersValidate->getCallActivityId(), $resultCallsActivities->call_id, $CallsActivitiesUsersValidate->getUserId(), $CallsActivitiesUsersValidate->getCompanyId())) {

            /** Parâmetros de entrada */
            $NotificationsValidate->setNotificationId(0);
            $NotificationsValidate->setCompanyId((int)$_SESSION['USERSCOMPANYID']);
            $NotificationsValidate->setUserId((int)$_SESSION['USERSID']);
            $NotificationsValidate->setDestinyUserId((int)$result);
            $NotificationsValidate->setTable('calls_activities');
            $NotificationsValidate->setRegisterId((int)$resultCallsActivities->call_activity_id);
            $NotificationsValidate->setStatus(1);
            $NotificationsValidate->setData(json_encode(['TITLE' => 'Vinculado a atividade: #' . $resultCallsActivities->call_activity_id . ' ' . $resultCallsActivities->name . '!', 'MESSAGE' => 'Você foi vinculado a uma nova atividade', 'CLASS' => 'success', 'ICON' => 'image/default/checked.png'], JSON_PRETTY_PRINT));
            $NotificationsValidate->setDateRegister(date('Y/m/d H:i:s'));

            /** Notificação de Operação */
            $Notifications->Save($NotificationsValidate->getNotificationId(), $NotificationsValidate->getCompanyId(), $NotificationsValidate->getUserId(), $NotificationsValidate->getDestinyUserId(), $NotificationsValidate->getTable(), $NotificationsValidate->getRegisterId(), $NotificationsValidate->getStatus(), $NotificationsValidate->getData(), $NotificationsValidate->getDateRegister());

            /** Defino o texto que será postado */
            $MessagesValidate->setUserId((int)$_SESSION['USERSID']);
            $MessagesValidate->setTable('calls_activities');
            $MessagesValidate->setRegisterId((int)$resultCallsActivities->call_activity_id);
            $MessagesValidate->setReceived(0);
            $MessagesValidate->setViewed(0);
            $MessagesValidate->setData('Vinculando o operador: ' . $Main->decryptData($UsersGetResult->name_first) . ' ' . $Main->decryptData($UsersGetResult->name_last));
            $MessagesValidate->setDateRegister(date('Y/m/d H:i:s'));

            /** Publico uma mensagem */
            $Messages->Save(0, $MessagesValidate->getUserId(), $MessagesValidate->getTable(), $MessagesValidate->getRegisterId(), $MessagesValidate->getData(), $MessagesValidate->getDateRegister());

        }

    }

}

/** Result **/
$result = [
    'code' => 200,
    'redirect' => [
        [
            'url' => 'FOLDER=VIEW&TABLE=CALLS_ACTIVITIES_USERS&ACTION=CALLS_ACTIVITIES_USERS_AVATAR_LIST&CALL_ACTIVITY_ID=' . $CallsActivitiesUsersValidate->getCallActivityId() . '&MODAL=1',
            'target' => 'CallsActivitiesUsersAvatarListWrapper' . $CallsActivitiesUsersValidate->getCallActivityId(),
        ],
        [
            'url' => 'FOLDER=VIEW&TABLE=CALLS_ACTIVITIES_USERS&ACTION=CALLS_ACTIVITIES_USERS_AVATAR_LIST&CALL_ACTIVITY_ID=' . $CallsActivitiesUsersValidate->getCallActivityId() . '&MODAL=1',
            'target' => 'CallsActivitiesDatagridSectionAvatar' . $CallsActivitiesUsersValidate->getCallActivityId(),
        ]
    ],
    'procedure' => [
        [
            'name' => 'RemoveHtml',
            'options' => [
                'target' => 'callsActivitiesUsersForm'
            ]
        ],
    ]
];

/** Envio **/
echo json_encode($result);

/** Paro o procedimento **/
exit;
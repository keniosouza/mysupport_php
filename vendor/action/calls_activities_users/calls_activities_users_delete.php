<?php

/** Importação de classes */
use vendor\model\Messages;
use vendor\controller\messages\MessagesValidate;
use vendor\model\CallsActivitiesUsers;
use vendor\controller\calls_activities_users\CallsActivitiesUsersValidate;

/** Instânciamento de classes */
$Messages = new Messages();
$MessagesValidate = new MessagesValidate();
$CallsActivitiesUsers = new CallsActivitiesUsers();
$CallsActivitiesUsersValidate = new CallsActivitiesUsersValidate();

/** Parâmetros de entrada */
$CallsActivitiesUsersValidate->setCallActivityUserId(@(int)filter_input(INPUT_POST, 'CALL_ACTIVITY_USER_ID', FILTER_SANITIZE_SPECIAL_CHARS));

/** Verifico a existência de erros */
if (!empty($CallsActivitiesUsersValidate->getErrors())) {

    /** Retorno mensagem de erro */
    throw new InvalidArgumentException($CallsActivitiesUsersValidate->getErrors(), 0);

} else {

    /** Busco o registro desejado */
    $CallsActivitiesUsersLoadResult = $CallsActivitiesUsers->Load($CallsActivitiesUsersValidate->getCallActivityUserId());

    /** Verifico se o usuário foi localizado */
    if ($CallsActivitiesUsers->delete($CallsActivitiesUsersValidate->getCallActivityUserId())) {

        /** Defino o texto que será postado */
        $MessagesValidate->setUserId((int)$_SESSION['USERSID']);
        $MessagesValidate->setTable('calls_activities');
        $MessagesValidate->setRegisterId((int)$CallsActivitiesUsersLoadResult->call_activity_id);
        $MessagesValidate->setReceived(0);
        $MessagesValidate->setViewed(0);
        $MessagesValidate->setData('Removendo o operador: ' . $Main->decryptData($CallsActivitiesUsersLoadResult->name_first) . ' ' . $Main->decryptData($CallsActivitiesUsersLoadResult->name_last));
        $MessagesValidate->setDateRegister(date('Y/m/d H:i:s'));

        /** Publico uma mensagem */
        $Messages->Save(0, $MessagesValidate->getUserId(), $MessagesValidate->getTable(), $MessagesValidate->getRegisterId(), $MessagesValidate->getData(), $MessagesValidate->getDateRegister());

        /** Log de requisições */
        $Logs->Save($LogsValidate->getLogId(), 4, $LogsValidate->getCompanyId(), $LogsValidate->getUserId(), 'calls_activities_users', $CallsActivitiesUsersValidate->getCallActivityUserId(), md5('calls' . $CallsActivitiesUsersLoadResult->call_id), $LogsHandling->getDefaultData('Excluído!', 'Participação na Atividade <b>"' . $CallsActivitiesUsersLoadResult->name . '"</b> Excluída!', 'danger'), $LogsValidate->getDateRegister());

        /** Result **/
        $result = [

            'code' => 200,
            'title' => 'Sucesso',
            'data' => 'Operador removido',
            'redirect' => [
                [
                    'url' => 'FOLDER=VIEW&TABLE=CALLS_ACTIVITIES&ACTION=CALLS_ACTIVITIES_DETAILS&CALL_ACTIVITY_ID=' . $CallsActivitiesUsersLoadResult->call_activity_id . '&MODAL=0',
                    'target' => 'CallsActivitiesUsersAvatarListWrapper' . $CallsActivitiesUsersLoadResult->call_activity_id,
                ]
            ],
            'toast' => true,

        ];

    } else {

        /** Retorno mensagem de erro */
        throw new InvalidArgumentException('Não foi possivel remover o registro', 0);

    }

}

/** Envio **/
echo json_encode($result);

/** Paro o procedimento **/
exit;
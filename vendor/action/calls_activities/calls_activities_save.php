<?php

/** Importação de classes */
use vendor\model\Users;
use vendor\model\Notifications;
use vendor\controller\notifications\NotificationsValidate;
use vendor\model\CallsActivitiesUsers;
use vendor\model\CallsActivities;
use vendor\controller\calls_activities\CallsActivitiesValidate;

/** Instânciamento de classes */
$Users = new Users();
$Notifications = new Notifications();
$NotificationsValidate = new NotificationsValidate();
$CallsActivitiesUsers = new CallsActivitiesUsers();
$CallsActivities = new CallsActivities();
$CallsActivitiesValidate = new CallsActivitiesValidate();

/** Parâmetros de entrada */
$CallsActivitiesValidate->setCallActivityId(@(int)filter_input(INPUT_POST, 'call_activity_id', FILTER_SANITIZE_NUMBER_INT));
$CallsActivitiesValidate->setCallId(@(int)filter_input(INPUT_POST, 'call_id', FILTER_SANITIZE_NUMBER_INT));
$CallsActivitiesValidate->setSectionId(@(int)filter_input(INPUT_POST, 'section_id', FILTER_SANITIZE_NUMBER_INT));
$CallsActivitiesValidate->setCompanyId(@(int)$_SESSION['USERSCOMPANYID']);
$CallsActivitiesValidate->setName(@(string)filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS));
$CallsActivitiesValidate->setDescription(@(string)$_POST['description']);
$CallsActivitiesValidate->setKeywords(@(string)filter_input(INPUT_POST, 'keywords', FILTER_SANITIZE_SPECIAL_CHARS));

/** Verifico a existência de erros */
if (!empty($CallsActivitiesValidate->getErrors())) {

    /** Retorno mensagem de erro */
    throw new InvalidArgumentException($CallsActivitiesValidate->getErrors(),  0);

} else {

    /** Verifico se o usuário foi localizado */
    if ($CallsActivities->Save($CallsActivitiesValidate->getCallActivityId(), $CallsActivitiesValidate->getCallId(), $CallsActivitiesValidate->getCompanyId(), $CallsActivitiesValidate->getSectionId(), $CallsActivitiesValidate->getName(), $CallsActivitiesValidate->getDescription(), $CallsActivitiesValidate->getKeywords())) {

        /** Result **/
        $result = [

            'code' => 200,
            'title' => 'Sucesso',
            'data' => 'Atividade salva com sucesso!',
            'toast' => true,
            'redirect' => [
                [
                    'url' => 'FOLDER=VIEW&TABLE=CALLS_ACTIVITIES&ACTION=CALLS_ACTIVITIES_DATAGRID&CALL_ID=' . $CallsActivitiesValidate->getCallId(),
                    'target' => 'CallsDetailsWrapper',
                ]
            ]

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
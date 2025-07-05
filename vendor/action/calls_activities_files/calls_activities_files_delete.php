<?php

/** Importação de classes */
use vendor\model\Files;
use vendor\controller\files\FilesValidate;
use vendor\model\CallsActivities;
use vendor\controller\calls_activities\CallsActivitiesValidate;

/** Instânciamento de classes */
$Files = new Files();
$FilesValidate = new FilesValidate();
$CallsActivities = new CallsActivities();
$CallsActivitiesValidate = new CallsActivitiesValidate();

try {

    /** Parâmetros de entrada */
    $FilesValidate->setFileId(@(int)filter_input(INPUT_POST, 'FILE_ID', FILTER_SANITIZE_SPECIAL_CHARS));
    $CallsActivitiesValidate->setCallActivityId(@(int)filter_input(INPUT_POST, 'CALL_ACTIVITY_ID', FILTER_SANITIZE_SPECIAL_CHARS));
    $CallsActivitiesValidate->setCallId(@(int)filter_input(INPUT_POST, 'CALL_ID', FILTER_SANITIZE_SPECIAL_CHARS));

    /** Verifico a existência de erros */
    if (!empty($CallsActivitiesValidate->getErrors())) {

        /** Retorno mensagem de erro */
        throw new InvalidArgumentException($CallsActivitiesValidate->getErrors(), 0);

    } else {

        /** Busco o registro desejado */
        $resultFiles = $Files->Get($FilesValidate->getFileId());

        /** Busco o registro desejado */
        $resultCallsActivities = $CallsActivities->Get($CallsActivitiesValidate->getCallActivityId());

        /** Verifico se o usuário foi localizado */
        if ($Files->Delete((int)$resultFiles->file_id)) {

            /** Removo o arquivo do disco */
            unlink((string)$resultFiles->path . '/' . $resultFiles->name);

            /** Log de requisições */
            $Logs->Save($LogsValidate->getLogId(), 4, $LogsValidate->getCompanyId(), $LogsValidate->getUserId(), 'calls_activities_files', $CallsActivitiesValidate->getCallActivityId(), md5('calls' . $resultCallsActivities->call_id), $LogsHandling->getDefaultData('Arquivo!', 'Arquivo Removido da Atividade <b>"' . $resultCallsActivities->name . '"</b>', 'danger'), $LogsValidate->getDateRegister());

            /** Result **/
            $result = [

                'code' => 200,
                'title' => 'Sucesso',
                'redirect' => [
                    [
                        'url' => 'FOLDER=VIEW&TABLE=CALLS_ACTIVITIES&ACTION=CALLS_ACTIVITIES_DETAILS&CALL_ID=' . $CallsActivitiesUsersValidate->getCallId() . '&CALL_ACTIVITY_ID=' . $CallsActivitiesUsersValidate->getCallActivityId()
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

} catch (Exception $exception) {

    /** Preparo o formulario para retorno **/
    $result = [

        'code' => 0,
        'message' => '<div class="alert alert-danger" role="alert">' . $exception->getMessage() . '</div>',
        'title' => 'Atenção',
        'type' => 'exception',

    ];

    /** Envio **/
    echo json_encode($result);

    /** Paro o procedimento **/
    exit;

}
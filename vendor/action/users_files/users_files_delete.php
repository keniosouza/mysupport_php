<?php

/** Importação de classes */
use vendor\model\Files;
use vendor\controller\files\FilesValidate;
use vendor\model\CallsActivitiesUsers;
use vendor\controller\calls_activities_users\CallsActivitiesUsersValidate;

/** Instânciamento de classes */
$Files = new Files();
$FilesValidate = new FilesValidate();
$CallsActivitiesUsers = new CallsActivitiesUsers();
$CallsActivitiesUsersValidate = new CallsActivitiesUsersValidate();

try {

    /** Parâmetros de entrada */
    $FilesValidate->setFileId(@(int)filter_input(INPUT_POST, 'FILE_ID', FILTER_SANITIZE_SPECIAL_CHARS));
    $CallsActivitiesUsersValidate->setCallActivityId(@(int)filter_input(INPUT_POST, 'CALL_ACTIVITY_ID', FILTER_SANITIZE_SPECIAL_CHARS));
    $CallsActivitiesUsersValidate->setCallId(@(int)filter_input(INPUT_POST, 'CALL_ID', FILTER_SANITIZE_SPECIAL_CHARS));

    /** Verifico a existência de erros */
    if (!empty($CallsActivitiesUsersValidate->getErrors())) {

        /** Retorno mensagem de erro */
        throw new InvalidArgumentException($CallsActivitiesUsersValidate->getErrors(), 0);

    } else {

        /** Busco o registro desejado */
        $resultFiles = $Files->Get($FilesValidate->getFileId());

        /** Verifico se o usuário foi localizado */
        if ($Files->Delete((int)$resultFiles->file_id)) {

            /** Removo o arquivo do disco */
            unlink((string)$resultFiles->path . '/' . $resultFiles->name);

            /** Result **/
            $result = [

                'code' => 200,
                'title' => 'Sucesso',
                'message' => 'Operador vinculado com sucesso',
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
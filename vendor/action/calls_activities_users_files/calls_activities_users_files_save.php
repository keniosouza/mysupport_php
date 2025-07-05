<?php

/** Importação de classes  */
use vendor\model\Files;
use vendor\controller\files\FilesValidate;
use vendor\controller\files\FilesProcedures;

use vendor\model\CallsActivitiesUsers;
use vendor\controller\calls_activities_users\CallsActivitiesUsersValidate;

/** Instânciamento de classes  */
$Files = new Files();
$FilesValidate = new FilesValidate();
$FilesProcedures = new FilesProcedures();

$CallsActivitiesUsers = new CallsActivitiesUsers();
$CallsActivitiesUsersValidate = new CallsActivitiesUsersValidate();

/** Parametros de entrada dos PRODUTOS  */
$callActivityUserId = (int)filter_input(INPUT_POST, 'call_activity_user_id', FILTER_SANITIZE_SPECIAL_CHARS);

/** Parametros de entrada dos ARQUIVOS */
$fileId = (int)filter_input(INPUT_POST, 'file_id', FILTER_SANITIZE_SPECIAL_CHARS);
$registerId = (int)filter_input(INPUT_POST, 'call_activity_user_id', FILTER_SANITIZE_SPECIAL_CHARS);
$table = 'calls_activities_users';

/** Parâmetros de entrada dos ARQUIVOS */
$name = (string)filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
$hash = $_POST['hash'];

/** Validando os campos de entrada */
$CallsActivitiesUsersValidate->setCallActivityUserId($callActivityUserId);

/** Define o local do arquivo e realiza validações */
$FilesValidate->setFileId($fileId);
$FilesValidate->setRegisterId($registerId);
$FilesValidate->setTable($table);
$FilesValidate->setGenerateHistory();
$FilesValidate->setPath('temp/' . $hash);
$FilesValidate->setName($name);

/** Verifica a existência de erros durante a validação */
if (!empty($FilesValidate->getErrors())) {

    /** Caso ocorra algum erro, lança uma exceção com a mensagem de erro. */
    throw new InvalidArgumentException($FilesValidate->getErrors(), 0);

} else {

    /** Busco a RELEASE DO PRODUTO desejado */
    $CallsActivitiesUsersLoadResult = $CallsActivitiesUsers->Load($CallsActivitiesUsersValidate->getCallActivityUserId());

    /** Defino o local do arquivo */
    $FilesValidate->setPath('document/calls/' . $CallsActivitiesUsersLoadResult->call_id . '_call/' . $CallsActivitiesUsersLoadResult->call_activity_id . '_call_activity/' . $CallsActivitiesUsersLoadResult->call_activity_user_id . '_call_activity_user/');

    /** Realizo a junção das partes do arquivo */
    $FilesProcedures->merge('temp/' . $hash, $FilesValidate->getName(), $FilesValidate->getPath());

    /** Busco o registro desejado */
    $resultCallsActivitiesUsers = $CallsActivitiesUsers->Load($CallsActivitiesUsersValidate->getCallActivityUserId());

    /** Efetua um novo cadastro ou salva os novos dados */
    if ($Files->Save($FilesValidate->getFileId(), $FilesValidate->getRegisterId(), $FilesValidate->getTable(), $FilesValidate->getName(), $FilesValidate->getPath(), $FilesValidate->getGenerateHistory())) {

        /** Log de requisições */
        $Logs->Save($LogsValidate->getLogId(), 4, $LogsValidate->getCompanyId(), $LogsValidate->getUserId(), 'calls_activities_users_files', $CallsActivitiesUsersValidate->getCallActivityUserId(), md5('calls' . $resultCallsActivitiesUsers->call_id), $LogsHandling->getDefaultData('Publicado!', 'Novo arquivo publicado!', 'success'), $LogsValidate->getDateRegister());

        /** Result **/
        $result = [

            'code' => 200,
            'title' => 'Sucesso',
            'data' => $Main->generateAlertHtml('success', 'Atenção', 'Registro Salvo com sucesso'),
            'redirect' => 'FOLDER=VIEW&TABLE=CALLS_ACTIVITIES_USERS_FILES&ACTION=CALLS_ACTIVITIES_USERS_FILES_DATAGRID&CALL_ACTIVITY_USER_ID=' . $CallsActivitiesUsersLoadResult->call_activity_user_id,
            'target' => 'pills-files-datagrid',

        ];

    } else {

        /** Caso ocorra algum erro, informo */
        throw new InvalidArgumentException('Não foi possível atualizar o cadastro', 0);

    }

}

/** Envio do resultado em formato JSON */
echo json_encode($result);

/** Encerra o procedimento */
exit;

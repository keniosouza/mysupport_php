<?php

/** Importação de classes  */
use vendor\model\Files;
use vendor\controller\files\FilesValidate;
use vendor\controller\files\FilesProcedures;

use vendor\model\Calls;
use vendor\controller\calls\CallsValidate;

/** Instânciamento de classes  */
$Files = new Files();
$FilesValidate = new FilesValidate();
$FilesProcedures = new FilesProcedures();

$Calls = new Calls();
$CallsValidate = new CallsValidate();

/** Parametros de entrada dos PRODUTOS  */
$callId = (int)filter_input(INPUT_POST, 'call_id', FILTER_SANITIZE_SPECIAL_CHARS);

/** Parametros de entrada dos ARQUIVOS */
$fileId = (int)filter_input(INPUT_POST, 'file_id', FILTER_SANITIZE_SPECIAL_CHARS);
$registerId = (int)filter_input(INPUT_POST, 'call_id', FILTER_SANITIZE_SPECIAL_CHARS);
$table = 'calls';

/** Parâmetros de entrada dos ARQUIVOS */
$name = (string)filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
$hash = $_POST['hash'];

/** Validando os campos de entrada */
$CallsValidate->setCallId($callId);

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
    $CallsLoadResult = $Calls->Load($CallsValidate->getCallId());

    /** Defino o local do arquivo */
    $FilesValidate->setPath('document/calls/' . $CallsLoadResult->call_id . '_call/');

    /** Realizo a junção das partes do arquivo */
    $FilesProcedures->merge('temp/' . $hash, $FilesValidate->getName(), $FilesValidate->getPath());

    /** Efetua um novo cadastro ou salva os novos dados */
    if ($Files->Save($FilesValidate->getFileId(), $FilesValidate->getRegisterId(), $FilesValidate->getTable(), $FilesValidate->getName(), $FilesValidate->getPath(), $FilesValidate->getGenerateHistory())) {

        /** Result **/
        $result = [

            'code' => 200,
            'title' => 'Sucesso',
            'data' => $Main->generateAlertHtml('success', 'Atenção', 'Registro Salvo com sucesso'),
            'redirect' => 'FOLDER=VIEW&TABLE=CALLS_FILES&ACTION=CALLS_FILES_DATAGRID&CALL_ID=' . $CallsLoadResult->call_id,
            'target' => 'CallsActivitiesAndFilesDatagrid',

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

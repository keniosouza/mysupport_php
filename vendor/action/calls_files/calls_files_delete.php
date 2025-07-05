<?php

/** Importação de classes */
use vendor\model\Files;
use vendor\controller\files\FilesValidate;
use vendor\model\Calls;
use vendor\controller\calls\CallsValidate;

/** Instânciamento de classes */
$Files = new Files();
$FilesValidate = new FilesValidate();
$Calls = new Calls();
$CallsValidate = new CallsValidate();

/** Parâmetros de entrada */
$FilesValidate->setFileId(@(int)filter_input(INPUT_POST, 'FILE_ID', FILTER_SANITIZE_SPECIAL_CHARS));
$CallsValidate->setCallId(@(int)filter_input(INPUT_POST, 'CALL_ID', FILTER_SANITIZE_SPECIAL_CHARS));

/** Verifico a existência de erros */
if (!empty($CallsValidate->getErrors())) {

    /** Retorno mensagem de erro */
    throw new InvalidArgumentException($CallsValidate->getErrors(), 0);

} else {

    /** Busco o registro desejado */
    $FilesGetResult = $Files->Get($FilesValidate->getFileId());

    /** Verifico se o usuário foi localizado */
    if ($Files->Delete((int)$FilesGetResult->file_id)) {

        /** Removo o arquivo do disco */
        unlink((string)$FilesGetResult->path . '/' . $FilesGetResult->name);

        /** Result **/
        $result = [

            'code' => 200,
            'title' => 'Sucesso',
            'data' => $Main->generateAlertHtml('success', 'Atenção', 'Registro Salvo com sucesso'),
            'redirect' => [
                [
                    'url' => 'FOLDER=VIEW&TABLE=CALLS_FILES&ACTION=CALLS_FILES_DATAGRID&CALL_ID=' . $CallsValidate->getCallId(),
                    'target' => 'CallsActivitiesAndFilesDatagrid',
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
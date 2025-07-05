<?php

/** Importação de classes  */
use vendor\model\Files;
use vendor\controller\files\FilesValidate;
use vendor\controller\files\FilesProcedures;
use vendor\model\Calls;
use vendor\controller\calls\CallsValidate;
use vendor\controller\history\HistoryValidate;

try {

    /** Instânciamento de classes  */
    $Files = new Files();
    $FilesValidate = new FilesValidate();
    $FilesProcedures = new FilesProcedures();
    $Calls = new Calls();
    $CallsValidate = new CallsValidate();
    $HistoryValidate = new HistoryValidate();

    /** Parametros de entrada do CHAMADO ATIVIDADE  */
    $callId = (int)filter_input(INPUT_POST, 'call_id', FILTER_SANITIZE_SPECIAL_CHARS);

    /** Parametros de entrada dos ARQUIVOS */
    $fileId = (int)filter_input(INPUT_POST, 'file_id', FILTER_SANITIZE_SPECIAL_CHARS);
    $registerId = (int)filter_input(INPUT_POST, 'call_id', FILTER_SANITIZE_SPECIAL_CHARS);
    $table = 'calls';
    $name = (string)filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
    $base64 = $_POST['base64'];
    $extension = (string)filter_input(INPUT_POST, 'extension', FILTER_SANITIZE_SPECIAL_CHARS);

    /** Validando os campos de entrada do CHAMADO ATIVIDADE */
    $CallsValidate->setCallId($callId);

    /** Validando os campos de entrada do ARQUIVO */
    $FilesValidate->setFileId($fileId);
    $FilesValidate->setRegisterId($registerId);
    $FilesValidate->setTable($table);
    $FilesValidate->setName($name);
    $FilesValidate->setGenerateHistory();
    $FilesValidate->setBase64($base64);
    $FilesValidate->setExtension($extension);
    $FilesValidate->setHistory($HistoryValidate->generate(null, 'Arquivos!', 'Novo arquivo vinculado: ' . $FilesValidate->getName(), 'rounded-pill text-bg-primary', @(string)$_SESSION['USERSNAMEFIRST']));

    /** Verifico a existência de erros */
    if (!empty($FilesValidate->getErrors())) {

        /** Caso ocorra algum erro, informo */
        throw new InvalidArgumentException($FilesValidate->getErrors(), 0);

    } else {

        /** Busco o CHAMADO desejado */
        $resultCalls = $Calls->Load($CallsValidate->getCallId());

        /** Defino o local do arquivo */
        $FilesValidate->setPath('document/calls/' . $resultCalls->call_id . '_call/');

        /** Gero o arquivo desejado */
        $FilesProcedures->generate($FilesValidate->getPath(), $FilesValidate->getName() . '.' . $FilesValidate->getExtension(), $FilesValidate->getBase64());

        /** Efetua um novo cadastro ou salva os novos dados */
        if ($Files->Save($FilesValidate->getFileId(), $FilesValidate->getRegisterId(), $FilesValidate->getTable(), $FilesValidate->getName() . '.' . $FilesValidate->getExtension(), $FilesValidate->getPath(), $FilesValidate->getHistory())) {

            /** Result **/
            $result = [

                'code' => 200,
                'title' => 'Sucesso',
                'redirect' => 'FOLDER=VIEW&TABLE=CALLS&ACTION=CALLS_DETAILS&CALL_ID=' . $CallsValidate->getCallId()

            ];

        } else {

            /** Caso ocorra algum erro, informo */
            throw new InvalidArgumentException('Não foi possível atualizar o cadastro', 0);

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
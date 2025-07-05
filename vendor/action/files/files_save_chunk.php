<?php

/** Importação de classes  */
use vendor\model\Files;
use vendor\controller\files\FilesValidate;
use vendor\controller\files\FilesProcedures;

/** Instânciamento de classes  */
$Files = new Files();
$FilesValidate = new FilesValidate();
$FilesProcedures = new FilesProcedures();

/** Parâmetros de entrada dos ARQUIVOS */
$name = (string)filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
$base64 = $_POST['base64'];
$hash = $_POST['hash'];
$chunkPart = $_POST['chunkPart'];
$chunkSize = $_POST['chunkSize'];
$extension = (string)filter_input(INPUT_POST, 'extension', FILTER_SANITIZE_SPECIAL_CHARS);

/** Define o local do arquivo e realiza validações */
$FilesValidate->setPath('temp/' . $hash);
$FilesValidate->setBase64($base64);
$FilesValidate->setName($name);

/** Verifica a existência de erros durante a validação */
if (!empty($FilesValidate->getErrors())) {

    /** Caso ocorra algum erro, lança uma exceção com a mensagem de erro. */
    throw new InvalidArgumentException($FilesValidate->getErrors(), 0);

} else {

    /** Gera o arquivo desejado com base nas informações fornecidas. */
    $FilesProcedures->generate($FilesValidate->getPath(), $chunkPart . '_part', $base64);

    /** Result **/
    $result = [

        'code' => 200,
        'title' => 'Atenção',
        'data' => 'Enviando',
        'merge' => $chunkPart === $chunkSize ? true : false,

    ];

}

/** Envio do resultado em formato JSON */
echo json_encode($result);

/** Encerra o procedimento */
exit;

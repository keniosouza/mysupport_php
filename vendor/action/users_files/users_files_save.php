<?php

/** Importação de classes  */
use vendor\model\Files;
use vendor\controller\files\FilesValidate;
use vendor\controller\files\FilesProcedures;
use vendor\model\Users;
use vendor\controller\users\UsersValidate;

/** Instânciamento de classes  */
$Files = new Files();
$FilesValidate = new FilesValidate();
$FilesProcedures = new FilesProcedures();
$Users = new Users();
$UsersValidate = new UsersValidate();

/** Parametros de entrada dos PRODUTOS  */
$userId = (int)filter_input(INPUT_POST, 'USERS_ID', FILTER_SANITIZE_SPECIAL_CHARS);

/** Parametros de entrada dos ARQUIVOS */
$fileId = (int)filter_input(INPUT_POST, 'file_id', FILTER_SANITIZE_SPECIAL_CHARS);
$registerId = (int)filter_input(INPUT_POST, 'USERS_ID', FILTER_SANITIZE_SPECIAL_CHARS);
$table = 'users';

/** Parâmetros de entrada dos ARQUIVOS */
$name = strtolower((string)filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS));
$hash = $_POST['hash'];

/** Validando os campos de entrada */
$UsersValidate->setUsersId($userId);

/** Define o local do arquivo e realiza validações */
$FilesValidate->setFileId($fileId);
$FilesValidate->setRegisterId($registerId);
$FilesValidate->setTable($table);
$FilesValidate->setGenerateHistory();
$FilesValidate->setPath('temp/' . $hash);
$FilesValidate->setName($name);
$FilesValidate->setCrop((object)json_decode($_POST['crop']));

/** Verifica a existência de erros durante a validação */
if (!empty($FilesValidate->getErrors())) {

    /** Caso ocorra algum erro, lança uma exceção com a mensagem de erro. */
    throw new InvalidArgumentException($FilesValidate->getErrors(), 0);

} else {

    /** Busco as preferencias de arquivos de usuário */
    $MainConfigResult = $Main->LoadConfigPublic()->app->files->users;

    /** Busco a RELEASE DO PRODUTO desejado */
    $UsersGetResult = $Users->Get($UsersValidate->getUsersId());

    /** Defino o local do arquivo */
    $FilesValidate->setPath('document/users/' . $UsersGetResult->users_id . '_user/');

    /** Realizo a junção das partes do arquivo */
    $FilesProcedures->merge('temp/' . $hash, $FilesValidate->getName(), $FilesValidate->getPath());

    /** Verifico se preciso converter para jpg */
    if (strtolower(pathinfo($FilesValidate->getPath() . $FilesValidate->getName(), PATHINFO_EXTENSION)) === 'png')
    {

        /** Realizo o recorte de imagem */
        $FilesProcedures->ConvertPngToJpg($FilesValidate->getPath(), $FilesValidate->getName());

        /** Removo o arquivo antigo */
        $FilesProcedures->remove($FilesValidate->getPath() . '/' . $FilesValidate->getName());

        /** Atualizo o nome do arquivo */
        $FilesValidate->setName(str_replace('png', 'jpg', $FilesValidate->getName()));

    }

    /** Realizo o recorte de imagem */
    $FilesProcedures->CropJPG($FilesValidate->getPath(), $FilesValidate->getName(), $FilesValidate->getCrop());

    /** Realizo o redimensionamento de imagem */
    foreach ($MainConfigResult as $key => $result)
    {

        /** Executo a função */
        $FilesProcedures->ResizeJPG($FilesValidate->getPath(), $FilesValidate->getName(), $result);

    }

    /** Efetua um novo cadastro ou salva os novos dados */
    if ($Files->Save($FilesValidate->getFileId(), $FilesValidate->getRegisterId(), $FilesValidate->getTable(), $FilesValidate->getName(), $FilesValidate->getPath(), $FilesValidate->getGenerateHistory())) {

        /** Result **/
        $result = [

            'code' => 200,
            'data' => 'Perfil Atualizado',
            'toast' => [
                'create' => true,
                'background' => 'primary',
                'data' => 'Perfil Atualizado'
            ],
            'redirect' => 'FOLDER=VIEW&TABLE=USERS&ACTION=USERS_PROFILE&USER_ID=' . $UsersValidate->getUsersId(),

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

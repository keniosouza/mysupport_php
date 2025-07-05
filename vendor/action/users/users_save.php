<?php

/** Importação de classes  */
use vendor\model\Users;
use vendor\controller\users\UsersValidate;

/** Instânciamento de classes  */
$Users = new Users();
$UsersValidate = new UsersValidate();

/** Parametros de entrada  */
$usersId = isset($_POST['users_id']) ? (int)filter_input(INPUT_POST, 'users_id', FILTER_SANITIZE_SPECIAL_CHARS) : 0;
$nameFirst = isset($_POST['name_first']) ? (string)filter_input(INPUT_POST, 'name_first', FILTER_SANITIZE_SPECIAL_CHARS) : '';
$nameLast = isset($_POST['name_last']) ? (string)filter_input(INPUT_POST, 'name_last', FILTER_SANITIZE_SPECIAL_CHARS) : '';
$email = isset($_POST['email']) ? (string)filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL) : '';
$birthDate = isset($_POST['birth_date']) ? (string)filter_input(INPUT_POST, 'birth_date', FILTER_SANITIZE_SPECIAL_CHARS) : '';
$genre = isset($_POST['genre']) ? (string)filter_input(INPUT_POST, 'genre', FILTER_SANITIZE_SPECIAL_CHARS) : '';
$active = isset($_POST['active']) ? (string)filter_input(INPUT_POST, 'active', FILTER_SANITIZE_SPECIAL_CHARS) : '';
$administrator = isset($_POST['administrator']) ? (string)filter_input(INPUT_POST, 'administrator', FILTER_SANITIZE_SPECIAL_CHARS) : '';

/** Validando os campos de entrada */
$UsersValidate->setUsersId($usersId);
$UsersValidate->setNameFirst($nameFirst);
$UsersValidate->setNameLast($nameLast);
$UsersValidate->setEmail($email);
$UsersValidate->setBirthDate($birthDate);
$UsersValidate->setGenre($genre);
$UsersValidate->setActive($active);
$UsersValidate->setAdministrator($administrator);

/** Verifico a existência de erros */
if (!empty($UsersValidate->getErrors())) {

    /** Caso existam erro(s), retorna os mesmos **/
    throw new InvalidArgumentException($UsersValidate->getErrors());

} else {

    /** Efetua um novo cadastro ou salva os novos dados */
    if ($Users->Save($UsersValidate->getUsersId(), $UsersValidate->getNameFirst(), $UsersValidate->getNameLast(), $UsersValidate->getEmail(), $UsersValidate->getBirthDate(), $UsersValidate->getGenre(), $UsersValidate->getActive(), $UsersValidate->getAdministrator())) {

        /** Result **/
        $result = [

            'code' => 200,
            'data' => 'Perfil Atualizado',
            'toast' => true,
            'redirect' => [
                [
                    'url' => 'FOLDER=VIEW&TABLE=USERS&ACTION=USERS_PROFILE&USER_ID=' . $UsersValidate->getUsersId(),
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
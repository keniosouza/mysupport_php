<?php

/** Importação de classes  */
use vendor\model\Users;
use vendor\controller\users\UsersValidate;
use vendor\controller\mail\Mail;

/** Instânciamento de classes  */
$Users = new Users();
$UsersValidate = new UsersValidate();
$Mail = new Mail();

/** Parametros de entrada  */
$usersId = isset($_POST['USER_ID']) ? (int)filter_input(INPUT_POST, 'USER_ID', FILTER_SANITIZE_SPECIAL_CHARS) : 0;
$password = isset($_POST['password']) ? (string)filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS) : '';

/** Validando os campos de entrada */
$UsersValidate->setUsersId($usersId);
$UsersValidate->setPassword($password);

/** Verifico a existência de erros */
if (!empty($UsersValidate->getErrors())) {

    /** Caso existam erro(s), retorna os mesmos **/
    throw new InvalidArgumentException($UsersValidate->getErrors());

} else {

    /** Realizo a busca por email */
    $UsersGetResult = $Users->Get($UsersValidate->getUsersId());

    /** Verifico se o email ja foi informado anteriormente */
    if ($UsersGetResult->users_id > 0)
    {

        /** Efetua um novo cadastro ou salva os novos dados */
        if ($Users->UpdatePassword($UsersValidate->getPassword(), $UsersValidate->getUsersId())) {

            /** Result **/
            $result = [

                'code' => 200,
                'title' => 'Sucesso',
                'data' => 'Senha atualizada com sucesso',
                'toast' => true,
                'type' => 'info'

            ];

        } else {

            /** Retorno mensagem de erro */
            throw new InvalidArgumentException('A senha não pode ser atualizada', 0);

        }

    }
    else
    {

        /** Retorno mensagem de erro */
        throw new InvalidArgumentException('Não foi localizado o usuário informado', 0);

    }

}

/** Envio **/
echo json_encode($result);

/** Paro o procedimento **/
exit;
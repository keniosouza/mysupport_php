<?php

/** Importação de classes  */
use vendor\model\Users;
use vendor\controller\users\UsersValidate;
use vendor\model\Company;
use vendor\controller\mail\Mail;
use vendor\controller\main\Main;

/** Instânciamento de classes  */
$Users = new Users();
$UsersValidate = new UsersValidate();
$Company = new Company();
$Mail = new Mail();
$Main = new Main();

/** Variaveis padrão */
$MainConfigResult = $Main->LoadConfigPublic();

/** Parametros de entrada  */
$usersId = isset($_POST['users_id']) ? (int)filter_input(INPUT_POST, 'users_id', FILTER_SANITIZE_SPECIAL_CHARS) : 0;
$companyId = $MainConfigResult->app->company;
$nameFirst = isset($_POST['name_first']) ? (string)filter_input(INPUT_POST, 'name_first', FILTER_SANITIZE_SPECIAL_CHARS) : '';
$nameLast = isset($_POST['name_last']) ? (string)filter_input(INPUT_POST, 'name_last', FILTER_SANITIZE_SPECIAL_CHARS) : '';
$email = isset($_POST['email']) ? (string)filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL) : '';
$active = 'N';
$password = isset($_POST['password']) ? (string)filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS) : '';

/** Validando os campos de entrada */
$UsersValidate->setUsersId($usersId);
$UsersValidate->setCompanyId($companyId);
$UsersValidate->setNameFirst($nameFirst);
$UsersValidate->setNameLast($nameLast);
$UsersValidate->setEmail($email);
$UsersValidate->setActive($active);
$UsersValidate->setPassword($password);

/** Verifico a existência de erros */
if (!empty($UsersValidate->getErrors())) {

    /** Caso existam erro(s), retorna os mesmos **/
    throw new InvalidArgumentException($UsersValidate->getErrors());

} else {

    /** Realizo a busca por email */
    $UsersCheckMailResult = $Users->checkMail($UsersValidate->getEmail());

    /** Verifico se o email ja foi informado anteriormente */
    if (count($UsersCheckMailResult) === 0)
    {

        /** Efetua um novo cadastro ou salva os novos dados */
        if ($Users->Register($UsersValidate->getUsersId(), $UsersValidate->getCompanyId(), $UsersValidate->getNameFirst(), $UsersValidate->getNameLast(), $UsersValidate->getEmail(), $UsersValidate->getActive(), $UsersValidate->getPassword())) {

            /** Result **/
            $result = [

                'code' => 200,
                'title' => 'Sucesso',
                'data' => 'O pedido de registro foi concluído com êxito. Por favor, aguarde a aprovação do administrador para acessar.',
                'type' => 'info'

            ];

        } else {

            /** Informa o resultado positivo **/
            $result = [

                'code' => 0,
                'toast' => [
                    'create' => true,
                    'background' => 'primary',
                    'data' => 'Não foi possível salvar o registro'
                ]

            ];

        }

    }
    else
    {

        /** Informa o resultado positivo **/
        $result = [

            'code' => 0,
            'toast' => [
                'create' => true,
                'background' => 'primary',
                'data' => 'O email informado já foi utilizado'
            ]

        ];

    }

}

/** Envio **/
echo json_encode($result);

/** Paro o procedimento **/
exit;
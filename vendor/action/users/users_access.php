<?php

/** Importação de classes  */
use vendor\controller\main\Main;
use vendor\controller\users\UsersValidate;
use vendor\controller\users_acls\UsersAclsValidate;
use vendor\model\Users;
use vendor\model\UsersAcls;
use vendor\model\Files;

/** Instânciamento de classes  */
$Main = new Main();
$Users = new Users();
$UsersValidate = new UsersValidate();
$Files = new Files();

$UsersAcls = new UsersAcls();
$UsersAclsValidate = new UsersAclsValidate();

/** Parametros de entrada  */
$session        = (bool)filter_input(INPUT_POST, 'SESSION', FILTER_SANITIZE_SPECIAL_CHARS);
$userEmail      = isset($_POST['email'])      ? (string)filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL)              : '';
$userPassword   = isset($_POST['password'])   ? (string)filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS)   : '';
$rememberAccess = isset($_POST['remember_access']) ? (string)filter_input(INPUT_POST, 'remember_access', FILTER_SANITIZE_SPECIAL_CHARS) : '';

/** Validando os campos de entrada */
$UsersValidate->setEmail($userEmail);
$UsersValidate->setPassword($userPassword);

/** Verifica se não existem erros a serem informados */
if (!empty($UsersValidate->getErrors())) {

    /** Informo */
    throw new InvalidArgumentException($UsersValidate->getErrors(), 0);

} else {

    /** Consulta o usuário junto ao banco de dados para verificar se é o primeiro acesso*/
    $UsersAccessResult = $Users->Access2($UsersValidate->getEmail());

    /** Verifico se foi localizado o email */
    if ((int)$UsersAccessResult->users_id > 0)
    {

        /** Verifico se as senhas são iguais */
        if (password_verify($UsersValidate->getPassword(), $UsersAccessResult->password))
        {

            /** Carrega as configurações de criptografia */
            $config = $Main->LoadConfigPublic();

            /** Parametros para descriptografar dados */
            $method = $config->{'app'}->{'security'}->{'method'};
            $firstKey = $config->{'app'}->{'security'}->{'first_key'};

            /** Inicia a sessão do usuário */
            $Main->SessionStart();

            /** Cria as sessões pessoais necessárias para o usuário */
            $_SESSION['USERSID'] = (int)$UsersAccessResult->users_id;
            $_SESSION['USERSNAMEFIRST'] = $Main->decryptData((string)$UsersAccessResult->name_first);

            /** Cria as sessões da empresa a qual o usuário está vinculado */
            $_SESSION['USERSCOMPANYID'] = (int)$UsersAccessResult->company_id;

            /** Cria o Token do usuário */
            $_SESSION['USERSTOKEN'] = $Main->encryptData($config->app->security->hash . '-' . (int)$UsersAccessResult->users_id . '-' . session_id());

            /** Inicialização da sessão do usuário */
            $_SESSION['USERSSTARTTIME'] = date("Y-m-d H:i:s");

            /** Busco as permissões */
            $resultUsersAcls = $UsersAcls->All((int)$UsersAccessResult->users_id);

            /** Defino as prefências d eimpressão */
            $permission = array();

            /** Monto as permissões */
            foreach ($resultUsersAcls as $key => $result) {

                /** Guardo todas as permissões dentro do grupo */
                foreach (json_decode($result->preferences) as $keyPreference => $resultPreference) {

                    /** Guardo a permissão dentro do grupo */
                    $permission[strtolower(str_replace(' ', '_', $Main->RemoveSpecialChars($result->name)))][strtolower($resultPreference)] = 'true';

                }

            }

            /** Codifico as permissões */
            $permission = json_encode($permission, JSON_PRETTY_PRINT);

            /** Gero arquivo de permissão temporária */
            file_put_contents('temp/permissions/' . md5($_SESSION['USERSID']) . '.json', $permission);

            /** Verifico se devo redirecionar a página */
            if (!$session)
            {

                /** Informa o resultado positivo **/
                $result = [

                    'code' => 202,
                    'url' => $config->app->url_aplication, # Define uma url especifica dentro da aplicação para carregar

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
                    'data' => 'Senha inválida'
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
                'data' => 'Usuário não localizado, verifique o seu e-mail e senha.'
            ]

        ];

    }

}

/** Devolvo o json com as informações **/
echo json_encode($result);

/** Paro o procedimento **/
exit;

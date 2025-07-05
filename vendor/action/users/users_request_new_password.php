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
$email = isset($_POST['email']) ? (string)filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL) : null;

/** Validando os campos de entrada */
$UsersValidate->setEmail($email);

/** Verifica se não existem erros a serem informados */
if (!empty($UsersValidate->getErrors())) {

    /** Informo */
    throw new InvalidArgumentException($UsersValidate->getErrors(), 0);

} else {

    /** Consulta o usuário junto ao banco de dados para verificar se é o primeiro acesso*/
    $UsersAccessResult = $Users->Access2($UsersValidate->getEmail(), $UsersValidate->getPassword());

    /** Verifico se foi localizado o email */
    if ((int)$UsersAccessResult->users_id > 0)
    {

        /** Variaveis padrão */
        $Config = $Main->LoadConfigPublic();

        /** Dados para serem transformados em hash */
        $data = new stdClass();
        $data->user_id = $UsersAccessResult->users_id;
        $data->reset = true;

        /** Defino o hash de definição */
        $UsersAccessResult->hash = base64_encode(json_encode($data));

        /** Defino a url de request */
        $UsersAccessResult->request = $Config->app->url_aplication . 'redefenir/' . $UsersAccessResult->hash;

        /** Inicio a coleta de dados */
        ob_start();

        /** Inclusão do arquivo desejado */
        @include_once 'vendor/view/users/users_request_new_password_email.php';

        /** Prego a estrutura do arquivo */
        $html = ob_get_contents();

        /** Removo o arquivo incluido */
        ob_clean();

        /** Obtenho as configurações de email */
        $Config = $Main->LoadConfigPublic();

        /** Crio um novo objeto */
        $data = new stdClass();
        $data->email = $UsersAccessResult->email;
        $data->name = $Main->decryptData($UsersAccessResult->name_first);
        $subject = 'Recuperação de senha';

        /** Realizo o envio do email */
        $Mail->send($html, $data, $subject, $Config->app->mail);

        /** Result **/
        $result = [

            'code' => 200,
            'title' => 'Sucesso',
            'data' => 'Um email com as instruções de redefinição de senha foi enviado',
            'type' => 'info'

        ];

    }
    else
    {

        /** Mensagem de erro */
        throw new InvalidArgumentException('Usuário não localizado, verifique o seu e-mail e senha.', 0);

    }

}

/** Devolvo o json com as informações **/
echo json_encode($result);

/** Paro o procedimento **/
exit;

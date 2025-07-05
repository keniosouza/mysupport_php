<?php

/** Ativo a exibição de erros */
error_reporting(E_ALL);
ini_set('display_errors', 'On');

/** Importação do Autoload lado servidor */
require_once('./vendor/autoload.php');

/** Importação de classes */
use vendor\model\Logs;
use vendor\controller\logs\LogsValidate;
use vendor\controller\logs\LogsHandling;
use vendor\controller\main\Main;
use vendor\controller\routers\RouterValidate;

/** Instânciamento de classes */
$Logs = new Logs();
$LogsValidate = new LogsValidate();
$LogsHandling = new LogsHandling();

$Main = new Main();
$RouterValidate = new RouterValidate();

/** Atualiza a sessão */
$Main->SessionStart();

/** Parâmetros de Entrada */
$RouterValidate->setTable(@(string)filter_input(INPUT_POST, 'TABLE', FILTER_SANITIZE_SPECIAL_CHARS));
$RouterValidate->setAction(@(string)filter_input(INPUT_POST, 'ACTION', FILTER_SANITIZE_SPECIAL_CHARS));
$RouterValidate->setFolder(@(string)filter_input(INPUT_POST, 'FOLDER', FILTER_SANITIZE_SPECIAL_CHARS));

/** Definição dos parâmetros de Log */
$LogsValidate->setLogId(0);
$LogsValidate->setCompanyId(@(int)$_SESSION['USERSCOMPANYID']);
$LogsValidate->setUserId(@(int)$_SESSION['USERSID']);
$LogsValidate->setTable($RouterValidate->getTable());
$LogsValidate->setRegisterId(@(int)filter_input(INPUT_POST, 'REGISTER_ID', FILTER_SANITIZE_SPECIAL_CHARS));
$LogsValidate->setDateRegister(date('Y/m/d H:i:s'));

/** Informo a aplicação para carregar as configurações correspondentes */
$resultConfig = $Main->LoadConfigPublic();

/** Busco a permissão do usuário */
$resultUserAcl = $Main->LoadUserAcl();

/** Constroles */
$authenticate = null;
$result = null;
$resultException = null;
$resultValidate = null;
$resultRequest = null;

try {

    /** Verifico a existência de erros */
    if (!empty($RouterValidate->getErrors())) {

        /** Mensagem de erro */
        throw new Exception($RouterValidate->getErrors());

    } else {

        /** Verifico se o arquivo de ação existe */
        if (is_file($RouterValidate->getFullPath())) {

            /** Inicio a coleta de dados */
            ob_start();

            /** Inclusão do arquivo desejado */
            @include_once $RouterValidate->getFullPath();

            /** Prego a estrutura do arquivo */
            $data = ob_get_contents();

            /** Removo o arquivo incluido */
            ob_end_clean();

            /** Result **/
            $result = array(

                'code' => 100,
                'data' => $data

            );

            /** Verifico se devo realizar o log */
            if (@(int)$_SESSION['USERSID'] > 0 && $resultConfig->app->log->active) {

                /** Escrevo a mensagem de requisição */
                $_POST['CLASS'] = 'success';

                /** Defino os novos dados de log */
                $LogsValidate->setLogTypeId(1);
                $LogsValidate->setData(json_encode($_POST, JSON_PRETTY_PRINT));

                /** Log de requisições */
                $Logs->Save($LogsValidate->getLogId(), $LogsValidate->getLogTypeId(), $LogsValidate->getCompanyId(), $LogsValidate->getUserId(), $LogsValidate->getTable(), $LogsValidate->getRegisterId(), $LogsValidate->getHash(), $LogsValidate->getData(), $LogsValidate->getDateRegister());

            }

        } else {

            /** Mensagem de erro */
            throw new Exception('Erro :: Não há arquivo para ação informada.');

        }

    }

    /** Envio **/
    echo json_encode($result);

    /** Paro o procedimento **/
    exit;

} catch (Exception $exception) {

    /** Verifico se o usuário esta autenticado */
    if (@(int)$_SESSION['USERSID'] > 0 && $resultConfig->app->log->active) {

        /** Escrevo a mensagem de requisição */
        $_POST['EXCEPTION'] = $exception->getFile() . '; Linha: ' . $exception->getLine() . '; Código: ' . $exception->getCode() . '; Mensagem: ' . $exception->getMessage();
        $_POST['CLASS'] = 'warning';

        /** Defino os novos dados de log */
        $LogsValidate->setLogTypeId(2);
        $LogsValidate->setData(json_encode($_POST, JSON_PRETTY_PRINT));

        /** Log de requisições */
        $Logs->Save($LogsValidate->getLogId(), $LogsValidate->getLogTypeId(), $LogsValidate->getCompanyId(), $LogsValidate->getUserId(), $LogsValidate->getTable(), $LogsValidate->getRegisterId(), $LogsValidate->getHash(), $LogsValidate->getData(), $LogsValidate->getDateRegister());

    }

    /** Verifico o ambiente que a aplicação esta */
    if ($resultConfig->app->environment == 'development') {

        /** Tratamento da mensagem de erro */
        $resultException = '<b>Arquivo:</b> ' . $exception->getFile() . '; <b>Linha:</b> ' . $exception->getLine() . '; <b>Código:</b> ' . $exception->getCode();

    }

    /** Caso existam validações a serem apresentadas, informo */
    $resultValidate = $Main->generateAlertHtml('warning', 'Atenção', ($exception->getMessage() !== null ? $exception->getMessage() : null));

    /** Verifico o ambiente que a aplicação esta */
    if ($resultConfig->app->environment == 'development') {

        /** Obtenho a lista de objetos enviados pela rede */
        $resultRequest = $Main->generateAlertHtml('danger', 'Dados Enviados', $Main->generateList($_POST));
    }

    /** Removo o arquivo incluido */
    ob_end_clean();

    /** Preparo o formulario para retorno **/
    $result = [

        'code' => 0,
        'title' => 'Atenção',
        'data' => $resultException . $resultValidate . $resultRequest,
        'create' => true,
        'size' => 'md',
        'color_modal' => null,
        'color_border' => 'warning',
        'type' => 'alert',
        'procedure' => null,
        'time' => null,
        'authenticate' => $authenticate

    ];

    /** Envio **/
    echo json_encode($result);

    /** Paro o procedimento **/
    exit;

} catch (Error $error) {

    /** Verifico se o usuário esta autenticado */
    if (@(int)$_SESSION['USERSID'] > 0 && $resultConfig->app->log->active) {

        /** Escrevo a mensagem de requisição */
        $_POST['ERROR'] = $error->getFile() . '; Linha: ' . $error->getLine() . '; Código: ' . $error->getCode() . '; Mensagem: ' . $error->getMessage();
        $_POST['CLASS'] = 'danger';

        /** Defino os novos dados de log */
        $LogsValidate->setLogTypeId(3);
        $LogsValidate->setData(json_encode($_POST, JSON_PRETTY_PRINT));

        /** Log de requisições */
        $Logs->Save($LogsValidate->getLogId(), $LogsValidate->getLogTypeId(), $LogsValidate->getCompanyId(), $LogsValidate->getUserId(), $LogsValidate->getTable(), $LogsValidate->getRegisterId(), $LogsValidate->getHash(), $LogsValidate->getData(), $LogsValidate->getDateRegister());

    }

    /** Verifico o ambiente que a aplicação esta */
    if ($resultConfig->app->environment == 'development') {

        /** Tratamento da mensagem de erro */
        $resultException = '<b>Arquivo:</b> ' . $error->getFile() . '; <b>Linha:</b> ' . $error->getLine() . '; <b>Código:</b> ' . $error->getCode();

    }

    /** Caso existam validações a serem apresentadas, informo */
    $resultValidate = $Main->generateAlertHtml('danger', 'Atenção', ($error->getMessage() !== null ? $error->getMessage() : ''));

    /** Verifico o ambiente que a aplicação esta */
    if ($resultConfig->app->environment == 'development') {

        /** Obtenho a lista de objetos enviados pela rede */
        $resultRequest = $Main->generateAlertHtml('danger', 'Dados Enviados', $Main->generateList($_POST));

    }

    /** Removo o arquivo incluido */
    ob_end_clean();

    /** Preparo o formulario para retorno **/
    $result = [

        'code' => 0,
        'title' => 'Atenção',
        'data' => $resultException . $resultValidate . $resultRequest,
        'create' => true,
        'size' => 'md',
        'color_modal' => null,
        'color_border' => 'danger',
        'type' => 'error',
        'procedure' => null,
        'time' => null,
        'authenticate' => $authenticate

    ];

    /** Envio **/
    echo json_encode($result);

    /** Paro o procedimento **/
    exit;

}

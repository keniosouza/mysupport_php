<?php

/** Importação de classes */
use \vendor\controller\main\Main;

/** Instânciamento de classes */
$Main = new Main();

/** Variaveis padrão */
$Config = $Main->LoadConfigPublic();

// destroi a sessao
@session_destroy();

// gera um novo id para a sessao
@session_regenerate_id();

/** Informa o resultado positivo **/
$result = [

    'code' => 202,
    'url' => $Config->app->url_aplication

];

/** Envio **/
echo json_encode($result);

/** Paro o procedimento **/
exit;
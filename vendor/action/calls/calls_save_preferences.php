<?php

/** Importação de classes */
use vendor\model\Calls;
use vendor\controller\calls\CallsValidate;

/** Instânciamento de classes */
$Calls = new Calls();
$CallsValidate = new CallsValidate();

/** Parâmetros de entrada */
$CallsValidate->setCallId(@(int)filter_input(INPUT_POST, 'call_id', FILTER_SANITIZE_SPECIAL_CHARS));
$CallsValidate->setPreferences(json_encode(['image' => @(string)$_POST['image']], JSON_PRETTY_PRINT));

/** Verifico a existência de erros */
if (!empty($CallsValidate->getErrors())) {

    /** Caso existam erro(s), retorna os mesmos **/
    throw new InvalidArgumentException($CallsValidate->getErrors());

} else {

    /** Verifico se o usuário foi localizado */
    if ($Calls->SavePreferences($CallsValidate->getCallId(), $CallsValidate->getPreferences())) {

        /** Result **/
        $result = [

            'code' => 200,
            'title' => 'Sucesso',
            'data' => 'Icono do chamado alterado!',
            'toast' => true,
            'redirect' => [
                [
                    'url' => 'FOLDER=VIEW&TABLE=CALLS&ACTION=CALLS_HOME&CALL_ID=' . $CallsValidate->getCallId(),
                    'target' => 'CallsHome'
                ]
            ]

        ];

    } else {

        /** Retorno mensagem de erro */
        throw new InvalidArgumentException('Não foi possivel salvar o registro', 0);

    }

}

/** Devolvo o json com as informações **/
echo json_encode($result);

/** Paro o procedimento **/
exit;
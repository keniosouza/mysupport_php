<?php

/** Importação de classes */
use vendor\controller\calls\CallsValidate;
use vendor\model\Clients;
use vendor\model\CallsClients;
use vendor\controller\calls_clients\CallsClientsValidate;
use vendor\controller\history\HistoryValidate;

try {

    /** Instânciamento de classes */
    $CallsValidate = new CallsValidate();
    $Clients = new Clients();
    $CallsClients = new CallsClients();
    $CallsClientsValidate = new CallsClientsValidate();
    $HistoryValidate = new HistoryValidate();

    /** Lista de nomes dos clientes */
    $clients = null;

    /** Percorro todos os registros */
    foreach ($_POST['call_client_id'] as $keyResult => $result) {

        /** Parâmetros de entrada */
        $CallsClientsValidate->setCallClientId(@(int)filter_input(INPUT_POST, 'call_client_id', FILTER_SANITIZE_NUMBER_INT));
        $CallsClientsValidate->setCallId(@(int)filter_input(INPUT_POST, 'call_id', FILTER_SANITIZE_NUMBER_INT));
        $CallsClientsValidate->setClientId(@(int)$result);
        $CallsClientsValidate->setCompanyId(@(int)$_SESSION['USERSCOMPANYID']);

        /** Verifico a existência de erros */
        if (!empty($CallsClientsValidate->getErrors())) {

            /** Retorno mensagem de erro */
            throw new InvalidArgumentException($CallsClientsValidate->getErrors(), 0);

        } else {

            /** Busco o registro desejado */
            $resultClient = $Clients->Get($CallsClientsValidate->getClientId());

            /** Montagem do histórico */
            $CallsClientsValidate->setHistory($HistoryValidate->generate(null, 'Cliente!', 'Novo cliente vinculado: ' . $resultClient->fantasy_name, 'rounded-pill text-bg-primary', @(string)$_SESSION['USERSNAMEFIRST']));

            /** Verifico se o usuário foi localizado */
            if ($CallsClients->Save($CallsClientsValidate->getCallClientId(), $CallsClientsValidate->getCallId(), $CallsClientsValidate->getClientId(), $CallsClientsValidate->getCompanyId(), $CallsClientsValidate->getHistory())) {

                /** Result **/
                $result = [

                    'code' => 200,
                    'title' => 'Sucesso',
                    'redirect' => [
                        [
                            'url' => 'FOLDER=VIEW&TABLE=CALLS&ACTION=CALLS_DETAILS&CALL_ID=' . $CallsClientsValidate->getCallId()
                        ]
                    ]

                ];

            } else {

                /** Retorno mensagem de erro */
                throw new InvalidArgumentException('Não foi possivel salvar o registro', 0);

            }

        }

    }

    /** Envio **/
    echo json_encode($result);

    /** Paro o procedimento **/
    exit;

} catch (Exception $exception) {

    /** Preparo o formulario para retorno **/
    $result = [

        'code' => 0,
        'message' => '<div class="alert alert-danger" role="alert">' . $exception->getMessage() . '</div>',
        'title' => 'Atenção',
        'type' => 'exception',

    ];

    /** Envio **/
    echo json_encode($result);

    /** Paro o procedimento **/
    exit;

}
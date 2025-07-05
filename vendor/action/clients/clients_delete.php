<?php

/** Importação de classes */
use vendor\model\Clients;
use vendor\controller\clients\ClientsValidate;

/** Instânciamento de classes */
$Clients = new Clients();
$ClientsValidate = new ClientsValidate();

try {

    /** Parâmetros de entrada */
    $ClientsValidate->setClientsId(@(int)filter_input(INPUT_POST, 'CLIENTS_ID', FILTER_SANITIZE_NUMBER_INT));

    /** Verifico a existência de erros */
    if (!empty($ClientsValidate->getErrors())) {

        /** Retorno mensagem de erro */
        throw new InvalidArgumentException($ClientsValidate->getErrors(), 0);

    } else {

        /** Verifico se o usuário foi localizado */
        if ($Clients->delete($ClientsValidate->getClientsId()))
        {

            /** Result **/
            $result = [

                'code' => 200,
                'title' => 'Sucesso',
                'message' => 'Registro removido com sucesso',
                'redirect' => [
                    [
                        'url' => 'FOLDER=VIEW&TABLE=CLIENTS&ACTION=CLIENTS_DATAGRID'
                    ]
                ]

            ];

        } else {

            /** Retorno mensagem de erro */
            throw new InvalidArgumentException('Não foi possivel remover o registro', 0);

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
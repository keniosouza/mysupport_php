<?php

/** Importação de classes */
use vendor\model\Calls;
use vendor\controller\calls\CallsValidate;

/** Instânciamento de classes */
$Calls = new Calls();
$CallsValidate = new CallsValidate();

try {

    /** Parâmetros de entrada */
    $CallsValidate->setCallId(@(int)filter_input(INPUT_POST, 'CALL_ID', FILTER_SANITIZE_NUMBER_INT));

    /** Verifico a existência de erros */
    if (!empty($CallsValidate->getErrors())) {

        /** Retorno mensagem de erro */
        throw new InvalidArgumentException($CallsValidate->getErrors(), 0);

    } else {

        /** Busco o registro desejado */
        $resultCall = $Calls->get($CallsValidate->getCallId());

        /** Verifico se o usuário foi localizado */
        if ($Calls->delete($CallsValidate->getCallId())) {

            /** Log de requisições */
            $Logs->Save($LogsValidate->getLogId(), 4, $LogsValidate->getCompanyId(), $LogsValidate->getUserId(), 'calls', $CallsValidate->getCallId(), md5('calls' . $CallsValidate->getCallId()), $LogsHandling->getDefaultData('Excluído!', 'Chamado "<b>' . $resultCall->name . '</b>" Excluído!', 'danger'), $LogsValidate->getDateRegister());

            /** Result **/
            $result = [

                'code' => 200,
                'title' => 'Sucesso',
                'redirect' => [
                    [
                        'url' => 'FOLDER=VIEW&TABLE=CALLS&ACTION=CALLS_DATAGRID'
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
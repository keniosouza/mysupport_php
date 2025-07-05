<?php

/** Importação de classes */
use vendor\model\Calls;
use vendor\controller\calls\CallsValidate;
use vendor\model\Messages;
use vendor\controller\messages\MessagesValidate;

/** Instânciamento de classes */
$Calls = new Calls();
$CallsValidate = new CallsValidate();
$Messages = new Messages();
$MessagesValidate = new MessagesValidate();

/** Parâmetros de entrada */
$CallsValidate->setCallId(@(int)filter_input(INPUT_POST, 'call_id', FILTER_SANITIZE_SPECIAL_CHARS));
$CallsValidate->setCompanyId(@(int)$_SESSION['USERSCOMPANYID']);
$CallsValidate->setName(@(string)filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS));
$CallsValidate->setDescription(@(string)$_POST['description']);

/** Verifico a existência de erros */
if (!empty($CallsValidate->getErrors())) {

    /** Caso existam erro(s), retorna os mesmos **/
    throw new InvalidArgumentException($CallsValidate->getErrors());

} else {

    /** Verifico se o usuário foi localizado */
    if ($Calls->Save($CallsValidate->getCallId(), $CallsValidate->getCompanyId(), $CallsValidate->getName(), $CallsValidate->getDescription())) {

        /** Busco o último registro gerado */
        $CallsGetLastResult = $Calls->GetLast();

        /** Defino o texto que será postado */
        $MessagesValidate->setUserId((int)$_SESSION['USERSID']);
        $MessagesValidate->setTable('calls');
        $MessagesValidate->setRegisterId((int)$CallsGetLastResult->call_id);
        $MessagesValidate->setReceived(0);
        $MessagesValidate->setViewed(0);
        $MessagesValidate->setData($CallsValidate->getCallId() === 0 ? 'Registrando novo chamado: ' . $CallsGetLastResult->name : 'Salvando os dados do: ' . $CallsGetLastResult->name);
        $MessagesValidate->setDateRegister(date('Y/m/d H:i:s'));

        /** Publico uma mensagem */
        $Messages->Save(0, $MessagesValidate->getUserId(), $MessagesValidate->getTable(), $MessagesValidate->getRegisterId(), $MessagesValidate->getData(), $MessagesValidate->getDateRegister());

        /** Log de requisições */
        $Logs->Save($LogsValidate->getLogId(), 4, $LogsValidate->getCompanyId(), $LogsValidate->getUserId(), 'calls', $CallsGetLastResult->call_id, md5('calls' . $CallsGetLastResult->call_id), $LogsHandling->getDefaultData('Chamado!', $CallsValidate->getCallId() === 0 ? 'Registrando novo chamado: ' . $CallsGetLastResult->name : 'Salvando os dados do: ' . $CallsGetLastResult->name, 'warning'), $LogsValidate->getDateRegister());

        /** Result **/
        $result = [

            'code' => 200,
            'title' => 'Sucesso',
            'data' => 'Registro Salvo com Sucesso',
            'toast' => true,
            'redirect' => [
                [
                    'url' => 'FOLDER=VIEW&TABLE=CALLS&ACTION=CALLS_DATAGRID'
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
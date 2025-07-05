<?php

/** Importação de classes */
use vendor\model\Messages;
use vendor\controller\messages\MessagesValidate;

/** Instânciamento de classes */
$Messages = new Messages();
$MessagesValidate = new MessagesValidate();

/** Parâmetros de entrada */
$MessagesValidate->setMessageId(@(int)filter_input(INPUT_POST, 'message_id', FILTER_SANITIZE_SPECIAL_CHARS));
$MessagesValidate->setUserId($_SESSION['USERSID']);
$MessagesValidate->setTable(@(string)filter_input(INPUT_POST, 'message_table', FILTER_SANITIZE_SPECIAL_CHARS));
$MessagesValidate->setRegisterId(@(int)filter_input(INPUT_POST, 'message_register_id', FILTER_SANITIZE_SPECIAL_CHARS));
$MessagesValidate->setData(@(string)filter_input(INPUT_POST, 'data', FILTER_SANITIZE_SPECIAL_CHARS));
$MessagesValidate->setDateRegister(date('Y/m/d H:i:s'));

/** Verifico a existência de erros */
if (!empty($MessagesValidate->getErrors())) {

    /** Retorno mensagem de erro */
    throw new InvalidArgumentException($MessagesValidate->getErrors(), 0);

} else {

    /** Verifico se o usuário foi localizado */
    if ($Messages->Save($MessagesValidate->getMessageId(), $MessagesValidate->getUserId(), $MessagesValidate->getTable(), $MessagesValidate->getRegisterId(), $MessagesValidate->getData(), $MessagesValidate->getDateRegister())) {

        /** Result **/
        $result = [

            'code' => 200,
            'title' => 'Sucesso',
            'data' => 'Registro Salvo com Sucesso',
            'toast' => true,

        ];

    } else {

        /** Retorno mensagem de erro */
        throw new InvalidArgumentException('Não foi possivel salvar o registro', 0);

    }

}

/** Envio **/
echo json_encode($result);

/** Paro o procedimento **/
exit;
<?php

/** Importação de classes */
use vendor\model\ClientsBackupsLogs;
use vendor\controller\clients_backups_logs\ClientsBackupsLogsValidate;

/** Instânciamento de classes */
$ClientsBackupsLogs = new ClientsBackupsLogs();
$ClientsBackupsLogsValidate = new ClientsBackupsLogsValidate();

/** Obtenho os dados enviados */
$data = (object)json_decode($_POST['data']);

/** Controle de retornos */
$response = array();

/** Percorro por todos os arquivos enviados */
foreach ($data->files as $key => $result)
{

    /** Variavel temporaria de mensagens */
    $temp = new stdClass();

    /** Parâmetros de entrada */
    $ClientsBackupsLogsValidate->setClientBackupLogId(0);
    $ClientsBackupsLogsValidate->setClientId(@(int)$data->client_id);
    $ClientsBackupsLogsValidate->setPath(@(string)$result->path);
    $ClientsBackupsLogsValidate->setName(@(string)$result->name);
    $ClientsBackupsLogsValidate->setSize(@(string)$result->size);
    $ClientsBackupsLogsValidate->setDateModified(@(string)$result->date_modified);

    /** Verifico a existência de erros */
    if (!empty($ClientsBackupsLogsValidate->getErrors())) {

        /** Caso existam erro(s), retorna os mesmos **/
        throw new InvalidArgumentException($ClientsBackupsLogsValidate->getErrors());

    } else {

        /** Verifico se o usuário foi localizado */
        if ($ClientsBackupsLogs->Save($ClientsBackupsLogsValidate->getClientBackupLogId(), $ClientsBackupsLogsValidate->getClientId(), $ClientsBackupsLogsValidate->getPath(), $ClientsBackupsLogsValidate->getName(), $ClientsBackupsLogsValidate->getSize(), $ClientsBackupsLogsValidate->getDateModified())) {

            /** Result **/
            $temp->code = 200;
            $temp->title = 'Sucesso';
            $temp->name = $ClientsBackupsLogsValidate->getName();
            $temp->path = $ClientsBackupsLogsValidate->getPath();
            $temp->size = $ClientsBackupsLogsValidate->getSize();
            $temp->date_modified = $ClientsBackupsLogsValidate->getDateModified();
            $temp->data = 'Arquivo registrado com sucesso';

            /** Guardo a mensagem temporária em uma array */
            array_push($response, $temp);

        } else {

            /** Result **/
            $temp->code = 0;
            $temp->title = 'Erro';
            $temp->name = $ClientsBackupsLogsValidate->getName();
            $temp->path = $ClientsBackupsLogsValidate->getPath();
            $temp->size = $ClientsBackupsLogsValidate->getSize();
            $temp->date_modified = $ClientsBackupsLogsValidate->getDateModified();
            $temp->data = 'Não foi possivel registrar o arquivo';

            /** Guardo a mensagem temporária em uma array */
            array_push($response, $temp);

        }

    }

}

/** Devolvo o json com as informações **/
echo json_encode($response, JSON_PRETTY_PRINT);

/** Paro o procedimento **/
exit;
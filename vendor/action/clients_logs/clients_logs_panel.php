<?php

/** Importação de classes */
use vendor\model\ClientsLogs;

/** Instânciamento de classes */
$ClientsLogs = new ClientsLogs();

$ClientsLogsGetLastResult = $ClientsLogs->GetLast();

/** Result **/
$result = [

    'code' => 200,
    'procedure' => [
        [
            'name' => 'ClientsLogPanelRefresh',
            'options' => [
                'data' => $ClientsLogsGetLastResult
            ]
        ]
    ],

];

/** Devolvo o json com as informações **/
echo json_encode($result);

/** Paro o procedimento **/
exit;
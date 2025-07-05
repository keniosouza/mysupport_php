<?php

/** Importação de classes */
use vendor\model\ClientsLogs;

/** Instânciamento de classes */
$ClientsLogs = new ClientsLogs();

/** Parâmetros de entrada */
$dateStart = $_POST['DATE_START'];
$dateEnd = $_POST['DATE_END'];

/** Realizo a busca das informações */
$ClientsLogsGetLastResult = $ClientsLogs->GroupByProductId($dateStart, $dateEnd);

/** Result **/
$result = [

    'code' => 200,
    'procedure' => [
        [
            'name' => 'ClientsLogDashboardRefreshPie',
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
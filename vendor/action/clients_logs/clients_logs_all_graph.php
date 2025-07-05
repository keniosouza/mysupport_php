<?php

/** Importação de classes */
use vendor\model\ClientsLogs;

/** Instânciamento de classes */
$ClientsLogs = new ClientsLogs();

/** Parâmetros de entrada */
$dateStart = $_POST['DATE_START'];
$dateEnd = $_POST['DATE_END'];

/** Result **/
$result = [

    'code' => 200,
    'procedure' => [
        [
            'name' => 'ClientsLogDashboardRefreshLine',
            'options' => [
                'legends' => $ClientsLogs->AllLegendsGraphByLogTypeId(1, $dateStart, $dateEnd),
                'data' => $ClientsLogs->AllGraphByLogTypeId(1, $dateStart, $dateEnd)
            ]
        ]
    ],

];

/** Devolvo o json com as informações **/
echo json_encode($result);

/** Paro o procedimento **/
exit;
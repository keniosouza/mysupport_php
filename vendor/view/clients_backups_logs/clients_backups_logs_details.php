<?php

/** Importação de classes */
use \vendor\model\ClientsBackupsLogs;
use \vendor\controller\clients_backups_logs\ClientsBackupsLogsValidate;

/** Instânciamento de classes */
$ClientsBackupsLogs = new ClientsBackupsLogs();
$ClientsBackupsLogsValidate = new ClientsBackupsLogsValidate();

/** Tratamento dos dados de entrada */
$ClientsBackupsLogsValidate->setClientBackupLogId(@(int)$_POST['CLIENT_BACKUP_LOG_ID']);

/** Verifico se existe registro */
if ($ClientsBackupsLogsValidate->getClientBackupLogId() > 0) {

    /** Busca de registro */
    $ClientsBackupsLogsGetResult = $ClientsBackupsLogs->Get($ClientsBackupsLogsValidate->getClientBackupLogId());

}

?>

    <ol class="list-group list-group-numbered shadow-sm">

        <li class="list-group-item d-flex justify-content-between align-items-start">

            <div class="ms-2 me-auto">

                <div class="fw-bold">

                    <?php echo $ClientsBackupsLogsGetResult->name?> - <?php echo date('d/m/Y H:s:i', strtotime($ClientsBackupsLogsGetResult->date_modified))?>

                </div>

                <?php echo $ClientsBackupsLogsGetResult->path?>

            </div>

            <span class="badge bg-primary rounded-pill">

                <?php echo $ClientsBackupsLogsGetResult->size ?>
<!--                --><?php //echo $Main->formatFileSize($ClientsBackupsLogsGetResult->size) ?>

            </span>

        </li>

    </ol>

<?php

/** Prego a estrutura do arquivo */
$html = ob_get_contents();

/** Removo o arquivo incluido */
ob_clean();

/** Result **/
$result = array(

    'code' => 201,
    'title' => 'Clientes / Backups / Logs / Detalhes',
    'data' => $html,
    'size' => 'lg',
    'color_modal' => null,
    'color_border' => null,
    'type' => null,
    'procedure' => null,
    'time' => null

);

/** Envio **/
echo json_encode($result);

/** Paro o procedimento **/
exit;
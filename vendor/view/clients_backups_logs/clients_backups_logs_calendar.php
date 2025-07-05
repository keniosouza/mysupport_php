<?php

/** Importação de classes */
use \vendor\model\ClientsBackupsLogs;

/** Instânciamento de classes */
$ClientsBackupsLogs = new ClientsBackupsLogs();

/** Busco todos os registros */
$ClientsBackupsLogsAllResult = $ClientsBackupsLogs->All(@(int)$_POST['CLIENT_ID']);

/** Variavel para guardar os dados do calendário */
$resultCalendar = [];

/** Percorro todos os registros */
foreach ($ClientsBackupsLogsAllResult as $key => $result) {

    /** Converto o nome do arquivo em array */
    $result->data = explode('_', $result->name);

    /** Verifico o tipo de classe que devo utilizar */
    switch ($result->data[0])
    {

        /** Backup Anual */
        case 'nb0';

            $result->class = 'success';
            break;


        /** Backup Mensal */
        case 'nb1';

            $result->class = 'info';
            break;

        /** Backup Semanal */
        case 'nb2';

            $result->class = 'primary';
            break;


        /** Backup Diário */
        case 'nb3';

            $result->class = 'warning';
            break;


        /** Backup 30 */
        case 'nb4';

            $result->class = 'danger';
            break;

    }

    /** Formato os dados para estrutura do calendário */
    $resultTemp = new stdClass();
    $resultTemp->title = $result->name;
    $resultTemp->start = $result->date_modified;
    $resultTemp->groupId = (int)$result->client_backup_log_id;
    $resultTemp->className = 'bg-' . $result->class . '-subtle';
    $resultTemp->extendedProps->request = 'FOLDER=VIEW&TABLE=CLIENTS_BACKUPS_LOGS&ACTION=CLIENTS_BACKUPS_LOGS_DETAILS&CLIENT_BACKUP_LOG_ID=' . (int)$result->client_backup_log_id;

    /** Adiciono o registro a array */
    array_push($resultCalendar, $resultTemp);

}

?>

<div class="card animate slideIn mt-2">

    <div class="card-body">

        <div id="calendar"></div>

    </div>

</div>

<script type="text/javascript">

    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {

        themeSystem: 'bootstrap5',

        headerToolbar: {

            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'

        },

        locale: 'pt-br',

        initialDate: '<?php echo date('Y-m-d')?>',

        navLinks: true,

        selectable: true,

        selectMirror: true,

        editable: true,

        dayMaxEvents: true,

        events: <?php echo json_encode($resultCalendar)?>,

        extraParams: function () {

            return {

                cachebuster: new Date().valueOf()

            };

        },

        eventClick: function(info) {

            /** Busco os detalhes do operador*/
            SendRequest(`${info.event.extendedProps.request}`, {target : null, block : {create : true, info : null, sec : null, target : null, data : 'Aguarde', color : 'blue', type : 'circle', size : 'sm', message : true}});

        }

    });

    calendar.render();

</script>
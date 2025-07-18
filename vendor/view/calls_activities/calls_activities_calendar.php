<?php

/** Importação de classes */
use \vendor\model\Calls;
use \vendor\model\CallsActivities;
use \vendor\model\CallsActivitiesUsers;

/** Instânciamento de classes */
$Calls = new Calls();
$CallsActivities = new CallsActivities();
$CallsActivitiesUsers = new CallsActivitiesUsers();

/** Busco todos os registros */
$CallsGetResult = $Calls->Get(@(int)filter_input(INPUT_POST, 'CALL_ID', FILTER_SANITIZE_SPECIAL_CHARS));
$CallsActivitiesAllCalendarByCallIdResult = $CallsActivities->AllCalendarByCallId($CallsGetResult->call_id);

/** Variavel para guardar os dados do calendário */
$resultCalendar = [];

/** Percorro todos os registros */
foreach ($CallsActivitiesAllCalendarByCallIdResult as $key => $result) {

    /** Formato os dados para estrutura do calendário */
    $resultTemp = new stdClass();
    $resultTemp->title = '#' . $result->call_activity_id . ' - ' . $result->name;
    $resultTemp->start = !empty($result->date_close) ? $result->date_close : $result->date_expected;
    $resultTemp->groupId = (int)$result->call_activity_id;
    $resultTemp->className = empty($result->date_close) ? 'bg-primary' : 'bg-success';
    $resultTemp->extendedProps = new stdClass();
    $resultTemp->extendedProps->call_activity_id = (int)$result->call_activity_id;
    $resultTemp->extendedProps->request = 'FOLDER=VIEW&TABLE=CALLS_ACTIVITIES&ACTION=CALLS_ACTIVITIES_DETAILS&CALL_ACTIVITY_ID=' . $result->call_activity_id . '&MODAL=1';

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

            /** Verifico se existe requisição a ser realizada */
            if (info.event.extendedProps.request)
            {

                /** Busco os detalhes do operador*/
                SendRequest(`${info.event.extendedProps.request}`, {target : null, block : {create : true, info : null, sec : null, target : null, data : 'Aguarde', color : 'blue', type : 'circle', size : 'sm', message : true}});

            }

        }

    });

    calendar.render();

</script>
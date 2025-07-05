<?php

/** Importação de classes */
use \vendor\model\Logs;

/** Instânciamento de classes */
$Logs = new Logs();

/** Busco todos os registros */
$LogsAllByUserResult = $Logs->All();

/** Variavel para guardar os dados do calendário */
$resultCalendar = [];

/** Percorro todos os registros */
foreach ($LogsAllByUserResult as $key => $result) {

    /** Verifico qual registro desejo inserir no calendário */
    if (!empty($result->register_id))
    {

        /** Decodifico os dados */
        $result->data = (object)json_decode($result->data);

        /** Formato os dados para estrutura do calendário */
        $resultTemp = new stdClass();
        $resultTemp->title = $Main->decryptData($result->name_first) . ': ' . $result->data->TITLE . ' - ' . $result->data->MESSAGE;
        $resultTemp->start = $result->date_register;
        $resultTemp->groupId = (int)$result->log_id;
        $resultTemp->className = 'bg-' . $result->data->CLASS . '-subtle';
        $resultTemp->extendedProps->log_id = $result->log_id;

        /** Adiciono o registro a array */
        array_push($resultCalendar, $resultTemp);

    }

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
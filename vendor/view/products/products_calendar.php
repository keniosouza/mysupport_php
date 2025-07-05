<?php

/** Importação de classes */
use \vendor\model\Files;

/** Instânciamento de classes */
$Files = new Files();

/** Busco todos os registros */
$FilesAllByTableResult = $Files->AllByTable('calls');

/** Variavel para guardar os dados do calendário */
$resultCalendar = [];

/** Percorro todos os registros */
foreach ($FilesAllByTableResult as $key => $result) {

    /** Decodifico o histórico */
    $result->history = json_decode($result->history, true);

    /** Obtenho o primeiro elemento da array */
    $result->history = (object)$result->history[0];

    /** Formato os dados para estrutura do calendário */
    $resultTemp = new stdClass();
    $resultTemp->title = $result->name;
    $resultTemp->start = date('Y-m-d', strtotime($result->history->date));
    $resultTemp->groupId = (int)$result->call_id;
    $resultTemp->className = 'bg-primary';

    /** Adiciono o registro a array */
    array_push($resultCalendar, $resultTemp);

}

?>

<h5 class="card-title">

    Produtos / <b>Calendário</b> /

    <button type="button" class="btn btn-primary btn-sm" onclick="SendRequest('FOLDER=VIEW&TABLE=PRODUCTS&ACTION=PRODUCTS_DATAGRID', {target : null, block : {create : true, info : null, sec : null, target : null, data : 'Aguarde', color : 'blue', type : 'circle', size : 'sm', message : true}});">

        <i class="bi bi-arrow-left-short me-1"></i>Voltar

    </button>

</h5>

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

        }

    });

    calendar.render();

</script>
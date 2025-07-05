<?php

/** Importação de classes */
use \vendor\model\CallsActivities;
use \vendor\controller\calls_activities\CallsActivitiesValidate;

/** Instânciamento de classes */
$CallsActivities = new CallsActivities();
$CallsActivitiesValidate = new CallsActivitiesValidate();

/** Tratamento dos dados de entrada */
$CallsActivitiesValidate->setCallActivityId(@(int)filter_input(INPUT_POST, 'CALL_ACTIVITY_ID', FILTER_SANITIZE_SPECIAL_CHARS));

/** Busco o registro desejado */
$CallsActivitiesGetResult = $CallsActivities->Get($CallsActivitiesValidate->getCallActivityId());?>

<ul class="nav nav-pills nav-fill animate slideIn" id="pills-tab">

    <li class="nav-item me-1 mb-1 rounded border">

        <a class="nav-link" id="pills-files-form-tab" data-bs-toggle="pill" href="#pills-files-form" aria-controls="pills-files-form" aria-selected="false">

            <i class="bi bi-plus me-1"></i>Arquivos

        </a>

    </li>

    <li class="nav-item mb-1 rounded border">

        <a class="nav-link active" id="pills-files-datagrid-tab" data-bs-toggle="pill" href="#pills-files-datagrid" aria-controls="pills-files-datagrid" aria-selected="false">

            <i class="bi bi-card-list me-1"></i>Lista

        </a>

    </li>

</ul>

<div class="tab-content animate slideIn">

    <div class="tab-pane fade" id="pills-files-form">

        <script type="text/javascript">

            /** Envio de Requisição */
            SendRequest('FOLDER=VIEW&TABLE=CALLS_ACTIVITIES_FILES&ACTION=CALLS_ACTIVITIES_FILES_FORM&CALL_ID=<?php echo @(int)$CallsActivitiesGetResult->call_id ?>&CALL_ACTIVITY_ID=<?php echo @(int)$CallsActivitiesGetResult->call_activity_id ?>', {target : 'pills-files-form', loader : {create: true, type: 2, padding: '0px', target : 'pills-files-form', data : 'Aguarde...'}});

        </script>

    </div>

    <div class="tab-pane fade show active" id="pills-files-datagrid">

        <script type="text/javascript">

            /** Envio de Requisição */
            SendRequest('FOLDER=VIEW&TABLE=CALLS_ACTIVITIES_FILES&ACTION=CALLS_ACTIVITIES_FILES_DATAGRID&CALL_ID=<?php echo @(int)$CallsActivitiesGetResult->call_id ?>&CALL_ACTIVITY_ID=<?php echo @(int)$CallsActivitiesGetResult->call_activity_id ?>', {target : 'pills-files-datagrid', loader : {create: true, type: 2, padding: '0px', target : 'pills-files-datagrid', data : 'Aguarde...'}});

        </script>

    </div>

</div>
<?php

// Importação de classes
use \vendor\model\Sections;
use \vendor\model\Calls;
use \vendor\controller\calls\CallsValidate;
use \vendor\model\CallsActivities;
use \vendor\model\CallsActivitiesUsers;

// Instânciamento de classes
$Sections = new Sections();
$Calls = new Calls();
$CallsValidate = new CallsValidate();
$CallsActivities = new CallsActivities();
$CallsActivitiesUsers = new CallsActivitiesUsers();

// Parâmetros de entrada
$CallsValidate->setCallId((int)filter_input(INPUT_POST, 'CALL_ID', FILTER_SANITIZE_SPECIAL_CHARS));

// Busca de registro
$CallsGetResult = $Calls->Get($CallsValidate->getCallId());

/** Busco a seção desejada */
$SectionsAllResult = $Sections->All($CallsValidate->getCallId(), 'calls');

/** Busco atividades sem seção */
$CallsActivitiesAllresult = $CallsActivities->All($CallsGetResult->call_id);

?>

<div class="card">

    <div class="card-body">

        <?php

        /** Consulta os usuário cadastrados*/
        foreach ($SectionsAllResult as $key => $result) {?>

            <h6 class="cursor-pointer" onclick="SendRequest('FOLDER=VIEW&TABLE=SECTIONS&ACTION=SECTIONS_FORM&SECTION_ID=<?php echo @(int)$result->section_id ?>&REGISTER_ID=<?php echo @(int)$CallsGetResult->call_id ?>', {target : null, block : {create : true, info : null, sec : null, target : null, data : 'Aguarde', color : 'blue', type : 'circle', size : 'sm', message : true}});">

                <i class="bi bi-pencil me-1"></i><?php echo $result->name?>

            </h6>

            <div id="Section<?php echo $result->section_id?>" class="mb-2">

                <script type="text/javascript">

                    /** Envio de Requisição */
                    SendRequest('FOLDER=VIEW&TABLE=CALLS_ACTIVITIES&ACTION=CALLS_ACTIVITIES_LIST_SECTION&SECTION_ID=<?php echo $result->section_id?>', {target : 'Section<?php echo $result->section_id?>', block : {create : true, info : null, sec : null, target : 'Section<?php echo $result->section_id?>', data : 'Aguarde', color : 'blue', type : 'circle', size : 'sm', message : true}});

                </script>

            </div>

        <?php }?>

    </div>

</div>
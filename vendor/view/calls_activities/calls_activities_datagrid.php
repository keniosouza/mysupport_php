<?php

// Importação de classes
use vendor\model\Sections;
use vendor\model\Calls;
use vendor\controller\calls\CallsValidate;
use vendor\model\CallsActivities;
use vendor\model\CallsActivitiesUsers;

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
$CallsActivitiesAllresult = $CallsActivities->All($CallsGetResult->call_id);?>

<div class="row g-2">

    <?php

    /** Verifico se existe registro */
    if (count($CallsActivitiesAllresult) > 0) {?>

        <div class="col-md-3">

            <h6>

                <i class="bi bi-list-task me-1"></i>Atividades sem Seção

            </h6>

            <div id="Section0">

                <script type="text/javascript">

                    /** Envio de Requisição */
                    SendRequest('FOLDER=VIEW&TABLE=CALLS_ACTIVITIES&ACTION=CALLS_ACTIVITIES_DATAGRID_SECTION&SECTION_ID=0&CALL_ID=<?php echo $CallsGetResult->call_id; ?>', {target : 'Section0', loader : {create: true, padding: '0px', type: 2, target : 'section0', data : 'Aguarde...'}});

                </script>

            </div>

        </div>

    <?php }?>

    <?php

    /** Consulta os usuário cadastrados*/
    foreach ($SectionsAllResult as $key => $result) {?>

        <div class="col-md-3">

            <h6 class="cursor-pointer" id="SectionEditButton<?php echo @(int)$result->section_id ?>" onclick="SendRequest('FOLDER=VIEW&TABLE=SECTIONS&ACTION=SECTIONS_FORM&SECTION_ID=<?php echo @(int)$result->section_id ?>&REGISTER_ID=<?php echo @(int)$CallsGetResult->call_id ?>', {target : null, loader : {create: true, padding: '0px', type: 3, target : 'SectionEditButton<?php echo @(int)$result->section_id ?>', data : 'Aguarde...'}});">

                <i class="bi bi-pencil me-1"></i><?php echo $result->name?>

            </h6>

            <div class="card my-1 border-dashed cursor-pointer" onclick="SendRequest('FOLDER=VIEW&TABLE=CALLS_ACTIVITIES&ACTION=CALLS_ACTIVITIES_CARD_FORM&CALL_ID=<?php echo @(int)$CallsGetResult->call_id ?>&SECTION_ID=<?php echo @(int)$result->section_id ?>', {target : 'SectionCallActivityForm<?php echo $result->section_id?>', loader : {create: true, padding: '0px', type: 2, target : 'SectionCallActivityForm<?php echo $result->section_id?>', data : 'Aguarde...'}});">

                <div class="card-body text-center">

                    <h6 class="card-title mb-0">

                        + Adicionar uma Atividade

                    </h6>

                </div>

            </div>

            <div id="SectionCallActivityForm<?php echo $result->section_id?>"></div>

            <div id="Section<?php echo $result->section_id?>">

                <script type="text/javascript">

                    /** Envio de Requisição */
                    SendRequest('FOLDER=VIEW&TABLE=CALLS_ACTIVITIES&ACTION=CALLS_ACTIVITIES_DATAGRID_SECTION&SECTION_ID=<?php echo $result->section_id?>', {target : 'Section<?php echo $result->section_id?>', loader : {create: true, padding: '0px', type: 2, target : 'Section<?php echo $result->section_id?>', data : 'Aguarde...'}});

                </script>

            </div>

        </div>

    <?php }?>

    <div class="col-md-3">

        <h6 class="cursor-pointer" id="SectionFormButton" onclick="SendRequest('FOLDER=VIEW&TABLE=SECTIONS&ACTION=SECTIONS_FORM&SECTION_ID=0&REGISTER_ID=<?php echo @(int)$CallsGetResult->call_id ?>', {target : null, loader : {create: true, padding: '0px', type: 3, target : 'SectionFormButton', data : 'Aguarde...'}});">

            <i class="bi bi-plus me-1"></i>Adicionar uma Seção

        </h6>

    </div>

</div>
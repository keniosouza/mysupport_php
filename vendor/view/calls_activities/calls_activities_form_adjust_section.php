<?php

/** Importação de classes */
use \vendor\model\Sections;
use \vendor\model\CallsActivities;
use \vendor\controller\calls_activities\CallsActivitiesValidate;

/** Instânciamento de classes */
$Sections = new Sections();
$CallsActivities = new CallsActivities();
$CallsActivitiesValidate = new CallsActivitiesValidate();

/** ID da Empresa */
$UserCompanyId = @(int)$_SESSION['USERSCOMPANYID'];

/** Tratamento dos dados de entrada */
$CallsActivitiesValidate->setCallActivityId(@(int)filter_input(INPUT_POST, 'CALL_ACTIVITY_ID', FILTER_SANITIZE_SPECIAL_CHARS));

/** Busca de registro */
$CallsActivitiesLoadResult = $CallsActivities->get($CallsActivitiesValidate->getCallActivityId());?>

<div class="card">

    <div class="card-body">

        <form id="CallsActivitiesFormAdjustSection">

            <div class="form-group">

                <div class="input-group">

                    <select name="section_id" id="section_id" class="form-control form-select form-control-solid" onchange="SendRequest('CallsActivitiesFormAdjustSection', {target : 'CallsActivitiesFormAdjustSectionMessage', block : {create : true, info : null, sec : null, target : 'CallsActivitiesFormAdjustSectionMessage', data : 'Aguarde...', color : 'blue', type : 'circle', size : 'sm', message : true}});">

                        <option value=''>Selecione</option>

                        <?php
                        /** Consulta os CallsActivitiesTypes cadastrados*/
                        foreach ($Sections->All($CallsActivitiesLoadResult->call_id, 'calls') as $key => $result)
                        {?>

                            <option value='<?php echo ($result->section_id)?>' <?php  echo $CallsActivitiesLoadResult->section_id == $result->section_id ? 'Selected' : Null  ?>>

                                <?php echo (@(string)$result->name)?>

                            </option>

                        <?php }?>

                    </select>

                </div>

            </div>

            <!-- Espaço resevador para o retorno do servidor -->
            <div id="CallsActivitiesFormAdjustSectionMessage"></div>

            <input type="hidden" name="FOLDER" value="ACTION"/>
            <input type="hidden" name="TABLE" value="CALLS_ACTIVITIES"/>
            <input type="hidden" name="ACTION" value="CALLS_ACTIVITIES_SAVE_SECTION"/>
            <input type="hidden" name="call_activity_id" value="<?php echo $CallsActivitiesLoadResult->call_activity_id?>"/>

        </form>

    </div>

</div>
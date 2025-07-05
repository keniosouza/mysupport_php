<?php

/** Importação de classes */
use \vendor\model\Calls;
use \vendor\model\CallsActivities;
use \vendor\controller\calls_activities\CallsActivitiesValidate;

/** Instânciamento de classes */
$Calls = new Calls();
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

        <form id="CallsActivitiesFormAdjustCall">

            <div class="form-group">

                <select name="call_id" id="call_id" class="form-control form-select form-control-solid" onchange="SendRequest('CallsActivitiesFormAdjustCall', {target : 'CallsActivitiesFormAdjustCallMessage', block : {create : true, info : null, sec : null, target : 'CallsActivitiesFormAdjustCallMessage', data : 'Aguarde...', color : 'blue', type : 'circle', size : 'sm', message : true}});">

                    <option value=''>Selecione</option>

                    <?php
                    /** Consulta os CallsActivitiesTypes cadastrados*/
                    foreach ($Calls->All($UserCompanyId) as $key => $result){?>

                        <option value='<?php echo ($result->call_id)?>' <?php  echo $result->call_id == $CallsActivitiesLoadResult->call_id ? 'Selected' : Null  ?>>

                            <?php echo (@(string)$result->name)?>

                        </option>

                    <?php }?>

                </select>

            </div>

            <!-- Espaço resevador para o retorno do servidor -->
            <div id="CallsActivitiesFormAdjustCallMessage"></div>

            <input type="hidden" name="FOLDER" value="ACTION"/>
            <input type="hidden" name="TABLE" value="CALLS_ACTIVITIES"/>
            <input type="hidden" name="ACTION" value="CALLS_ACTIVITIES_SAVE_CALL"/>
            <input type="hidden" name="call_activity_id" value="<?php echo $CallsActivitiesLoadResult->call_activity_id?>"/>

        </form>

    </div>

</div>
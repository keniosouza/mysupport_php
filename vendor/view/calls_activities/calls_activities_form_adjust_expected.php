<?php

/** Importação de classes */
use \vendor\model\CallsActivities;
use \vendor\controller\calls_activities\CallsActivitiesValidate;

/** Instânciamento de classes */
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

        <form id="CallsActivitiesFormAdjustExpected">

            <div class="form-group">

                <input type="date" class="form-control form-control-solid" name="date_expected" id="date_expected" value="<?php echo !empty(@(string)$CallsActivitiesLoadResult->date_expected) ? date('Y-m-d', strtotime(@(string)$CallsActivitiesLoadResult->date_expected)) : null; ?>" onchange="SendRequest('CallsActivitiesFormAdjustExpected', {target : 'CallsActivitiesFormAdjustExpectedMessage', block : {create : true, info : null, sec : null, target : 'CallsActivitiesFormAdjustExpectedMessage', data : 'Aguarde...', color : 'blue', type : 'circle', size : 'sm', message : true}});"/>

            </div>

            <!-- Espaço resevador para o retorno do servidor -->
            <div id="CallsActivitiesFormAdjustExpectedMessage"></div>

            <input type="hidden" name="FOLDER" value="ACTION"/>
            <input type="hidden" name="TABLE" value="CALLS_ACTIVITIES"/>
            <input type="hidden" name="ACTION" value="CALLS_ACTIVITIES_SAVE_DATE_EXPECTED"/>
            <input type="hidden" name="call_activity_id" value="<?php echo $CallsActivitiesLoadResult->call_activity_id?>"/>

        </form>

    </div>

</div>
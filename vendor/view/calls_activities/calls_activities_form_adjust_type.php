<?php

/** Importação de classes */
use \vendor\model\CallsActivitiesTypes;
use \vendor\model\CallsActivities;
use \vendor\controller\calls_activities\CallsActivitiesValidate;

/** Instânciamento de classes */
$CallsActivitiesTypes = new CallsActivitiesTypes();
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

        <form id="CallsActivitiesFormAdjustType">

            <div class="form-group">

                <div class="input-group">

                    <select name="call_activity_type_id" id="call_activity_type_id" class="form-control form-select form-control-solid" onchange="SendRequest('CallsActivitiesFormAdjustType', {target : 'CallsActivitiesFormAdjustTypeMessage', block : {create : true, info : null, sec : null, target : 'CallsActivitiesFormAdjustTypeMessage', data : 'Aguarde...', color : 'blue', type : 'circle', size : 'sm', message : true}});">

                        <option value=''>Selecione</option>

                        <?php
                        /** Consulta os CallsActivitiesTypes cadastrados*/
                        foreach ($CallsActivitiesTypes->all($UserCompanyId) as $key => $result)
                        {?>

                            <option value='<?php echo ($result->call_activity_type_id)?>' <?php  echo $result->call_activity_type_id == $CallsActivitiesLoadResult->call_activity_type_id ? 'Selected' : Null  ?>>

                                <?php echo (@(string)$result->description)?>

                            </option>

                        <?php }?>

                    </select>

                </div>

            </div>

            <!-- Espaço resevador para o retorno do servidor -->
            <div id="CallsActivitiesFormAdjustTypeMessage"></div>

            <input type="hidden" name="FOLDER" value="ACTION"/>
            <input type="hidden" name="TABLE" value="CALLS_ACTIVITIES"/>
            <input type="hidden" name="ACTION" value="CALLS_ACTIVITIES_SAVE_TYPE"/>
            <input type="hidden" name="call_activity_id" value="<?php echo $CallsActivitiesLoadResult->call_activity_id?>"/>

        </form>

    </div>

</div>
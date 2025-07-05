<?php

/** Importação de classes */
use \vendor\model\CallsActivities;
use \vendor\controller\calls_activities\CallsActivitiesValidate;

/** Instânciamento de classes */
$CallsActivities = new CallsActivities();
$CallsActivitiesValidate = new CallsActivitiesValidate();

/** Tratamento dos dados de entrada */
$CallsActivitiesValidate->setCallActivityId(@(int)filter_input(INPUT_POST, 'CALL_ACTIVITY_ID', FILTER_SANITIZE_SPECIAL_CHARS));

/** Busco o Registro desejado */
$CallsActivitiesLoadResult = $CallsActivities->Get($CallsActivitiesValidate->getCallActivityId());?>

<div class="col-md-12 animate slideIn">

    <div class="card shadow-sm border">

        <form class="card-body" role="form" id="CallsActivitiesLevelsForm">

            <div class="row g-1">

                <div class="col-md-12">

                    <div class="form-group">

                        <label for="description">

                            Descrição:

                        </label>

                        <input id="description" type="text" class="form-control form-control-solid" name="description">

                    </div>

                </div>

                <div class="col-md-12" id="CallsActivitiesLevelsFormMessages"></div>

                <div class="col-md-12">

                    <div class="form-group">

                        <div class="btn-group btn-sm w-100" role="group" aria-label="Basic example">

                            <button type="button" class="btn btn-primary" onclick="SendRequest('FOLDER=VIEW&TABLE=CALLS_ACTIVITIES&ACTION=CALLS_ACTIVITIES_FORM_ADJUST&CALL_ACTIVITY_ID=<?php echo @(int)$CallsActivitiesLoadResult->call_activity_id?>', {target : 'CallsActivitiesDetailsWrapper<?php echo $CallsActivitiesLoadResult->call_activity_id?>', block : {create : true, info : null, sec : null, target : 'CallsActivitiesDetailsWrapper<?php echo $CallsActivitiesLoadResult->call_activity_id?>', data : 'Aguarde', color : 'blue', type : 'circle', size : 'sm', message : true}});">

                                <i class="bi bi-x me-1"></i>Fechar

                            </button>

                            <button class="btn btn-primary" onclick="SendRequest('CallsActivitiesLevelsForm', {target : 'CallsActivitiesLevelsFormMessages', block : {create : true, info : null, sec : null, target : 'CallsActivitiesLevelsFormMessages', data : 'Aguarde...', color : 'blue', type : 'circle', size : 'sm', message : true}});">

                                <i class="bi bi-check me-1"></i>Salvar

                            </button>

                        </div>

                    </div>

                </div>

            </div>

            <input type="hidden" name="FOLDER" value="ACTION" />
            <input type="hidden" name="TABLE" value="CALLS_ACTIVITIES_LEVELS" />
            <input type="hidden" name="ACTION" value="CALLS_ACTIVITIES_LEVELS_SAVE" />

        </form>

    </div>

</div>
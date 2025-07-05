<?php

/** Importação de classes */
use \vendor\model\CallsActivities;
use \vendor\model\CallsActivitiesUsers;
use \vendor\controller\calls_activities_users\CallsActivitiesUsersValidate;

/** Instânciamento de classes */
$CallsActivities = new CallsActivities();
$CallsActivitiesUsers = new CallsActivitiesUsers();
$CallsActivitiesUsersValidate = new CallsActivitiesUsersValidate();

/** Tratamento dos dados de entrada */
$modal = @(int)filter_input(INPUT_POST, 'MODAL', FILTER_SANITIZE_SPECIAL_CHARS);
$CallsActivitiesUsersValidate->setCallActivityId(@(int)filter_input(INPUT_POST, 'CALL_ACTIVITY_ID', FILTER_SANITIZE_SPECIAL_CHARS));

/** Busco o Registro desejado */
$CallsActivitiesLoadResult = $CallsActivities->Get($CallsActivitiesUsersValidate->getCallActivityId());

/** Busco os operadores vinculados a atividades */
$CallsActivitiesUsersAllByActivityIdResult = $CallsActivitiesUsers->AllByActivityId((int)$CallsActivitiesLoadResult->call_activity_id);?>

<div class="avatar-group avatar-group-sm avatar-group-overlapped">

    <?php

    /** Consulta os usuário cadastrados*/
    foreach ($CallsActivitiesUsersAllByActivityIdResult as $keyUsers => $resultUsers) {

        /** Defino a requisição a ser realizada */
        $resultUsers->request = "SendRequest('FOLDER=ACTION&TABLE=CALLS_ACTIVITIES_USERS&ACTION=CALLS_ACTIVITIES_USERS_DELETE&CALL_ACTIVITY_USER_ID=" . @(int)$resultUsers->call_activity_user_id . "', {target : 'CallsActivitiesDetailsWrapper" . @(int)$resultUsers->call_activity_user_id . "', block : {create : true, info : null, sec : null, target : 'CallsActivitiesDetailsWrapper" . @(int)$resultUsers->call_activity_user_id . "', data : 'Aguarde', color : 'blue', type : 'circle', size : 'sm', message : true}});"?>

        <div class="avatar cursor-pointer" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="<?php echo $Main->decryptData(@(string)$resultUsers->name_first); ?>" onclick="<?php echo $modal > 0 ? $resultUsers->request : null; ?>">

            <img src="<?php echo $Main->SetIcon($resultUsers->file_path . '/avatar/' . $resultUsers->file_name, 'default/user.png'); ?>" alt="<?php echo $Main->decryptData(@(string)$resultUsers->name_first); ?>" class="avatar-img rounded-circle bg-primary">

        </div>

    <?php } ?>

    <?php

    /** Verifico se devo exibir o alerta */
    if ($modal > 0) { ?>

        <div class="avatar cursor-pointer" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Adicionar Operador" onclick="SendRequest('FOLDER=VIEW&TABLE=CALLS_ACTIVITIES_USERS&ACTION=CALLS_ACTIVITIES_USERS_FORM&CALL_ID=<?php echo @(int)$CallsActivitiesLoadResult->call_id ?>&CALL_ACTIVITY_ID=<?php echo @(int)$CallsActivitiesLoadResult->call_activity_id ?>', {target : 'CallsActivitiesDetailsWrapper<?php echo $CallsActivitiesLoadResult->call_activity_id?>', block : {create : true, info : null, sec : null, target : 'CallsActivitiesDetailsWrapper<?php echo $CallsActivitiesLoadResult->call_activity_id?>', data : 'Aguarde', color : 'blue', type : 'circle', size : 'sm', message : true}});">

            <span class="avatar-text avatar-text-inv-primary rounded-circle">

                <span class="initial-wrap">

                    <span>

                        +

                    </span>

                </span>

            </span>

        </div>

    <?php } ?>

</div>
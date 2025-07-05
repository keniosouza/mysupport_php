<?php

/** Importação de classes */
use \vendor\model\Users;
use \vendor\model\CallsActivitiesUsers;
use \vendor\controller\calls_activities_users\CallsActivitiesUsersValidate;

/** Instânciamento de classes */
$Users = new Users();
$CallsActivitiesUsers = new CallsActivitiesUsers();
$CallsActivitiesUsersValidate = new CallsActivitiesUsersValidate();

/** Tratamento dos dados de entrada */
$CallsActivitiesUsersValidate->setCallId(@(int)filter_input(INPUT_POST, 'CALL_ID', FILTER_SANITIZE_SPECIAL_CHARS));
$CallsActivitiesUsersValidate->setCompanyId(@(int)$_SESSION['USERSCOMPANYID']);
$CallsActivitiesUsersValidate->setCallActivityId(@(int)filter_input(INPUT_POST, 'CALL_ACTIVITY_ID', FILTER_SANITIZE_SPECIAL_CHARS));

/** Verifico se existe registro */
if ($CallsActivitiesUsersValidate->getCallActivityId() > 0) {

    /** Busca de registro */
    $resultCallsUsers = $Users->AllAvailable($CallsActivitiesUsersValidate->getCompanyId(), $CallsActivitiesUsersValidate->getCallActivityId());

}

?>

<form id="callsActivitiesUsersForm">

    <?php

    /** Verifico se existem registros */
    if (@(int)count($resultCallsUsers) > 0) { ?>

        <button type="button" class="btn btn-primary w-100 mb-2" onclick="ToggleCheckboxes('callsActivitiesUsersForm')">

            <i class="bi bi-check2-circle me-1"></i>Marcar/Desmarcar Todos

        </button>

        <div class="row g-2">

            <?php

            /** Consulta os usuário cadastrados*/
            foreach ($resultCallsUsers as $keyResultUsers => $result) {?>

                <div class="col-md-6 d-flex">

                    <div class="card w-100">

                        <div class="card-body">

                            <div class="d-flex align-items-center">

                                <div class="flex-shrink-0">

                                    <img class="rounded" src="<?php echo $Main->SetIcon($result->file_path . '/avatar/' . $result->file_name, 'default/user.png'); ?>" alt="<?php echo $Main->decryptData(@(string)$result->name_first); ?>" width="60">

                                </div>

                                <div class="flex-grow-1 ms-3">

                                    <h5 class="mt-0">

                                        <input type="checkbox" class="custom-control-input" id="customSwitch<?php echo @(int)$keyResultUsers ?>" value="<?php echo @(int)$result->users_id ?>" name="call_user_id[]">
                                        <?php echo $Main->decryptData(@(string)$result->name_first); ?> <?php echo $Main->decryptData(@(string)$result->name_last); ?>

                                    </h5>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            <?php }  ?>

        </div>

        <div id="CallsActivitiesUsersMessages"></div>

        <button type="button" class="btn btn-primary w-100 mt-2" onclick="SendRequest('callsActivitiesUsersForm', {target : 'CallsActivitiesUsersMessages', block : {create : true, info : null, sec : null, target : 'CallsActivitiesUsersMessages', data : 'Aguarde', color : 'blue', type : 'circle', size : 'sm', message : true}});">

            <i class="bi bi-link me-1"></i>Vincular

        </button>

        <input type="hidden" name="call_id" value="<?php echo @(string)$CallsActivitiesUsersValidate->getCallId() ?>"/>
        <input type="hidden" name="call_activity_id" value="<?php echo @(string)$CallsActivitiesUsersValidate->getCallActivityId() ?>"/>
        <input type="hidden" name="FOLDER" value="ACTION"/>
        <input type="hidden" name="TABLE" value="CALLS_ACTIVITIES_USERS"/>
        <input type="hidden" name="ACTION" value="CALLS_ACTIVITIES_USERS_SAVE"/>

    <?php } else { ?>

        <div class="card">

            <div class="card-body text-center">

                <h1 class="card-title text-center">

                    <span class="badge rounded-pill text-bg-primary">

                        C-1

                    </span>

                </h1>

                <h4 class="card-subtitle text-center text-muted">

                    Na há operadores disponiveis

                </h4>

            </div>

        </div>

    <?php } ?>

</form>
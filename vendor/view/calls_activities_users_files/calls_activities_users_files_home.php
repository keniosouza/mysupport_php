<?php

/** Importação de classes */
use \vendor\model\CallsActivitiesUsers;
use \vendor\controller\calls_activities_users\CallsActivitiesUsersValidate;

/** Instânciamento de classes */
$CallsActivitiesUsers = new CallsActivitiesUsers();
$CallsActivitiesUsersValidate = new CallsActivitiesUsersValidate();

/** Tratamento dos dados de entrada */
$CallsActivitiesUsersValidate->setCallActivityUserId(@(int)filter_input(INPUT_POST, 'CALL_ACTIVITY_USER_ID', FILTER_SANITIZE_SPECIAL_CHARS));

/** Busco o registro desejado */
$CallsActivitiesUsersLoadResult = $CallsActivitiesUsers->Load($CallsActivitiesUsersValidate->getCallActivityUserId());

?>

<?php

/** Verifico o status do registro */
if ((empty(@(string)$CallsActivitiesUsersLoadResult->calls_activities_date_close)) && ((int)$_SESSION['USERSID'] === (int)$CallsActivitiesUsersLoadResult->user_id) &&(@(string)$resultUserAcl->chamado->vincular_atividade === 'true')) { ?>

    <ul class="nav nav-pills nav-fill animate slideIn" id="pills-tab">

        <li class="nav-item me-1 mb-2 rounded border">

            <a class="nav-link" id="pills-files-form-tab" data-bs-toggle="pill" href="#pills-files-form" aria-controls="pills-files-form" aria-selected="false">

                <i class="bi bi-plus me-1"></i>Arquivos

            </a>

        </li>

        <li class="nav-item mb-2 rounded border">

            <a class="nav-link active" id="pills-files-datagrid-tab" data-bs-toggle="pill" href="#pills-files-datagrid" aria-controls="pills-files-datagrid" aria-selected="false">

                <i class="bi bi-card-list me-1"></i>Lista

            </a>

        </li>

    </ul>

<?php } ?>

<div class="tab-content animate slideIn">

    <?php

    /** Verifico o status do registro */
    if ((empty(@(string)$CallsActivitiesUsersLoadResult->calls_activities_date_close)) && ((int)$_SESSION['USERSID'] === (int)$CallsActivitiesUsersLoadResult->user_id) &&(@(string)$resultUserAcl->chamado->vincular_atividade === 'true')) { ?>

        <div class="tab-pane fade" id="pills-files-form">

            <script type="text/javascript">

                /** Envio de Requisição */
                SendRequest('FOLDER=VIEW&TABLE=CALLS_ACTIVITIES_USERS_FILES&ACTION=CALLS_ACTIVITIES_USERS_FILES_FORM&CALL_ACTIVITY_USER_ID=<?php echo $CallsActivitiesUsersLoadResult->call_activity_user_id ?>&CALL_ACTIVITY_ID=<?php echo $CallsActivitiesUsersLoadResult->call_activity_id ?>', {target : 'pills-files-form', block : {create : true, info : null, sec : null, target : 'pills-files-form', data : 'Aguarde', color : 'blue', type : 'circle', size : 'sm', message : true}})

            </script>

        </div>

    <?php } ?>

    <div class="tab-pane fade show active" id="pills-files-datagrid">

        <script type="text/javascript">

            /** Envio de Requisição */
            SendRequest('FOLDER=VIEW&TABLE=CALLS_ACTIVITIES_USERS_FILES&ACTION=CALLS_ACTIVITIES_USERS_FILES_DATAGRID&CALL_ACTIVITY_USER_ID=<?php echo $CallsActivitiesUsersLoadResult->call_activity_user_id ?>&CALL_ACTIVITY_ID=<?php echo $CallsActivitiesUsersLoadResult->call_activity_id ?>', {target : 'pills-files-datagrid', block : {create : true, info : null, sec : null, target : 'pills-files-datagrid', data : 'Aguarde', color : 'blue', type : 'circle', size : 'sm', message : true}})

        </script>

    </div>

</div>
<?php

/** Importação de classes */
use vendor\model\CallsActivities;
use vendor\model\CallsActivitiesUsers;

/** Instânciamento de classes */
$CallsActivities = new CallsActivities();
$CallsActivitiesUsers = new CallsActivitiesUsers();

/** Parâmetros de entrada */
$situation = @(int)filter_input(INPUT_POST, 'SITUATION', FILTER_SANITIZE_SPECIAL_CHARS);

/** Declaração de variavel */
$CallsActivitiesResult = null;

/** Verifico o tipo de busca que devo realizar */
switch ($situation)
{

    /** Busco os registros em aberto */
    case 1:

        /** Busco a listagem de registros AGUARDANDO */
        $CallsActivitiesResult = $CallsActivities->AllByCompanyId($_SESSION['USERSCOMPANYID']);
        break;

}

?>

<div class="card">

    <div class="card-body">

        <h6 class="text-muted">

            Total -
            <span class="badge bg-primary">

                <?php echo count($CallsActivitiesResult)?>

            </span>

        </h6>

        <table id="collapseExample" class="table table-hover table-bordered mb-0">

            <thead>

            <tr>

                <th class="border-start-0" scope="col">

                    Nome

                </th>

                <th class="text-center" scope="col">

                    Operadores

                </th>

                <th class="text-center" scope="col">

                    Prioridade

                </th>

                <th class="text-center" scope="col">

                    Conclusão

                </th>

                <th class="border-end-0 text-center" scope="col">

                    Operações

                </th>

            </tr>

            </thead>

            <tbody>

            <?php

            /** Consulta os usuário cadastrados*/
            foreach ($CallsActivitiesResult as $key => $result) {

                /** Defino o nome da função de exclusão */
                $result->delete = 'calls_activities_delete_' . $result->call_activity_id . '_' . rand(1, 1000);

                /** Crio um novo objeto */
                $result->context_menu = new stdClass();

                /** Informo a div que sera o menu de contexto */
                $result->context_menu->name = 'CallActivityContextMenuName' . $result->call_activity_id;

                /** Informo a div que sera a zone do context menu */
                $result->context_menu->zone = 'CallActivityContextMenuZone' . $result->call_activity_id; ?>

                <tr class="cursor-pointer">

                    <td class="border-start-0 align-middle text-truncate w-5">

                        <input class="form-check-input cursor-pointer" type="checkbox" id="CallActivityId<?php echo $result->call_activity_id ?>" name="CallActivityId<?php echo $result->call_activity_id ?>" <?php echo !empty($result->date_close) ? 'checked' : null ?> onclick="SendRequest('FOLDER=ACTION&TABLE=CALLS_ACTIVITIES&ACTION=CALLS_ACTIVITIES_CLOSE_OR_OPEN&CALL_ACTIVITY_ID=<?php echo @(int)$result->call_activity_id ?>', {target : 'CallsActivitiesLoader<?php echo $result->call_activity_id?>', block : {create : true, info : null, sec : null, target : 'CallsActivitiesLoader<?php echo $result->call_activity_id?>', data : 'Aguarde', color : 'blue', type : 'circle', size : 'sm', message : true}});">
                        <label class="form-check-label cursor-pointer" for="CallActivityId<?php echo $result->call_activity_id ?>">

                            #<?php echo $result->call_activity_id ?> - <?php echo $result->name ?>...

                        </label>

                    </td>

                    <td class="align-middle w-25">

                        <div id="CallsActivitiesListSectionAvatar<?php echo @(int)$result->call_activity_id ?>">

                            <script type="text/javascript">

                                SendRequest('FOLDER=VIEW&TABLE=CALLS_ACTIVITIES_USERS&ACTION=CALLS_ACTIVITIES_USERS_AVATAR_LIST&CALL_ACTIVITY_ID=<?php echo @(int)$result->call_activity_id ?>', {target : 'CallsActivitiesListSectionAvatar<?php echo @(int)$result->call_activity_id ?>', block : {create : true, info : null, sec : null, target : 'CallsActivitiesListSectionAvatar<?php echo @(int)$result->call_activity_id ?>', data : 'Aguarde', color : 'blue', type : 'circle', size : 'sm', message : true}});

                            </script>

                        </div>

                    </td>

                    <td class="align-middle w-25 text-center">

                        <span class="badge bg-<?php echo empty($result->call_activity_priority) ? 'primary' : $Main->SetClass($result->call_activity_priority_id); ?>">

                            <?php echo !empty($result->call_activity_priority) ? $result->call_activity_priority : 'Não Possui' ?>

                        </span>

                    </td>

                    <td class="align-middle w-25 text-center">

                        <span class="badge bg-primary">

                            <?php echo !empty($result->date_expected) ? date('d/m/Y', strtotime($result->date_expected)) : 'Não Possui' ?>

                        </span>

                        <?php

                        /** Verifico o status do registro */
                        if ((!empty($result->date_expected)) && ((strtotime(date('Y/m/d')) > strtotime($result->date_expected)))) { ?>

                            <span class="badge bg-danger">

                                Em Atraso

                            </span>

                        <?php } ?>

                    </td>

                    <td class="border-end-0 align-middle w-25">

                        <div class="btn-group btn-group-sm w-100 text-break">

                            <button type="button" class="btn btn-primary" onclick="SendRequest('FOLDER=VIEW&TABLE=CALLS_ACTIVITIES&ACTION=CALLS_ACTIVITIES_DETAILS&CALL_ACTIVITY_ID=<?php echo @(int)$result->call_activity_id ?>&MODAL=1', {target : null, block : {create : true, info : null, sec : null, target : null, data : 'Aguarde', color : 'blue', type : 'circle', size : 'sm', message : true}});">

                                <i class="bi bi-eye"></i>

                            </button>

                            <button type="button" class="btn btn-primary" onclick="SendRequest('FOLDER=VIEW&TABLE=CALLS_ACTIVITIES&ACTION=CALLS_ACTIVITIES_FORM&CALL_ID=<?php echo (int)$result->call_id ?>&CALL_ACTIVITY_ID=<?php echo (int)$result->call_activity_id ?>', {target : null, block : {create : true, info : null, sec : null, target : null, data : 'Aguarde', color : 'blue', type : 'circle', size : 'sm', message : true}});">

                                <i class="bi bi-pencil"></i>

                            </button>

                            <button type="button" class="btn btn-primary" onclick="modalConstruct(true, 'Deseja remover a atividade?', '', 'md', null, null, 'question', <?php echo $result->delete ?>, null, null)">

                                <i class="bi bi-fire"></i>

                                <script type="text/javascript">

                                    /** Carrega a função de logout */
                                    var <?php echo $result->delete?> = "SendRequest('FOLDER=ACTION&TABLE=CALLS_ACTIVITIES&ACTION=CALLS_ACTIVITIES_DELETE&CALL_ID=<?php echo (int)$result->call_id?>&CALL_ACTIVITY_ID=<?php echo (int)$result->call_activity_id?>', {target : 'pills-activities', block : {create : 'pills-activities', info : null, sec : null, target : null, data : 'Aguarde', color : 'blue', type : 'circle', size : 'sm', message : true}});";

                                </script>

                            </button>

                        </div>

                    </td>

                </tr>

            <?php } ?>

            </tbody>

        </table>

    </div>

</div>
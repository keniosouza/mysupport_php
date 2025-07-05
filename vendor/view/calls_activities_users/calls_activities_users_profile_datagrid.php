<?php

/** Importação de classes */
use \vendor\model\CallsActivitiesUsers;
use \vendor\controller\calls_activities_users\CallsActivitiesUsersValidate;

/** Instânciamento de classes */
$CallsActivitiesUsers = new CallsActivitiesUsers();
$CallsActivitiesUsersValidate = new CallsActivitiesUsersValidate();

/** Parâmetros de entrada */
$situation = (int)filter_input(INPUT_POST, 'SITUATION', FILTER_SANITIZE_SPECIAL_CHARS);
$CallsActivitiesUsersValidate->setUserId((int)filter_input(INPUT_POST, 'USER_ID', FILTER_SANITIZE_SPECIAL_CHARS));

/** Busco os registros desejados */
$CallsActivitiesUsers = $CallsActivitiesUsers->AllByUserId($CallsActivitiesUsersValidate->getUserId()); ?>

<?php

/** Verifico se existem registros a serem exibidos */
if (count($CallsActivitiesUsers) > 0){ ?>

    <h6>

        Em Aberto

    </h6>

    <div class="row g-2">

        <?php

        /** Consulta os usuário cadastrados*/
        foreach ($CallsActivitiesUsers as $key => $result) {

            /** Defino o nome da função de exclusão */
            $result->delete = 'calls_activities_delete_' . $result->call_activity_id . '_' . rand(1, 1000);

            /** Decodifico as preferencias */
            $result->preferences = (object)json_decode($result->preferences);

            /** Início um novo objeto */
            $result->context_menu = new stdClass();

            /** Informo a div que sera o menu de contexto */
            $result->context_menu->name = 'CallActivityContextMenuName' . $result->call_activity_id;

            /** Informo a div que sera a zone do context menu */
            $result->context_menu->zone = 'CallActivityContextMenuZone' . $result->call_activity_id;

            ?>

            <div class="col-md-3 d-flex">

                <div id="<?php echo $result->context_menu->zone?>" class="card cursor-pointer w-100">

                    <div class="card-header bg-transparent border-0">

                        <small class="text-muted">

                            Chamado: #<?php echo $result->call_id ?> -

                            <?php

                            /** Verifico o status do registro */
                            if (!empty($result->preferences->image)) { ?>

                                <img src="<?php echo $Main->SetIcon($result->preferences->image, 'default/files/default.png'); ?>" alt="<?php echo $result->name; ?>" name="<?php echo $result->name; ?>" class="img-fluid" width="20px">

                            <?php } ?>

                            <?php echo $result->call_name ?>

                        </small>

                        <h6 class="card-title mb-0 curso">

                            <div class="form-check">

                                <input class="form-check-input cursor-pointer" type="checkbox" id="CallActivityId<?php echo $result->call_activity_id ?>" name="CallActivityId<?php echo $result->call_activity_id ?>" <?php echo !empty($result->date_close) ? 'checked' : null ?> onclick="SendRequest('FOLDER=ACTION&TABLE=CALLS_ACTIVITIES&ACTION=CALLS_ACTIVITIES_CLOSE_OR_OPEN&CALL_ACTIVITY_ID=<?php echo @(int)$result->call_activity_id ?>', {target : 'CallsActivitiesLoader<?php echo $result->call_activity_id?>', block : {create : true, info : null, sec : null, target : 'CallsActivitiesLoader<?php echo $result->call_activity_id?>', data : 'Aguarde', color : 'blue', type : 'circle', size : 'sm', message : true}});">
                                <label class="form-check-label cursor-pointer" for="CallActivityId<?php echo $result->call_activity_id ?>">

                                    #<?php echo $result->call_activity_id ?> - <?php echo $result->name ?>

                                </label>

                            </div>

                        </h6>

                    </div>

                    <div class="card-body py-1">

                        <h6 id="CallsActivitiesLoader<?php echo $result->call_activity_id?>"></h6>

                        <div id="CallsActivitiesDatagridSectionAvatar<?php echo @(int)$result->call_activity_id ?>">

                            <script type="text/javascript">

                                SendRequest('FOLDER=VIEW&TABLE=CALLS_ACTIVITIES_USERS&ACTION=CALLS_ACTIVITIES_USERS_AVATAR_LIST&CALL_ACTIVITY_ID=<?php echo @(int)$result->call_activity_id ?>', {target : 'CallsActivitiesDatagridSectionAvatar<?php echo @(int)$result->call_activity_id ?>', block : {create : true, info : null, sec : null, target : 'CallsActivitiesDatagridSectionAvatar<?php echo @(int)$result->call_activity_id ?>', data : 'Aguarde', color : 'blue', type : 'circle', size : 'sm', message : true}});

                            </script>

                        </div>

                        <ul id="<?php echo $result->context_menu->name?>" class="container__menu container__menu--hidden shadow-sm">

                            <li class="container__item" onclick="SendRequest('FOLDER=VIEW&TABLE=CALLS_ACTIVITIES&ACTION=CALLS_ACTIVITIES_DETAILS&CALL_ACTIVITY_ID=<?php echo @(int)$result->call_activity_id ?>&MODAL=1', {target : null, block : {create : true, info : null, sec : null, target : null, data : 'Aguarde', color : 'blue', type : 'circle', size : 'sm', message : true}});">

                                <i class="bi bi-eye me-1"></i>Detalhes

                            </li>

                            <li class="container__item" onclick="SendRequest('FOLDER=VIEW&TABLE=CALLS_ACTIVITIES&ACTION=CALLS_ACTIVITIES_FORM&CALL_ID=<?php echo @(int)$result->call_id ?>&CALL_ACTIVITY_ID=<?php echo @(int)$result->call_activity_id ?>', {target : null, block : {create : true, info : null, sec : null, target : null, data : 'Aguarde', color : 'blue', type : 'circle', size : 'sm', message : true}});">

                                <i class="bi bi-pencil me-1"></i>Editar

                            </li>

                            <li class="container__divider"></li>

                            <li class="container__item" onclick="modalConstruct(true, 'Deseja remover a atividade?', '', 'md', null, null, 'question', <?php echo @(string)$result->delete ?>, null, null)">

                                <i class="bi bi-fire me-1"></i>Remover

                                <script type="text/javascript">

                                    /** Carrega a função de logout */
                                    var <?php echo @(string)$result->delete?> = "SendRequest('FOLDER=ACTION&TABLE=CALLS_ACTIVITIES&ACTION=CALLS_ACTIVITIES_DELETE&CALL_ID=<?php echo @(int)$result->call_id?>&CALL_ACTIVITY_ID=<?php echo @(int)$result->call_activity_id?>', {target : 'pills-activities', block : {create : 'pills-activities', info : null, sec : null, target : null, data : 'Aguarde', color : 'blue', type : 'circle', size : 'sm', message : true}});\"";

                                </script>

                            </li>

                        </ul>

                        <script type="text/javascript">

                            /** Preparo o menu de contexto */
                            PrepareContextMenu('<?php echo $result->context_menu->zone?>', '<?php echo $result->context_menu->name?>');

                        </script>

                    </div>

                    <div class="card-footer border-0 bg-transparent">

                        <span class="badge bg-<?php echo empty($result->call_activity_priority) ? 'primary' : $Main->SetClass($result->call_activity_priority_id); ?>">

                            Prioridade: <?php echo !empty($result->call_activity_priority) ? $result->call_activity_priority : 'Não Possui' ?>

                        </span>

                        <span class="badge bg-primary">

                            Conclusão: <?php echo !empty($result->date_expected) ? date('d/m/Y', strtotime($result->date_expected)) : 'Não Possui' ?>

                        </span>

                        <?php

                        /** Verifico o status do registro */
                        if ((!empty($result->date_close)) && (strtotime(date('Y/m/d')) > strtotime($result->date_expected))) { ?>

                            <span class="badge bg-danger">

                                Em Atraso

                            </span>

                        <?php } ?>

                    </div>

                </div>

            </div>

        <?php } ?>

    </div>

<?php }else{?>

    <div class="card">

        <div class="card-body text-center">

            <h1 class="card-title text-center">

                <span class="badge rounded-pill text-bg-primary">

                    CAU-1

                </span>

            </h1>

            <h4 class="card-subtitle text-center text-muted">

                Não há participações vinculadas

            </h4>

        </div>

    </div>

<?php } ?>
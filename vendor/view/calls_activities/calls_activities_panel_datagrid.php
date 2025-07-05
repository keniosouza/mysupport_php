<?php

/** Importação de classes */
use \vendor\model\CallsActivitiesUsers;
use \vendor\model\CallsActivities;
use \vendor\model\CallsActivitiesPriorities;
use \vendor\controller\calls_activities\CallsActivitiesValidate;

/** Instânciamento de classes */
$CallsActivitiesUsers = new CallsActivitiesUsers();
$CallsActivities = new CallsActivities();
$CallsActivitiesPriorities = new CallsActivitiesPriorities();
$CallsActivitiesValidate = new CallsActivitiesValidate();

/** Parâmetros de entrada */
$CallsActivitiesValidate->setCallId((int)filter_input(INPUT_POST, 'CALL_ID', FILTER_SANITIZE_SPECIAL_CHARS));
$CallsActivitiesValidate->setCompanyId($_SESSION['USERSCOMPANYID']);

/** Busco os registros desejados */
$CallsActivitiesAllSituationResult = $CallsActivities->AllByCompanyIdAndUserId($CallsActivitiesValidate->getCompanyId(), $_SESSION['USERSID']);?>

<div class="row g-1 mb-1">

    <?php

    /** Listo todos os tipos de prioridades existentes */
    foreach ($CallsActivitiesPriorities->all(1) as $key => $result) { ?>

        <div class="col-md-3">

            <button class="btn btn-primary w-100" role="button" data-bs-toggle="button" onclick="Teste('priority-<?php echo $result->call_activity_priority_id?>')">

                <?php echo $result->description ?>

            </button>

        </div>

    <?php } ?>

</div>

<?php

/** Verifico se existem registros a serem exibidos */
if (count($CallsActivitiesAllSituationResult) > 0){ ?>

    <div class="row g-1">

        <?php

        /** Consulta os usuário cadastrados*/
        foreach ($CallsActivitiesAllSituationResult as $key => $result) {

            /** Defino o nome da função de exclusão */
            $result->delete = 'calls_activities_delete_' . $result->call_activity_id . '_' . rand(1, 1000);

            ?>

            <div class="col-md-4 d-flex priority-<?php echo $result->call_activity_priority_id?>" id="CallActivity<?php echo $result->call_activity_id?><?php echo $result->call_activity_priority_id?>">

                <div class="card w-100">

                    <div class="card-body text-break">

                        <img src="<?php echo $Main->SetIcon('image/default/category/' . $result->call_activity_type_id . '.png', 'default/files/default.png'); ?>" width="25px">
                        <img src="<?php echo $Main->SetIcon('image/default/status/' . $result->call_activity_priority_id . '.png', 'default/files/default.png'); ?>" width="25px">

                        <span class="badge bg-<?php echo $Main->SetClass($result->call_activity_priority_id); ?>">

                            Prioridade: <?php echo $result->call_activity_priority ?>

                        </span>

                        <span class="badge bg-primary">

                            Previsto: <?php echo date('d/m/Y', strtotime($result->date_expected)) ?>

                        </span>

                        <span class="badge bg-primary">

                            #<?php echo $result->call_id ?> - <?php echo trim(strip_tags(substr($result->call_name, 0, 50))). '...' ?>

                        </span>

                        <h5 class="card-title">

                            #<?php echo $result->call_activity_id ?>

                            -

                            <?php echo $result->name ?>

                        </h5>

                        <div class="card-text">

                            <?php echo $result->description ?>

                        </div>

                        <?php

                        /** Busco os operadores */
                        $CallsActivitiesUsersAllByActivityIdResult = $CallsActivitiesUsers->AllByActivityId($result->call_activity_id);

                        /** Verifico se devo exibir o grupo de avatar*/
                        if (count($CallsActivitiesUsersAllByActivityIdResult) > 0) {?>

                            <div class="avatar-group avatar-group-sm avatar-group-overlapped">

                                <?php

                                /** Consulta os usuário cadastrados*/
                                foreach ($CallsActivitiesUsersAllByActivityIdResult as $keyUsers => $resultUsers) {?>

                                    <div class="avatar">

                                        <img src="<?php echo $Main->SetIcon($resultUsers->profile_photo, 'default/user.png'); ?>" alt="<?php echo $Main->decryptData(@(string)$resultUsers->name_first); ?>" class="avatar-img rounded-circle bg-primary">

                                    </div>

                                <?php } ?>

                            </div>

                        <?php } ?>

                    </div>

                    <div class="card-footer border-0 bg-transparent">

                        <div class="btn-group btn-group-sm w-100 text-break">

                            <button type="button" class="btn btn-primary" onclick="SendRequest('FOLDER=VIEW&TABLE=CALLS_ACTIVITIES&ACTION=CALLS_ACTIVITIES_DETAILS&CALL_ACTIVITY_ID=<?php echo @(int)$result->call_activity_id ?>&MODAL=1', {target : null, block : {create : true, info : null, sec : null, target : null, data : 'Aguarde', color : 'blue', type : 'circle', size : 'sm', message : true}});">

                                <i class="bi bi-eye me-1"></i>Detalhes

                            </button>

                            <?php

                            /** Verifico se a permissão */
                            if (@(string)$resultUserAcl->chamado->vincular_atividade === 'true') { ?>

                                <?php

                                /** Verifico o status do registro */
                                if (empty(@(string)$result->call_date_close)) { ?>

                                    <button type="button" class="btn btn-primary" onclick="SendRequest('FOLDER=VIEW&TABLE=CALLS_ACTIVITIES&ACTION=CALLS_ACTIVITIES_FORM&CALL_ID=<?php echo @(int)$result->call_id ?>&CALL_ACTIVITY_ID=<?php echo @(int)$result->call_activity_id ?>', {target : null, block : {create : true, info : null, sec : null, target : null, data : 'Aguarde', color : 'blue', type : 'circle', size : 'sm', message : true}});">

                                        <i class="bi bi-pencil me-1"></i>Editar

                                    </button>

                                <?php } ?>

                            <?php } ?>

                            <?php

                            /** Verifico se a permissão */
                            if (@(string)$resultUserAcl->chamado->vincular_atividade === 'true') { ?>

                                <?php

                                /** Verifico o status do registro */
                                if (empty(@(string)$result->call_date_close)) { ?>

                                    <button type="button" class="btn btn-primary" onclick="modalConstruct(true, 'Deseja remover a atividade?', '', 'md', null, null, 'question', <?php echo @(string)$result->delete ?>, null, null)">

                                        <i class="bi bi-fire me-1"></i>Remover

                                        <script type="text/javascript">

                                            /** Carrega a função de logout */
                                            var <?php echo @(string)$result->delete?> = "SendRequest('FOLDER=ACTION&TABLE=CALLS_ACTIVITIES&ACTION=CALLS_ACTIVITIES_DELETE&CALL_ID=<?php echo @(int)$result->call_id?>&CALL_ACTIVITY_ID=<?php echo @(int)$result->call_activity_id?>', {target : 'pills-activities', block : {create : 'pills-activities', info : null, sec : null, target : null, data : 'Aguarde', color : 'blue', type : 'circle', size : 'sm', message : true}});\"";

                                        </script>

                                    </button>

                                <?php } ?>

                            <?php } ?>

                        </div>

                    </div>

                </div>

            </div>

        <?php } ?>

    </div>

    <script>

        function Teste(target) {

            /** Busco os itens existentes dentro do objeto encapsulador */
            var itens = document.getElementsByClassName(target);

            /** Percorro todos o itens localizados */
            for (var i = 0; i < itens.length; i++) {

                /** Removo a classe desejada */
                itens[i].classList.toggle("display-none");

            }

        }

    </script>

<?php }else{?>

    <div class="card">

        <div class="card-body text-center">

            <h1 class="card-title text-center">

                <span class="badge rounded-pill text-bg-primary">

                    CA-1

                </span>

            </h1>

            <h4 class="card-subtitle text-center text-muted">

                Não há atividades vinculadas

            </h4>

        </div>

    </div>

<?php } ?>
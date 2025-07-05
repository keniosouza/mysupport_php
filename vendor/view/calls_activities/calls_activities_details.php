<?php

/** Importação de classes */
use \vendor\model\Notifications;
use \vendor\model\CallsActivities;
use \vendor\model\CallsActivitiesUsers;
use \vendor\controller\calls_activities\CallsActivitiesValidate;

/** Instânciamento de classes */
$Notifications = new Notifications();
$CallsActivities = new CallsActivities();
$CallsActivitiesUsers = new CallsActivitiesUsers();
$CallsActivitiesValidate = new CallsActivitiesValidate();

/** Controle de Exibição */
$modal = @(int)filter_input(INPUT_POST, 'MODAL', FILTER_SANITIZE_SPECIAL_CHARS);

/** Tratamento dos dados de entrada */
$CallsActivitiesValidate->setCallActivityId(@(int)filter_input(INPUT_POST, 'CALL_ACTIVITY_ID', FILTER_SANITIZE_SPECIAL_CHARS));

/** Busco o Registro desejado */
$CallsActivitiesLoadResult = $CallsActivities->Get($CallsActivitiesValidate->getCallActivityId());

/** Defino o nome da função de exclusão */
$CallsActivitiesLoadResult->request = new stdClass();

/** Definição de requisição */
$CallsActivitiesLoadResult->request->save_or_close = "'FOLDER=ACTION&TABLE=CALLS_ACTIVITIES&ACTION=CALLS_ACTIVITIES_CLOSE_OR_OPEN&CALL_ACTIVITY_ID={$CallsActivitiesLoadResult->call_activity_id}', {target : 'CallsActivitiesLoader{$CallsActivitiesLoadResult->call_activity_id}', loader : {create: true, type: 2, padding: '0px', target : 'CallsActivitiesLoader{$CallsActivitiesLoadResult->call_activity_id}', data : 'Aguarde...'}}";

/** Decodifico os daods */
$NotificationsGetLastByTableAndRegisterIdResult = $Notifications->GetLastByTableAndRegisterId((string)'calls_activities', (int)$CallsActivitiesLoadResult->call_activity_id, (int)$_SESSION['USERSID']);

/** Verifico se existe notificação */
if (!empty($NotificationsGetLastByTableAndRegisterIdResult->data))
{

    /** Decodifico os dados da Notificação */
    $NotificationsGetLastByTableAndRegisterIdResult->data = @(object)json_decode($NotificationsGetLastByTableAndRegisterIdResult->data);

}?>

    <div id="CallsActivitiesDetails<?php echo $CallsActivitiesLoadResult->call_activity_id?>">

        <?php

        /** Verifico se devo exibir o alerta */
        if ($NotificationsGetLastByTableAndRegisterIdResult->notification_id > 0) { ?>

            <div class="alert alert-warning alert-dismissible fade show mb-1" role="alert">

                <h6 class="mb-0">

                    Último Andamento em <?php echo date('d/m/Y', strtotime($NotificationsGetLastByTableAndRegisterIdResult->date_register)); ?>:

                </h6>

                <strong>

                    <?php echo $NotificationsGetLastByTableAndRegisterIdResult->data->TITLE; ?>

                </strong>

                <?php echo $NotificationsGetLastByTableAndRegisterIdResult->data->MESSAGE; ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>

            </div>

        <?php } ?>

        <div class="card animate slideIn">

            <div class="card-body">

                <form class="form-check fs-5 fw-semibold" id="CallActivityForm<?php echo @(int)$CallsActivitiesLoadResult->call_activity_id ?>">

                    <input class="form-check-input cursor-pointer" type="checkbox" id="CallActivityId<?php echo $CallsActivitiesLoadResult->call_activity_id ?>" name="CallActivityId<?php echo $CallsActivitiesLoadResult->call_activity_id ?>" <?php echo !empty($CallsActivitiesLoadResult->date_close) ? 'checked' : null ?> onclick="SendRequest(<?php echo $CallsActivitiesLoadResult->request->save_or_close?>);">
                    <label class="form-check-label" data-mysupport-target="CallActivity<?php echo @(int)$CallsActivitiesLoadResult->call_activity_id ?>" data-mysupport-form="CallActivityForm<?php echo @(int)$CallsActivitiesLoadResult->call_activity_id ?>" data-mysupport-name="name" data-mysupport-length="<?php echo $Main->ContentLength((string)$CallsActivitiesLoadResult->name) ?>" contenteditable="true">

                        <?php echo $CallsActivitiesLoadResult->name ?>

                    </label>

                    <input type="hidden" name="FOLDER" value="ACTION"/>
                    <input type="hidden" name="TABLE" value="CALLS_ACTIVITIES"/>
                    <input type="hidden" name="ACTION" value="CALLS_ACTIVITIES_SAVE_NAME"/>
                    <input type="hidden" name="call_id" value="<?php echo @(int)$CallsActivitiesLoadResult->call_id ?>"/>
                    <input type="hidden" name="call_activity_id" value="<?php echo @(int)$CallsActivitiesLoadResult->call_activity_id ?>"/>
                    <input type="hidden" name="section_id" value="<?php echo @(int)$CallsActivitiesLoadResult->section_id ?>"/>

                </form>

                <script type="text/javascript">

                    /** Crio evento personalizado para cada campo de acordo com o atributo */
                    new CustomEventListener('{"event" : "blur", "target" : "CallActivity<?php echo (int)$CallsActivitiesLoadResult->call_activity_id ?>"}');

                </script>

                <div class="row g-2">

                    <div id="CallActivityContextZoneSection<?php echo $CallsActivitiesLoadResult->call_activity_id?>" class="col-md d-flex">

                        <div class="card bg-body-tertiary border-0 w-100 cursor-pointer">

                            <div class="card-body">

                                <h6 class="card-title text-muted fw-normal mb-0">

                                    Seção:

                                </h6>

                                <div class="fs-6 fw-medium" id="CallActivitySection<?php echo $CallsActivitiesLoadResult->call_activity_id?>">

                                    <?php echo !empty($CallsActivitiesLoadResult->section_name) ? $CallsActivitiesLoadResult->section_name : '----';?>

                                </div>

                                <div id="CallActivityContextFormSection<?php echo $CallsActivitiesLoadResult->call_activity_id?>" class="container__form container__form--hidden shadow-sm"></div>

                                <script type="text/javascript">

                                    /** Preparo o menu de contexto */
                                    PrepareContextForm('CallActivityContextZoneSection<?php echo $CallsActivitiesLoadResult->call_activity_id?>', 'CallActivityContextFormSection<?php echo $CallsActivitiesLoadResult->call_activity_id?>', 'FOLDER=VIEW&TABLE=CALLS_ACTIVITIES&ACTION=CALLS_ACTIVITIES_FORM_ADJUST_SECTION&CALL_ACTIVITY_ID=<?php echo @(int)$CallsActivitiesLoadResult->call_activity_id?>');

                                </script>

                            </div>

                        </div>

                    </div>

                    <div id="CallActivityContextZonePriority<?php echo $CallsActivitiesLoadResult->call_activity_id?>" class="col-md d-flex">

                        <div class="card bg-body-tertiary border-0 w-100 cursor-pointer">

                            <div class="card-body">

                                <h6 class="card-title text-muted fw-normal mb-0">

                                    Prioridade:

                                </h6>

                                <div class="fs-6 fw-medium" id="CallActivityPriority<?php echo $CallsActivitiesLoadResult->call_activity_id?>">

                                    <?php echo !empty($CallsActivitiesLoadResult->call_activity_priority) ? $CallsActivitiesLoadResult->call_activity_priority : '----';?>

                                </div>

                                <div id="CallActivityContextFormPriority<?php echo $CallsActivitiesLoadResult->call_activity_id?>" class="container__form container__form--hidden shadow-sm"></div>

                                <script type="text/javascript">

                                    /** Preparo o menu de contexto */
                                    PrepareContextForm('CallActivityContextZonePriority<?php echo $CallsActivitiesLoadResult->call_activity_id?>', 'CallActivityContextFormPriority<?php echo $CallsActivitiesLoadResult->call_activity_id?>', 'FOLDER=VIEW&TABLE=CALLS_ACTIVITIES&ACTION=CALLS_ACTIVITIES_FORM_ADJUST_PRIORITY&CALL_ACTIVITY_ID=<?php echo @(int)$CallsActivitiesLoadResult->call_activity_id?>');

                                </script>

                            </div>

                        </div>

                    </div>

                    <div id="CallActivityContextZoneType<?php echo $CallsActivitiesLoadResult->call_activity_id?>" class="col-md d-flex">

                        <div class="card bg-body-tertiary border-0 w-100 cursor-pointer">

                            <div class="card-body">

                                <h6 class="card-title text-muted fw-normal mb-0">

                                    Categoria:

                                </h6>

                                <div class="fs-6 fw-medium" id="CallActivityType<?php echo $CallsActivitiesLoadResult->call_activity_id?>">

                                    <?php echo !empty($CallsActivitiesLoadResult->call_activity_type) ? $CallsActivitiesLoadResult->call_activity_type: '----';?>

                                </div>

                                <div id="CallActivityContextFormType<?php echo $CallsActivitiesLoadResult->call_activity_id?>" class="container__form container__form--hidden shadow-sm"></div>

                                <script type="text/javascript">

                                    /** Preparo o menu de contexto */
                                    PrepareContextForm('CallActivityContextZoneType<?php echo $CallsActivitiesLoadResult->call_activity_id?>', 'CallActivityContextFormType<?php echo $CallsActivitiesLoadResult->call_activity_id?>', 'FOLDER=VIEW&TABLE=CALLS_ACTIVITIES&ACTION=CALLS_ACTIVITIES_FORM_ADJUST_TYPE&CALL_ACTIVITY_ID=<?php echo @(int)$CallsActivitiesLoadResult->call_activity_id?>');

                                </script>

                            </div>

                        </div>

                    </div>

                    <div id="CallActivityContextZoneLevel<?php echo $CallsActivitiesLoadResult->call_activity_id?>" class="col-md d-flex">

                        <div class="card bg-body-tertiary border-0 w-100 cursor-pointer">

                            <div class="card-body">

                                <h6 class="card-title text-muted fw-normal mb-0">

                                    Nível:

                                </h6>

                                <div class="fs-6 fw-medium" id="CallActivityLevel<?php echo $CallsActivitiesLoadResult->call_activity_id?>">

                                    <?php echo !empty($CallsActivitiesLoadResult->call_activity_level) ? $CallsActivitiesLoadResult->call_activity_level: '----';?>

                                </div>

                                <div id="CallActivityContextFormLevel<?php echo $CallsActivitiesLoadResult->call_activity_id?>" class="container__form container__form--hidden shadow-sm"></div>

                                <script type="text/javascript">

                                    /** Preparo o menu de contexto */
                                    PrepareContextForm('CallActivityContextZoneLevel<?php echo $CallsActivitiesLoadResult->call_activity_id?>', 'CallActivityContextFormLevel<?php echo $CallsActivitiesLoadResult->call_activity_id?>', 'FOLDER=VIEW&TABLE=CALLS_ACTIVITIES&ACTION=CALLS_ACTIVITIES_FORM_ADJUST_LEVEL&CALL_ACTIVITY_ID=<?php echo @(int)$CallsActivitiesLoadResult->call_activity_id?>');

                                </script>

                            </div>

                        </div>

                    </div>

                    <div id="CallActivityContextZoneExpected<?php echo $CallsActivitiesLoadResult->call_activity_id?>" class="col-md d-flex">

                        <div class="card bg-body-tertiary border-0 w-100 cursor-pointer">

                            <div class="card-body">

                                <h6 class="card-title text-muted fw-normal mb-0">

                                    Previsão:

                                </h6>

                                <div class="fs-6 fw-medium" id="CallActivityDateExpected<?php echo $CallsActivitiesLoadResult->call_activity_id?>">

                                    <?php

                                    /** Verifico o status do registro */
                                    if ((empty($CallsActivitiesLoadResult->date_close)) && (strtotime(date('Y/m/d')) === strtotime($CallsActivitiesLoadResult->date_expected))) { ?>

                                        <img src="image/default/warning.gif" width="25px">

                                    <?php } ?>

                                    <?php echo !empty($CallsActivitiesLoadResult->date_expected) ? date('d/m/Y', strtotime($CallsActivitiesLoadResult->date_expected)) : '----'?>

                                    <?php

                                    /** Verifico o status do registro */
                                    if ((empty($CallsActivitiesLoadResult->date_close)) && (strtotime(date('Y/m/d')) === strtotime($CallsActivitiesLoadResult->date_expected))) { ?>

                                        <span class="badge bg-warning">

                                             Dia de Entrega

                                        </span>

                                    <?php } ?>

                                </div>

                                <div id="CallActivityContextFormExpected<?php echo $CallsActivitiesLoadResult->call_activity_id?>" class="container__form container__form--hidden shadow-sm"></div>

                                <script type="text/javascript">

                                    /** Preparo o menu de contexto */
                                    PrepareContextForm('CallActivityContextZoneExpected<?php echo $CallsActivitiesLoadResult->call_activity_id?>', 'CallActivityContextFormExpected<?php echo $CallsActivitiesLoadResult->call_activity_id?>', 'FOLDER=VIEW&TABLE=CALLS_ACTIVITIES&ACTION=CALLS_ACTIVITIES_FORM_ADJUST_EXPECTED&CALL_ACTIVITY_ID=<?php echo @(int)$CallsActivitiesLoadResult->call_activity_id?>');

                                </script>

                            </div>

                        </div>

                    </div>

                    <div id="CallActivityContextZoneCall<?php echo $CallsActivitiesLoadResult->call_activity_id?>" class="col-md-12 d-flex">

                        <div class="card bg-body-tertiary border-0 w-100 cursor-pointer">

                            <div class="card-body">

                                <?php

                                /** Verifico se o item deve ser exibido em formato de modal */
                                if ($modal === 0){ ?>

                                    <h6 class="card-title text-muted fw-normal mb-0" onclick="SendRequest('FOLDER=VIEW&TABLE=CALLS&ACTION=CALLS_DETAILS&CALL_ID=<?php echo $CallsActivitiesLoadResult->call_id ?>', {target : null, loader : {create: true, padding: '0px', type: 2, target : 'wrapper', data : 'Aguarde...'}});">

                                        <i class="bi bi-box-arrow-up-right me-1"></i>Chamado:

                                    </h6>

                                <?php }else{?>

                                    <h6 class="card-title text-muted fw-normal mb-0">

                                        Chamado:

                                    </h6>

                                <?php }?>

                                <div class="fs-6 fw-medium" id="CallActivityCall<?php echo $CallsActivitiesLoadResult->call_activity_id?>">

                                    #<?php echo $CallsActivitiesLoadResult->call_id ?> - <?php echo $CallsActivitiesLoadResult->call_name ?>

                                </div>

                                <div id="CallActivityContextFormCall<?php echo $CallsActivitiesLoadResult->call_activity_id?>" class="container__form container__form--hidden shadow-sm"></div>

                                <script type="text/javascript">

                                    /** Preparo o menu de contexto */
                                    PrepareContextForm('CallActivityContextZoneCall<?php echo $CallsActivitiesLoadResult->call_activity_id?>', 'CallActivityContextFormCall<?php echo $CallsActivitiesLoadResult->call_activity_id?>', 'FOLDER=VIEW&TABLE=CALLS_ACTIVITIES&ACTION=CALLS_ACTIVITIES_FORM_ADJUST_CALL&CALL_ACTIVITY_ID=<?php echo @(int)$CallsActivitiesLoadResult->call_activity_id?>');

                                </script>

                            </div>

                        </div>

                    </div>

                    <div class="col-md-12">

                        <div id="CallsActivitiesUsersAvatarListWrapper<?php echo @(int)$CallsActivitiesLoadResult->call_activity_id ?>">

                            <script type="text/javascript">

                                SendRequest('FOLDER=VIEW&TABLE=CALLS_ACTIVITIES_USERS&ACTION=CALLS_ACTIVITIES_USERS_AVATAR_LIST&CALL_ACTIVITY_ID=<?php echo @(int)$CallsActivitiesLoadResult->call_activity_id ?>&MODAL=1', {target : 'CallsActivitiesUsersAvatarListWrapper<?php echo @(int)$CallsActivitiesLoadResult->call_activity_id ?>', block : {create : true, info : null, sec : null, target : 'CallsActivitiesUsersAvatarListWrapper<?php echo @(int)$CallsActivitiesLoadResult->call_activity_id ?>', data : 'Aguarde', color : 'blue', type : 'circle', size : 'sm', message : true}});

                            </script>

                        </div>

                    </div>

                </div>

            </div>

            <div class="card-footer bg-transparent px-0 py-1 border-top">

                <nav class="navbar navbar-expand-lg bg-transparent rounded py-2">

                    <div class="container-fluid">

                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCall<?php echo $CallsActivitiesLoadResult->call_id?>" aria-controls="navbarCall<?php echo $CallsActivitiesLoadResult->call_id?>" aria-expanded="false" aria-label="Toggle navigation">

                            <span class="navbar-toggler-icon"></span>

                        </button>

                        <div class="collapse navbar-collapse" id="navbarCallActivity<?php echo $CallsActivitiesLoadResult->call_activity_id?>">

                            <ul class="navbar-nav me-auto mb-lg-0">

                                <li class="nav-item">

                                    <a class="nav-link cursor-pointer" onclick="SendRequest('FOLDER=VIEW&TABLE=CALLS_ACTIVITIES&ACTION=CALLS_ACTIVITIES_FORM_ADJUST_DESCRIPTION&CALL_ACTIVITY_ID=<?php echo @(int)$CallsActivitiesLoadResult->call_activity_id ?>', {target : 'CallsActivitiesDetailsWrapper<?php echo $CallsActivitiesLoadResult->call_activity_id?>', loader : {create: true, padding: '0px', type: 2, target : 'CallsActivitiesDetailsWrapper<?php echo $CallsActivitiesLoadResult->call_activity_id?>', data : 'Aguarde...'}});">

                                        <i class="bi bi-justify-left me-1"></i>Descrição

                                    </a>

                                </li>

                                <li class="nav-item">

                                    <a class="nav-link cursor-pointer" onclick="SendRequest('FOLDER=VIEW&TABLE=CALLS_ACTIVITIES&ACTION=CALLS_ACTIVITIES_MESSAGES&CALL_ACTIVITY_ID=<?php echo @(int)$CallsActivitiesLoadResult->call_activity_id ?>', {target : 'CallsActivitiesDetailsWrapper<?php echo $CallsActivitiesLoadResult->call_activity_id?>', loader : {create: true, padding: '0px', type: 2, target : 'CallsActivitiesDetailsWrapper<?php echo $CallsActivitiesLoadResult->call_activity_id?>', data : 'Aguarde...'}});">

                                        <i class="bi bi-chat me-1"></i>Mensagens

                                    </a>

                                </li>

                                <li class="nav-item">

                                    <a class="nav-link cursor-pointer" onclick="SendRequest('FOLDER=VIEW&TABLE=CALLS_ACTIVITIES_FILES&ACTION=CALLS_ACTIVITIES_FILES_HOME&CALL_ACTIVITY_ID=<?php echo @(int)$CallsActivitiesLoadResult->call_activity_id ?>', {target : 'CallsActivitiesDetailsWrapper<?php echo $CallsActivitiesLoadResult->call_activity_id?>', loader : {create: true, type: 2, padding: '0px', target : 'CallsActivitiesDetailsWrapper<?php echo $CallsActivitiesLoadResult->call_activity_id?>', data : 'Aguarde...'}});">

                                        <i class="bi bi-file-earmark me-1"></i>Arquivos

                                    </a>

                                </li>

                            </ul>

                        </div>

                    </div>

                </nav>

            </div>

        </div>

        <div id="CallsActivitiesDetailsWrapper<?php echo $CallsActivitiesLoadResult->call_activity_id?>" class="pt-1"></div>

    </div>

    <script type="text/javascript">

        /** Enio de requisição */
        SendRequest('FOLDER=VIEW&TABLE=CALLS_ACTIVITIES&ACTION=CALLS_ACTIVITIES_MESSAGES&CALL_ACTIVITY_ID=<?php echo @(int)$CallsActivitiesLoadResult->call_activity_id ?>', {target : 'CallsActivitiesDetailsWrapper<?php echo $CallsActivitiesLoadResult->call_activity_id?>', loader : {create: true, type: 2, padding: '0px', target : 'CallsActivitiesDetailsWrapper<?php echo $CallsActivitiesLoadResult->call_activity_id?>', data : 'Aguarde...'}});

    </script>

<?php

/** Verifico se o item deve ser exibido em formato de modal */
if ($modal > 0){

    /** Prego a estrutura do arquivo */
    $html = ob_get_contents();

    /** Removo o arquivo incluido */
    ob_clean();

    /** Result **/
    $result = array(

        'code' => 201,
        'title' => 'Chamados / Atividades / ',
        'data' => $html,
        'size' => 'lg',
        'color_modal' => null,
        'color_border' => null,
        'type' => null,
        'procedure' => null,
        'time' => null

    );

    /** Envio **/
    echo json_encode($result);

    /** Paro o procedimento **/
    exit;

}
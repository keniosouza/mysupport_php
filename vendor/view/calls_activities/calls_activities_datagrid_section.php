<?php

/** Importação de classes */
use vendor\model\CallsActivitiesUsers;
use vendor\model\CallsActivities;
use vendor\controller\calls_activities\CallsActivitiesValidate;

/** Instânciamento de classes */
$CallsActivitiesUsers = new CallsActivitiesUsers();
$CallsActivities = new CallsActivities();
$CallsActivitiesValidate = new CallsActivitiesValidate();

/** Parâmetros de entrada */
$CallsActivitiesValidate->setCallId((int)filter_input(INPUT_POST, 'CALL_ID', FILTER_SANITIZE_SPECIAL_CHARS));
$CallsActivitiesValidate->setCompanyId((int)$_SESSION['USERSCOMPANYID']);
$CallsActivitiesValidate->setSectionId((int)filter_input(INPUT_POST, 'SECTION_ID', FILTER_SANITIZE_SPECIAL_CHARS));

/** Verifico se devo buscar atividades sem seção */
if ($CallsActivitiesValidate->getSectionId() === 0)
{

    /** Busco os registros desejados */
    $CallsActivitiesAllBySectionIdResult = $CallsActivities->All($CallsActivitiesValidate->getCallId());

}
else{

    /** Busco os registros desejados */
    $CallsActivitiesAllBySectionIdResult = $CallsActivities->AllBySectionId($CallsActivitiesValidate->getSectionId());

}

/** Consulta os usuário cadastrados*/
foreach ($CallsActivitiesAllBySectionIdResult as $key => $result) {

    /** Defino o nome da função de exclusão */
    $result->delete = 'calls_activities_delete_' . $result->call_activity_id . '_' . rand(1, 1000);

    /** Defino o nome da função de exclusão */
    $result->request = new stdClass();

    /** Definição de requisição */
    $result->request->save_or_close = "'FOLDER=ACTION&TABLE=CALLS_ACTIVITIES&ACTION=CALLS_ACTIVITIES_CLOSE_OR_OPEN&CALL_ACTIVITY_ID={$result->call_activity_id}', {target : 'CallsActivitiesLoader{$result->call_activity_id}', block : {create : true, info : null, sec : null, target : 'CallsActivitiesLoader{$result->call_activity_id}', data : 'Aguarde', color : 'blue', type : 'circle', size : 'sm', message : true}}";

    /** Início um novo objeto */
    $result->context_menu = new stdClass();

    /** Informo a div que sera o menu de contexto */
    $result->context_menu->name = 'CallActivityContextMenuName' . $result->call_activity_id;

    /** Informo a div que sera a zone do context menu */
    $result->context_menu->zone = 'CallActivityContextMenuZone' . $result->call_activity_id; ?>

    <div id="<?php echo $result->context_menu->zone?>" class="card <?php echo ($key + 1) < count($CallsActivitiesAllBySectionIdResult) ? 'mb-1' : null; ?> cursor-pointer">

        <div class="card-header bg-transparent border-0">

            <form class="form-check fs-6 fw-semibold" id="CallActivityForm<?php echo @(int)$result->call_activity_id ?>">

                <input class="form-check-input cursor-pointer" type="checkbox" id="CallActivityId<?php echo $result->call_activity_id ?>" name="CallActivityId<?php echo $result->call_activity_id ?>" <?php echo !empty($result->date_close) ? 'checked' : null ?> onclick="SendRequest(<?php echo $result->request->save_or_close?>);">
                <label class="form-check-label" data-mysupport-target="CallActivity<?php echo @(int)$result->call_activity_id ?>" data-mysupport-form="CallActivityForm<?php echo @(int)$result->call_activity_id ?>" data-mysupport-length="<?php echo $Main->ContentLength((string)$result->name) ?>" data-mysupport-name="name" contenteditable="true">

                    <?php echo $result->name ?>

                </label>

                <input type="hidden" name="FOLDER" value="ACTION"/>
                <input type="hidden" name="TABLE" value="CALLS_ACTIVITIES"/>
                <input type="hidden" name="ACTION" value="CALLS_ACTIVITIES_SAVE_NAME"/>
                <input type="hidden" name="call_id" value="<?php echo @(int)$result->call_id ?>"/>
                <input type="hidden" name="call_activity_id" value="<?php echo @(int)$result->call_activity_id ?>"/>
                <input type="hidden" name="section_id" value="<?php echo @(int)$result->section_id ?>"/>

            </form>

            <script type="text/javascript">

                /** Crio evento personalizado para cada campo de acordo com o atributo */
                new CustomEventListener('{"event" : "blur", "target" : "CallActivity<?php echo (int)$result->call_activity_id ?>"}');

            </script>

        </div>

        <div class="card-body">

            <h6 id="CallsActivitiesLoader<?php echo $result->call_activity_id?>"></h6>

            <div id="CallsActivitiesDatagridSectionAvatar<?php echo @(int)$result->call_activity_id ?>">

                <script type="text/javascript">

                    SendRequest('FOLDER=VIEW&TABLE=CALLS_ACTIVITIES_USERS&ACTION=CALLS_ACTIVITIES_USERS_AVATAR_LIST&CALL_ACTIVITY_ID=<?php echo @(int)$result->call_activity_id ?>', {target : 'CallsActivitiesDatagridSectionAvatar<?php echo @(int)$result->call_activity_id ?>', loader : {create: true, padding: '0px', type: 2, target : 'CallsActivitiesDatagridSectionAvatar<?php echo @(int)$result->call_activity_id ?>', data : 'Aguarde...'}});

                </script>

            </div>

            <ul id="<?php echo $result->context_menu->name?>" class="container__menu container__menu--hidden shadow-sm">

                <li class="container__item" id="CallsActivitiesDetailsButton<?php echo @(int)$result->call_activity_id ?>" onclick="SendRequest('FOLDER=VIEW&TABLE=CALLS_ACTIVITIES&ACTION=CALLS_ACTIVITIES_DETAILS&CALL_ACTIVITY_ID=<?php echo @(int)$result->call_activity_id ?>&MODAL=1', {target : null, loader : {create: true, padding: '0px', type: 3, target : 'CallsActivitiesDetailsButton<?php echo @(int)$result->call_activity_id ?>', data : 'Aguarde...'}});">

                    <i class="bi bi-eye me-1"></i>Detalhes

                </li>

                <li class="container__divider"></li>

                <li class="container__item" onclick="modalConstruct(true, 'Deseja remover a atividade?', '', 'md', null, null, 'question', <?php echo $result->delete ?>, null, null)">

                    <i class="bi bi-fire me-1"></i>Remover

                    <script type="text/javascript">

                        /** Carrega a função de logout */
                        var <?php echo $result->delete?> = "SendRequest('FOLDER=ACTION&TABLE=CALLS_ACTIVITIES&ACTION=CALLS_ACTIVITIES_DELETE&CALL_ID=<?php echo @(int)$result->call_id?>&CALL_ACTIVITY_ID=<?php echo @(int)$result->call_activity_id?>', {target : 'pills-activities', block : {create : 'pills-activities', info : null, sec : null, target : null, data : 'Aguarde', color : 'blue', type : 'circle', size : 'sm', message : true}});\"";

                    </script>

                </li>

            </ul>

            <script type="text/javascript">

                /** Preparo o menu de contexto */
                PrepareContextMenu('<?php echo $result->context_menu->zone?>', '<?php echo $result->context_menu->name?>');

            </script>

        </div>

    </div>

<?php } ?>
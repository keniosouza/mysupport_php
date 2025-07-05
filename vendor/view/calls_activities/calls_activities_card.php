<?php

/** Busco os registros desejados */
$CallsActivitiesGetResult = $CallsActivities->GetLast();

/** Defino o nome da função de exclusão */
$CallsActivitiesGetResult->delete = 'calls_activities_delete_' . $CallsActivitiesGetResult->call_activity_id . '_' . rand(1, 1000);

/** Defino o nome da função de exclusão */
$CallsActivitiesGetResult->request = new stdClass();

/** Definição de requisição */
$CallsActivitiesGetResult->request->save_or_close = "'FOLDER=ACTION&TABLE=CALLS_ACTIVITIES&ACTION=CALLS_ACTIVITIES_CLOSE_OR_OPEN&CALL_ACTIVITY_ID={$CallsActivitiesGetResult->call_activity_id}', {target : 'CallsActivitiesLoader{$CallsActivitiesGetResult->call_activity_id}', block : {create : true, info : null, sec : null, target : 'CallsActivitiesLoader{$CallsActivitiesGetResult->call_activity_id}', data : 'Aguarde', color : 'blue', type : 'circle', size : 'sm', message : true}}";

/** Início um novo objeto */
$CallsActivitiesGetResult->context_menu = new stdClass();

/** Informo a div que sera o menu de contexto */
$CallsActivitiesGetResult->context_menu->name = 'CallActivityContextMenuName' . $CallsActivitiesGetResult->call_activity_id;

/** Informo a div que sera a zone do context menu */
$CallsActivitiesGetResult->context_menu->zone = 'CallActivityContextMenuZone' . $CallsActivitiesGetResult->call_activity_id; ?>

<div id="<?php echo $CallsActivitiesGetResult->context_menu->zone?>" class="card mb-1 cursor-pointer">

    <div class="card-header bg-transparent border-0">

        <form class="form-check fs-6 fw-semibold" id="CallActivityForm<?php echo @(int)$CallsActivitiesGetResult->call_activity_id ?>">

            <input class="form-check-input cursor-pointer" type="checkbox" id="CallActivityId<?php echo $CallsActivitiesGetResult->call_activity_id ?>" name="CallActivityId<?php echo $CallsActivitiesGetResult->call_activity_id ?>" <?php echo !empty($CallsActivitiesGetResult->date_close) ? 'checked' : null ?> onclick="SendRequest(<?php echo $CallsActivitiesGetResult->request->save_or_close?>);">
            <label class="form-check-label" data-mysupport-target="CallActivity<?php echo @(int)$CallsActivitiesGetResult->call_activity_id ?>" data-mysupport-form="CallActivityForm<?php echo @(int)$CallsActivitiesGetResult->call_activity_id ?>" data-mysupport-value="<?php echo @(string)$CallsActivitiesGetResult->name ?>" data-mysupport-name="name" contenteditable="true">

                <?php echo $CallsActivitiesGetResult->name ?>

            </label>

            <input type="hidden" name="FOLDER" value="ACTION"/>
            <input type="hidden" name="TABLE" value="CALLS_ACTIVITIES"/>
            <input type="hidden" name="ACTION" value="CALLS_ACTIVITIES_SAVE_NAME"/>
            <input type="hidden" name="call_id" value="<?php echo @(int)$CallsActivitiesGetResult->call_id ?>"/>
            <input type="hidden" name="call_activity_id" value="<?php echo @(int)$CallsActivitiesGetResult->call_activity_id ?>"/>
            <input type="hidden" name="section_id" value="<?php echo @(int)$CallsActivitiesGetResult->section_id ?>"/>

        </form>

        <script type="text/javascript">

            /** Crio evento personalizado para cada campo de acordo com o atributo */
            new CustomEventListener('{"event" : "blur", "target" : "CallActivity<?php echo (int)$CallsActivitiesGetResult->call_activity_id ?>"}');

        </script>

    </div>

    <div class="card-body">

        <h6 id="CallsActivitiesLoader<?php echo $CallsActivitiesGetResult->call_activity_id?>"></h6>

        <div id="CallsActivitiesDatagridSectionAvatar<?php echo @(int)$CallsActivitiesGetResult->call_activity_id ?>">

            <script type="text/javascript">

                SendRequest('FOLDER=VIEW&TABLE=CALLS_ACTIVITIES_USERS&ACTION=CALLS_ACTIVITIES_USERS_AVATAR_LIST&CALL_ACTIVITY_ID=<?php echo @(int)$CallsActivitiesGetResult->call_activity_id ?>', {target : 'CallsActivitiesDatagridSectionAvatar<?php echo @(int)$CallsActivitiesGetResult->call_activity_id ?>', block : {create : true, info : null, sec : null, target : 'CallsActivitiesDatagridSectionAvatar<?php echo @(int)$CallsActivitiesGetResult->call_activity_id ?>', data : 'Aguarde', color : 'blue', type : 'circle', size : 'sm', message : true}});

            </script>

        </div>

        <ul id="<?php echo $CallsActivitiesGetResult->context_menu->name?>" class="container__menu container__menu--hidden shadow-sm">

            <li class="container__item" onclick="SendRequest('FOLDER=VIEW&TABLE=CALLS_ACTIVITIES&ACTION=CALLS_ACTIVITIES_DETAILS&CALL_ACTIVITY_ID=<?php echo @(int)$CallsActivitiesGetResult->call_activity_id ?>&MODAL=1', {target : null, block : {create : true, info : null, sec : null, target : null, data : 'Aguarde', color : 'blue', type : 'circle', size : 'sm', message : true}});">

                <i class="bi bi-eye me-1"></i>Detalhes

            </li>

            <li class="container__divider"></li>

            <li class="container__item" onclick="modalConstruct(true, 'Deseja remover a atividade?', '', 'md', null, null, 'question', <?php echo $CallsActivitiesGetResult->delete ?>, null, null)">

                <i class="bi bi-fire me-1"></i>Remover

                <script type="text/javascript">

                    /** Carrega a função de logout */
                    var <?php echo $CallsActivitiesGetResult->delete?> = "SendRequest('FOLDER=ACTION&TABLE=CALLS_ACTIVITIES&ACTION=CALLS_ACTIVITIES_DELETE&CALL_ID=<?php echo @(int)$CallsActivitiesGetResult->call_id?>&CALL_ACTIVITY_ID=<?php echo @(int)$CallsActivitiesGetResult->call_activity_id?>', {target : 'pills-activities', block : {create : 'pills-activities', info : null, sec : null, target : null, data : 'Aguarde', color : 'blue', type : 'circle', size : 'sm', message : true}});\"";

                </script>

            </li>

        </ul>

        <script type="text/javascript">

            /** Preparo o menu de contexto */
            PrepareContextMenu('<?php echo $CallsActivitiesGetResult->context_menu->zone?>', '<?php echo $CallsActivitiesGetResult->context_menu->name?>');

        </script>

    </div>

</div>
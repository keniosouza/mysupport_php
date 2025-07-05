<?php

/** Importação de classes */
use \vendor\controller\main\Main;
use \vendor\model\CallsActivitiesUsers;
use \vendor\controller\calls_activities_users\CallsActivitiesUsersValidate;

/** Instânciamento de classes */
$Main = new Main();
$CallsActivitiesUsers = new CallsActivitiesUsers();
$CallsActivitiesUsersValidate = new CallsActivitiesUsersValidate();

/** Tratamento dos dados de entrada */
$CallsActivitiesUsersValidate->setCallActivityUserId(@(int)filter_input(INPUT_POST, 'CALL_ACTIVITY_USER_ID', FILTER_SANITIZE_SPECIAL_CHARS));

/** Realizo a busca do registro */
$resultCallsActivitiesUsers = $CallsActivitiesUsers->Load($CallsActivitiesUsersValidate->getCallActivityUserId());

/** Verifico se a foto esta preenchida */
if (empty(@(string)$resultCallsActivitiesUsers->profile_photo)) {

    /** Atualizo o caminho da foto de perfil */
    $resultCallsActivitiesUsers->profile_photo = 'image/default/user.png';

} ?>

<div class="media">

    <img src="<?php echo $resultCallsActivitiesUsers->profile_photo; ?>" class="me-3 rounded" width="64px">

    <div class="media-body">

        <h5 class="mt-0">

            <?php echo $Main->decryptData($resultCallsActivitiesUsers->name_first); ?> <?php echo $Main->decryptData($resultCallsActivitiesUsers->name_last); ?>

        </h5>

        <p>

            <?php echo $resultCallsActivitiesUsers->email; ?>

        </p>

    </div>

</div>

<div class="main-card card shadow-sm mb-2">

    <div class="card-body">

        <div class="vertical-timeline vertical-timeline--animate vertical-timeline--one-column">

            <?php

            /** Pego o histórico existente */
            $history = json_decode($resultCallsActivitiesUsers->history, TRUE);

            /** Listo os acessos realizados */
            foreach ($history as $keyResultHistory => $resultHistory) { ?>

                <div class="vertical-timeline-item vertical-timeline-element">

                    <div>

                        <span class="vertical-timeline-element-icon bounce-in">

                            <i class="badge badge-dot badge-dot-xl <?php echo @(string)$resultHistory['class'] ?>"> </i>

                        </span>

                        <div class="vertical-timeline-element-content bounce-in">

                            <h4 class="timeline-title">

                                <?php echo @(string)$resultHistory['title'] ?> - <?php echo @(string)$resultHistory['user'] ?>

                            </h4>

                            <p>

                                <?php echo @(string)$resultHistory['description'] ?>

                                <a href="javascript:void(0);" data-abc="true">

                                    <?php echo @(string)$resultHistory['date'] ?>

                                </a>

                            </p>

                            <span class="vertical-timeline-element-date">

                                <?php echo @(string)$resultHistory['time'] ?>

                            </span>

                        </div>

                    </div>

                </div>

            <?php } ?>

        </div>

    </div>

</div>

<?php

/** Verifico se a permissão */
if (@(string)$resultUserAcl->chamado->vincular_operador === 'true') { ?>

    <button class="btn btn-danger-soft w-100" type="button" onclick="request('FOLDER=ACTION&TABLE=CALLS_ACTIVITIES_USERS&ACTION=CALLS_ACTIVITIES_USERS_DELETE&CALL_ID=<?php echo @(int)$resultCallsActivitiesUsers->call_id ?>&CALL_ACTIVITY_ID=<?php echo @(int)$resultCallsActivitiesUsers->call_activity_id ?>&CALL_ACTIVITY_USER_ID=<?php echo @(int)$resultCallsActivitiesUsers->call_activity_user_id ?>', '', true, '', 0, '', 'Removendo usuário', 'yellow', 'circle', 'sm', true)">

        <i class="bi bi-fire me-1"></i>

        Remover operador

    </button>

<?php } ?>

<?php

/** Pego a estrutura do arquivo */
$div = ob_get_contents();

/** Removo o arquivo incluido */
ob_clean();

/** Result **/
$result = array(

    'code' => 201,
    'data' => $div,
    'title' => 'Detalhes do operador',
    'width' => '840',

);

/** Envio **/
echo json_encode($result);

/** Paro o procedimento **/
exit;

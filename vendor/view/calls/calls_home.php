<?php

/** Importação de classes */
use \vendor\model\Calls;
use \vendor\controller\calls\CallsValidate;
use \vendor\model\CallsActivities;

/** Instânciamento de classes */
$Calls = new Calls();
$CallsValidate = new CallsValidate();
$CallsActivities = new CallsActivities();

/** Tratamento dos dados de entrada */
$CallsValidate->setCallId(@(int)filter_input(INPUT_POST, 'CALL_ID', FILTER_SANITIZE_SPECIAL_CHARS));
$CallsValidate->setCompanyId(@(int)$_SESSION['USERSCOMPANYID']);
$CallsActivitiesCountCallActivityPriorityIdResult = $CallsActivities->CountCallActivityPriorityId($CallsValidate->getCallId());

/** Busca de registro */
$CallsGetResult = $Calls->Get($CallsValidate->getCallId());

/** Decodifico as preferencias do chamado */
$CallsGetResult->preferences = (object)json_decode($CallsGetResult->preferences);

/** Verifico se o registro foi localizado */
if ($CallsGetResult->call_id > 0) {?>

<div class="card mb-2">

    <div class="card-body pb-0">

        <div class="d-flex align-items-center">

            <div class="flex-shrink-0 bg-light-subtle border p-2 rounded cursor-pointer" onclick="SendRequest('FOLDER=VIEW&TABLE=CALLS&ACTION=CALLS_PROFILE&CALL_ID=<?php echo $CallsGetResult->call_id?>', {target : null, block : {create : true, info : null, sec : null, target : null, data : 'Aguarde', color : 'blue', type : 'circle', size : 'sm', message : true}});">

                <img src="<?php echo $Main->SetIcon($CallsGetResult->preferences->image, 'default/files/default.png'); ?>" alt="<?php echo $CallsGetResult->name; ?>" name="<?php echo $CallsGetResult->name; ?>" class="img-fluid" width="50px">

            </div>

            <div class="flex-grow-1 ms-3">

                <h5 class="card-title">

                    <div class="form-check">

                        <input class="form-check-input cursor-pointer" type="checkbox" <?php echo !empty($CallsGetResult->date_close) ? 'checked' : null ?> onclick="SendRequest('FOLDER=ACTION&TABLE=CALLS&ACTION=CALLS_CLOSE_OR_OPEN&CALL_ID=<?php echo @(int)$CallsGetResult->call_id?>', {target : null, block : {create : true, info : null, sec : null, target : null, data : 'Aguarde', color : 'blue', type : 'circle', size : 'sm', message : true}});">
                        <label class="form-check-label cursor-pointer" for="flexCheckDefault">

                            #<?php echo $CallsGetResult->call_id ?> - <?php echo $CallsGetResult->name ?>

                        </label>

                    </div>

                </h5>

                <?php

                /** Consulta os usuário cadastrados*/
                foreach ($CallsActivitiesCountCallActivityPriorityIdResult as $key => $result) {?>

                    <?php

                    /** Verifico o status do registro */
                    if (!empty($result->description)) { ?>

                        <img src="<?php echo $Main->SetIcon('image/default/status/' . $result->call_activity_priority_id . '.png', 'default/files/default.png'); ?>" alt="<?php echo $result->name ?>" width="25px">

                        <span class="badge bg-<?php echo $Main->SetClass($result->call_activity_priority_id); ?>">

                            <?php echo $result->description ?>: <?php echo $result->total_priorities ?>

                        </span>

                    <?php } ?>


                <?php } ?>

            </div>

        </div>

    </div>

    <div class="card-footer bg-transparent p-0 border-0">

        <nav class="navbar navbar-expand-lg bg-transparent rounded py-2">

            <div class="container-fluid">

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCall<?php echo $CallsGetResult->call_id?>" aria-controls="navbarCall<?php echo $CallsGetResult->call_id?>" aria-expanded="false" aria-label="Toggle navigation">

                    <span class="navbar-toggler-icon"></span>

                </button>

                <div class="collapse navbar-collapse" id="navbarCall<?php echo $CallsGetResult->call_id?>">

                    <ul class="navbar-nav me-auto mb-lg-0">

                        <li class="nav-item">

                            <a class="nav-link cursor-pointer" onclick="SendRequest('FOLDER=VIEW&TABLE=CALLS_ACTIVITIES&ACTION=CALLS_ACTIVITIES_DATAGRID&CALL_ID=<?php echo $CallsGetResult->call_id?>', {target : 'CallsDetailsWrapper', loader : {create: true, padding: '0px', type: 2, target : 'CallsDetailsWrapper', data : 'Aguarde...'}});">

                                <i class="bi bi-kanban me-1"></i>Quadro

                            </a>

                        </li>

                        <li class="nav-item">

                            <a class="nav-link cursor-pointer" onclick="SendRequest('FOLDER=VIEW&TABLE=CALLS_ACTIVITIES&ACTION=CALLS_ACTIVITIES_LIST&CALL_ID=<?php echo $CallsGetResult->call_id?>', {target : 'CallsDetailsWrapper', loader : {create: true, padding: '0px', type: 2, target : 'CallsDetailsWrapper', data : 'Aguarde...'}});">

                                <i class="bi bi-list-ol me-1"></i>Lista

                            </a>

                        </li>

                        <li class="nav-item">

                            <a class="nav-link cursor-pointer" onclick="SendRequest('FOLDER=VIEW&TABLE=CALLS_FILES&ACTION=CALLS_FILES_DATAGRID&CALL_ID=<?php echo $CallsGetResult->call_id?>', {target : 'CallsDetailsWrapper', loader : {create: true, padding: '0px', type: 2, target : 'CallsDetailsWrapper', data : 'Aguarde...'}});">

                                <i class="bi bi-file-earmark me-1"></i>Arquivos

                            </a>

                        </li>

                        <li class="nav-item">

                            <a class="nav-link" onclick="SendRequest('FOLDER=VIEW&TABLE=CALLS_ACTIVITIES&ACTION=CALLS_ACTIVITIES_CALENDAR&CALL_ID=<?php echo $CallsGetResult->call_id?>', {target : 'CallsDetailsWrapper', loader : {create: true, padding: '0px', type: 2, target : 'CallsDetailsWrapper', data : 'Aguarde...'}});">

                                <i class="bi bi-calendar-check me-1"></i>Calendário

                            </a>

                        </li>

                        <li class="nav-item">

                            <a class="nav-link cursor-pointer" onclick="SendRequest('FOLDER=VIEW&TABLE=CALLS&ACTION=CALLS_MESSAGES&TABLE_LOG=CALLS&REGISTER_ID=<?php echo @(int)$CallsGetResult->call_id ?>', {target : 'CallsDetailsWrapper', loader : {create: true, padding: '0px', type: 2, target : 'CallsDetailsWrapper', data : 'Aguarde...'}});">

                                <i class="bi bi-chat me-1"></i>Mensagens

                            </a>

                        </li>

                    </ul>

                </div>

            </div>

        </nav>

    </div>

</div>

<?php }else{ ?>

    <div class="card">

        <div class="card-body text-center">

            <h1 class="card-title text-center">

                <span class="badge rounded-pill text-bg-primary">

                    C-2

                </span>

            </h1>

            <h4 class="card-subtitle text-center text-muted">

                Não foi informado um registros para consulta

            </h4>

        </div>

    </div>

<?php } ?>
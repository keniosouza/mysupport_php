<?php

/** Importação de classes */
use \vendor\model\Users;
use \vendor\model\Calls;
use \vendor\model\CallsActivities;
use \vendor\model\Files;

/** Instânciamento de classes */
$Users = new Users();
$Calls = new Calls();
$CallsActivities = new CallsActivities();
$Files = new Files();

/** Busco os registros desejados */
$CallsGetResult = $Calls->Get((int)filter_input(INPUT_POST, 'CALL_ID', FILTER_SANITIZE_SPECIAL_CHARS));
$FilesAllResult = $Files->All($CallsGetResult->call_id, 'calls');
$UsersAllCallsActivitiesResult = $Users->AllCallsActivities($CallsGetResult->call_id);

/** Parametros de entrada */
$LogsValidate->setTable('CALLS');
$LogsValidate->setRegisterId(@(int)filter_input(INPUT_POST, 'CALL_ID', FILTER_SANITIZE_SPECIAL_CHARS));

/** Realizo a busca do histórico */
$LogsAllByGroupResult = $Logs->AllByHash(md5(strtolower($LogsValidate->getTable()) . $LogsValidate->getRegisterId()));

?>

<div class="p-3">

    <div class="row g-3 animate slideIn">

        <?php

        /** Verifico se devo exibir o registro */
        if (count($UsersAllCallsActivitiesResult) > 0){?>

            <div class="col-md-12">

                <h6>

                    <i class="bi bi-people me-1"></i>Operadores:

                </h6>

                <div class="avatar-group avatar-group-dense">

                    <?php

                    /** Controle de exibição de usuários */
                    $i = 0;

                    /** Consulta os usuário cadastrados*/
                    foreach ($UsersAllCallsActivitiesResult as $keyResultCallsActivityUsers => $resultCallsActivityUsers) {?>

                        <?php

                        /** Verifico se a permissão */
                        if ($keyResultCallsActivityUsers <= 4) {

                            /** Incremento de variavel */
                            $i++;

                            ?>

                            <div class="avatar avatar-2xl border border-3 border-200 rounded-circle bg-primary">

                                <img class="rounded-circle" src="<?php echo $Main->SetIcon($resultCallsActivityUsers->profile_photo, 'default/user.png'); ?>" alt="<?php echo $Main->decryptData(@(string)$resultCallsActivityUsers->name_first); ?>">

                            </div>

                        <?php } ?>

                    <?php }?>

                    <?php

                    /** Verifico se a permissão */
                    if ($i < count($CallsActivitiesUsersResult)) {?>

                        <div class="avatar avatar-2xl border rounded-circle bg-primary">

                            <div class="avatar-name rounded-circle ">

                        <span>

                            +<?php echo count($CallsActivitiesUsersResult) - $i?>

                        </span>

                            </div>

                        </div>

                    <?php } ?>

                </div>

            </div>

        <?php }?>

        <?php

        /** Verifico se devo exibir o registro */
        if (count($FilesAllResult) > 0){?>

            <div class="col-md-12">

                <h6>

                    <i class="bi bi-archive me-1"></i>Arquivos:

                </h6>

                <div class="row g-1">

                    <?php

                    /** Listo todos os registros de produtos */
                    foreach ($FilesAllResult as $key => $result) {

                        /** Obtenho a extensão do arquivo */
                        $result->icon = 'image/default/files/' . pathinfo($result->name, PATHINFO_EXTENSION) . '.png';

                        /** Verifico se o icone existe */
                        $result->icon = file_exists($result->icon) ? $result->icon : 'image/default/files/default.png';

                        /** Crio o nome da função */
                        $result->delete = 'function_delete_products_versions_releases_files_' . md5(microtime());

                        ?>

                        <div class="col-md d-flex">

                            <div class="card text-black w-100">

                                <div class="card-body">

                                    <h6 class="card-title">

                                        <?php echo $result->name?>

                                    </h6>

                                    <div class="d-flex align-items-center">

                                        <div class="flex-shrink-0">

                                            <img src="<?php echo $result->icon ?>" alt="<?php echo $result->name ?>" width="50px">

                                        </div>

                                        <div class="flex-grow-1 ms-3 text-break">

                                            <div class="btn-group w-100 text-break ">

                                                <a class="btn btn-primary" href="<?php echo @(string)$result->path ?>/<?php echo @(string)$result->name ?>" download="<?php echo @(string)$result->name ?>" target="_blank">

                                                    <i class="bi bi-cloud-arrow-down-fill me-1"></i>Download

                                                </a>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    <?php }?>

                </div>

            </div>

        <?php }?>

        <?php

        /** Verifico se devo exibir o registro */
        if (count($LogsAllByGroupResult) > 0){?>

            <div class="col-md-12">

                <h6>

                    <i class="bi bi-clock-history me-1"></i>Histórico:

                </h6>

                <div class="card">

                    <div class="card-body">

                        <div class="timeline block">

                            <?php

                            /** Listo os acessos realizados */
                            foreach ($LogsAllByGroupResult as $key => $result) {

                                /** Decodifico os dados do histórico */
                                $result->data = (object)json_decode($result->data);

                                /** Verifico se devo exibir a mensagem */
                                if (!empty($result->data->TITLE)){?>

                                    <div class="tl-item <?php echo $key === 0 ? 'active' : null ?>">

                                        <div class="tl-dot b-<?php echo $result->data->CLASS?>"></div>

                                        <div class="tl-content">

                                            <div class="">

                                                <b>

                                                    <?php echo $Main->decryptData($result->name_first)?> <?php echo $Main->decryptData($result->name_last)?>:

                                                </b>

                                                -

                                                <span class="badge bg-<?php echo $result->data->CLASS?>">

                                                    <?php echo $result->data->TITLE?>

                                                </span>

                                                - <?php echo $result->data->MESSAGE?>

                                            </div>

                                            <div class="tl-date text-muted mt-1">

                                                <?php echo date('d/m/Y H:i:s', strtotime($result->date_register)) ?>

                                            </div>

                                        </div>

                                    </div>

                                <?php } ?>

                            <?php } ?>

                        </div>

                    </div>

                </div>

            </div>

        <?php }?>

    </div>

</div>
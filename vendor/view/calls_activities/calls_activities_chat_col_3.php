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

/** Busco a ATIVIDADE desejada */
$CallsActivitiesGetResult = $CallsActivities->Get((int)filter_input(INPUT_POST, 'CALL_ACTIVITY_ID', FILTER_SANITIZE_SPECIAL_CHARS));

/** Busco os arquivos vinculados ao CHAMADO que a ATIVIDADE esta vinculada */
$FilesAllResult = $Files->All($CallsActivitiesGetResult->call_id, 'calls');

/** Busco os OPERADORES participantes do CHAMADO */
$UsersAllCallsActivitiesResult = $Users->AllCallsActivities($CallsActivitiesGetResult->call_id);

/** Parametros de entrada */
$LogsValidate->setTable('CALLS');
$LogsValidate->setRegisterId($CallsActivitiesGetResult->call_id);

/** Realizo a busca do histórico */
$LogsAllByGroupResult = $Logs->AllByHash(md5(strtolower($LogsValidate->getTable()) . $LogsValidate->getRegisterId()));

?>

<div class="p-3">

    <div class="row g-3 animate slideIn">

        <div class="col-md-12 text-center">

            Detalhes do chamado:

            <h5>

                #<?php echo $CallsActivitiesGetResult->call_id?> - <?php echo $CallsActivitiesGetResult->call_name?>

            </h5>

        </div>

        <?php

        /** Verifico se devo exibir o registro */
        if (count($UsersAllCallsActivitiesResult) > 0){?>

            <div class="col-md-12">

                <h6>

                    <i class="bi bi-people me-1"></i>Operadores:

                </h6>

                <div class="avatar-group avatar-group-dense">

                    <?php

                    /** Consulta os usuário cadastrados*/
                    foreach ($UsersAllCallsActivitiesResult as $keyResultCallsActivityUsers => $resultCallsActivityUsers) {?>

                        <div class="avatar avatar-2xl border border-3 border-200 rounded-circle bg-primary">

                            <img class="rounded-circle" src="<?php echo $Main->SetIcon($resultCallsActivityUsers->profile_photo, 'default/user.png'); ?>" alt="<?php echo $Main->decryptData(@(string)$resultCallsActivityUsers->name_first); ?>">

                        </div>

                    <?php }?>

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
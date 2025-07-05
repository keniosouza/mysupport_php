<?php

/** Importação de classes */
use \vendor\model\Files;
use \vendor\model\CallsActivities;
use \vendor\controller\calls_activities\CallsActivitiesValidate;

/** Instânciamento de classes */
$Files = new Files();
$CallsActivities = new CallsActivities();
$CallsActivitiesValidate = new CallsActivitiesValidate();

/** Tratamento dos dados de entrada */
$CallsActivitiesValidate->setCallActivityId(@(int)filter_input(INPUT_POST, 'CALL_ACTIVITY_ID', FILTER_SANITIZE_SPECIAL_CHARS));

/** Busco o registro desejado */
$CallsActivitiesGetResult = $CallsActivities->Get($CallsActivitiesValidate->getCallActivityId());

/** Busco as imagens vinculadas */
$resultFiles = $Files->All($CallsActivitiesGetResult->call_activity_id, 'calls_activities');?>

<?php

/** Verifico se existem registros */
if (@(int)count($resultFiles) > 0) { ?>

    <div class="row g-1 animate slideIn">

        <?php

        /** Consulta os usuário cadastrados*/
        foreach ($resultFiles as $keyResultCallsDrafts => $result) {

            /** Obtenho a extensão do arquivo */
            $result->icon = 'image/default/files/' . pathinfo($result->name, PATHINFO_EXTENSION) . '.png';

            /** Verifico se o icone existe */
            $result->icon = file_exists($result->icon) ? $result->icon : 'image/default/files/default.png';

            /** Crio o nome da função */
            $result->delete = 'function_delete_' . md5(microtime());

            ?>

            <div class="col-md-4 d-flex">

                <div class="card w-100">

                    <div class="card-body">

                        <div class="d-flex mb-2">

                            <div class="flex-shrink-0">

                                <img src="<?php echo $Main->SetIcon($result->icon, 'default/files/default.png'); ?>" class="img-fluid" width="25px">

                            </div>

                            <div class="flex-grow-1 ms-2">

                                <h6 class="text-muted mb-0">

                                    <?php echo $result->name; ?>

                                </h6>

                                <div class="btn-group btn-group-sm w-100 mt-1">

                                    <a class="btn btn-primary" type="button" href="<?php echo @(string)$result->path ?><?php echo @(string)$result->name ?>" download="<?php echo @(string)$result->name ?>">

                                        <i class="bi bi-download"></i>

                                    </a>

                                    <?php

                                    /** Verifico se a permissão */
                                    if (@(string)$resultUserAcl->chamado->vincular_documento === 'true') { ?>

                                        <a class="btn btn-primary" onclick="modalConstruct(true, 'Deseja remover o arquivo?', '', 'md', null, null, 'question', <?php echo @(string)$result->delete ?>, null, null)">

                                            <i class="bi bi-fire"></i>

                                        </a>

                                        <script type="text/javascript">

                                            /** Carrega a função de logout */
                                            var <?php echo @(string)$result->delete?> = "SendRequest('FOLDER=ACTION&TABLE=CALLS_FILES&ACTION=CALLS_FILES_DELETE&FILE_ID=<?php echo @(int)$result->file_id?>&CALL_ID=<?php echo @(int)$callId ?>', {target : null, block : {create : true, info : null, sec : null, target : null, data : 'Aguarde', color : 'blue', type : 'circle', size : 'sm', message : true}});";

                                        </script>

                                    <?php } ?>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        <?php } ?>

    </div>

<?php } else { ?>

    <div class="card animate slideIn">

        <div class="card-body text-center">

            <h1 class="card-title text-center">

                <span class="badge rounded-pill text-bg-primary">

                    CF-1

                </span>

            </h1>

            <h4 class="card-subtitle text-center text-muted">

                Não há arquivos vinculados

            </h4>

        </div>

    </div>

<?php } ?>
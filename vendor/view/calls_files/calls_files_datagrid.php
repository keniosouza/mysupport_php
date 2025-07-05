<?php

/** Importação de classes */
use \vendor\model\Files;
use \vendor\model\Calls;
use \vendor\controller\calls\CallsValidate;

/** Instânciamento de classes */
$Files = new Files();
$Calls = new Calls();
$CallsValidate = new CallsValidate();

/** Tratamento dos dados de entrada */
$CallsValidate->setCallId(@(int)filter_input(INPUT_POST, 'CALL_ID', FILTER_SANITIZE_SPECIAL_CHARS));

/** Busco o registro desejado */
$CallsGetResult = $Calls->Get($CallsValidate->getCallId());

/** Busco as imagens vinculadas */
$resultFiles = $Files->All($CallsValidate->getCallId(), 'calls');

?>

<?php

/** Verifico se a permissão */
if (@(string)$resultUserAcl->chamado->vincular_documento === 'true') { ?>

    <?php

    /** Verifico o status do registro */
    if (empty(@(string)$CallsGetResult->date_close)) { ?>

        <button class="btn btn-primary btn-sm w-100 mb-2" onclick="SendRequest('FOLDER=VIEW&TABLE=CALLS_FILES&ACTION=CALLS_FILES_FORM&CALL_ID=<?php echo @(int)$CallsGetResult->call_id ?>', {target : null, block : {create : true, info : null, sec : null, target : null, data : 'Aguarde', color : 'blue', type : 'circle', size : 'sm', message : true}});">

            <i class="bi bi-plus me-1"></i>Novo
        </button>

    <?php } ?>

<?php } ?>

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

                <div class="card text-black shadow-sm w-100">

                    <div class="card-body">

                        <div class="d-flex align-items-center">

                            <div class="flex-shrink-0">

                                <img src="<?php echo $result->icon ?>" alt="<?php echo $result->name ?>" width="50px">

                            </div>

                            <div class="flex-grow-1 ms-3 text-break">

                                <h6 class="card-title">

                                    <?php echo $result->name?>

                                </h6>

                            </div>

                        </div>

                    </div>

                    <div class="card-footer bg-transparent border-0">

                        <div class="btn-group w-100 text-break">

                            <a class="btn btn-primary" type="button" href="<?php echo @(string)$result->path ?><?php echo @(string)$result->name ?>" download="<?php echo @(string)$result->name ?>">

                                <i class="bi bi-download me-1"></i>Download

                            </a>

                            <?php

                            /** Verifico se a permissão */
                            if (@(string)$resultUserAcl->chamado->vincular_documento === 'true') { ?>

                                <a class="btn btn-primary" onclick="modalConstruct(true, 'Deseja remover o arquivo?', '', 'md', null, null, 'question', <?php echo @(string)$result->delete ?>, null, null)">

                                    <i class="bi bi-fire me-1"></i>Remover

                                </a>

                                <script type="text/javascript">

                                    /** Carrega a função de logout */
                                    var <?php echo @(string)$result->delete?> = "SendRequest('FOLDER=ACTION&TABLE=CALLS_FILES&ACTION=CALLS_FILES_DELETE&FILE_ID=<?php echo @(int)$result->file_id?>&CALL_ID=<?php echo @(int)$CallsGetResult->call_id ?>', {target : null, block : {create : true, info : null, sec : null, target : null, data : 'Aguarde', color : 'blue', type : 'circle', size : 'sm', message : true}});";

                                </script>

                            <?php } ?>

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
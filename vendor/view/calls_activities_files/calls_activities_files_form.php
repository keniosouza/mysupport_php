<?php

/** Importação de classes */
use \vendor\model\CallsActivities;
use \vendor\controller\calls_activities\CallsActivitiesValidate;

/** Instânciamento de classes */
$CallsActivities = new CallsActivities();
$CallsActivitiesValidate = new CallsActivitiesValidate();

/** Tratamento dos dados de entrada */
$CallsActivitiesValidate->setCallActivityId(@(int)filter_input(INPUT_POST, 'CALL_ACTIVITY_ID', FILTER_SANITIZE_SPECIAL_CHARS));

/** Busco o registro desejado */
$CallsActivitiesGetResult = $CallsActivities->Get($CallsActivitiesValidate->getCallActivityId());

/** Validação da informação */
if ($CallsActivitiesGetResult->call_activity_id === 0){?>

    <div class="card animate slideIn">

        <div class="card-body text-center">

            <h1 class="card-title text-center">

                <span class="badge rounded-pill text-bg-primary">

                    CF-1

                </span>

            </h1>

            <h4 class="card-subtitle text-center text-muted">

                Não há o chamado para vincular as imagens

            </h4>

        </div>

    </div>

<?php }else{?>

    <!-- Espaço reservado para construção do formulário de arquivo -->
    <div id="CallsActivitiesFilesFormWrapper">

        <script type="text/javascript">

            <?php

            /** Defino a opções de exibição do form */
            $options = new stdClass();
            /** Defino para aceitar apenas imagens */
            $options->accept = null;
            /** Defino para selecionar apenas um arquivo */
            $options->multiple = true;
            /** defino o tipo de exbição que deve ser feito: 1 - List, 2 - Recorte */
            $options->preview = 1;
            /** defino o tipo de exbição que deve ser feito: 1 - List, 2 - Recorte */
            $options->phrase = 'Solte seus arquivos aqui';

            ?>

            /** Envio de Requisição */
            SendRequest('FOLDER=VIEW&TABLE=FILES&ACTION=FILES_FORM&OPTIONS=<?php echo json_encode($options)?>', {target : 'CallsActivitiesFilesFormWrapper', block : {create : true, info : null, sec : null, target : 'CallsActivitiesFilesFormWrapper', data : 'Aguarde', color : 'blue', type : 'circle', size : 'sm', message : true}});

        </script>

    </div>

    <form id="FilesFormHeader">

        <input type="hidden" name="call_activity_id" value="<?php echo @(string)$CallsActivitiesGetResult->call_activity_id ?>"/>
        <input type="hidden" name="FOLDER" value="ACTION"/>
        <input type="hidden" name="TABLE" value="CALLS_ACTIVITIES_FILES"/>
        <input type="hidden" name="ACTION" value="CALLS_ACTIVITIES_FILES_SAVE"/>

    </form>

<?php }?>
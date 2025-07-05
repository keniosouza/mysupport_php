<?php

/** Importação de classes */
use \vendor\model\CallsActivitiesUsers;
use \vendor\controller\calls_activities_users\CallsActivitiesUsersValidate;

/** Instânciamento de classes */
$CallsActivitiesUsers = new CallsActivitiesUsers();
$CallsActivitiesUsersValidate = new CallsActivitiesUsersValidate();

/** Tratamento dos dados de entrada */
$CallsActivitiesUsersValidate->setCallActivityUserId(@(int)filter_input(INPUT_POST, 'CALL_ACTIVITY_USER_ID', FILTER_SANITIZE_SPECIAL_CHARS));

/** Busco o registro desejado */
$CallsActivitiesUsersGetResult = $CallsActivitiesUsers->Get($CallsActivitiesUsersValidate->getCallActivityUserId());

/** Validação da informação */
if ($CallsActivitiesUsersGetResult->call_activity_user_id === 0){?>

    <div class="card animate slideIn">

        <div class="card-body text-center">

            <h1 class="card-title text-center">

                <span class="badge rounded-pill text-bg-primary">

                    CAUF-1

                </span>

            </h1>

            <h4 class="card-subtitle text-center text-muted">

                Não há operador para vincular os arquivos

            </h4>

        </div>

    </div>

<?php }else{?>

    <!-- Espaço reservado para construção do formulário de arquivo -->
    <div id="CallsActivitiesUsersFilesFormWrapper">

        <script type="text/javascript">

            <?php

            /** Defino a opções de exibição do form */
            $options = new stdClass();
            /** Defino para aceitar apenas imagens */
            $options->accept = null;
            /** Defino para selecionar apenas um arquivo */
            $options->multiple = true;

            ?>

            /** Envio de Requisição */
            SendRequest('FOLDER=VIEW&TABLE=FILES&ACTION=FILES_FORM&OPTIONS=<?php echo json_encode($options)?>', {target : 'CallsActivitiesUsersFilesFormWrapper', block : {create : true, info : null, sec : null, target : 'CallsActivitiesUsersFilesFormWrapper', data : 'Aguarde', color : 'blue', type : 'circle', size : 'sm', message : true}});

        </script>

    </div>

    <form id="FilesFormHeader">

        <input type="hidden" name="FOLDER" value="ACTION"/>
        <input type="hidden" name="TABLE" value="CALLS_ACTIVITIES_USERS_FILES"/>
        <input type="hidden" name="ACTION" value="CALLS_ACTIVITIES_USERS_FILES_SAVE"/>
        <input type="hidden" name="call_activity_user_id" value="<?php echo @(string)$CallsActivitiesUsersGetResult->call_activity_user_id ?>"/>

    </form>

<?php }?>
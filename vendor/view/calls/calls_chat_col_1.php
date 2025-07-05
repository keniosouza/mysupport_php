<?php

/** Importação de classes */
use \vendor\model\CallsActivitiesUsers;
use \vendor\model\CallsMessages;

/** Instânciamento de classes */
$CallsActivitiesUsers = new CallsActivitiesUsers();
$CallsMessages = new CallsMessages();

/** Busco os registros desejados */
$CallsActivitiesUsersAllCallsByCallsActivitiesUsersResult = $CallsActivitiesUsers->AllCallsByCallsActivitiesUsers((int)$_SESSION['USERSID']);

?>

<?php

/** Verifico se existem registros a serem exibidos */
if (count($CallsActivitiesUsersAllCallsByCallsActivitiesUsersResult) > 0){ ?>

    <?php

    /** Consulta os usuário cadastrados*/
    foreach ($CallsActivitiesUsersAllCallsByCallsActivitiesUsersResult as $key => $result) {

        /** Obtenho a última mensagem enviada no chamado */
        $CallsMessagesGetLastResult = $CallsMessages->GetLast($result->call_id);

        ?>

        <div id="CallId<?php echo $result->call_id?>" class="px-2 py-3 animate chat-item" onclick="SendRequest('FOLDER=VIEW&TABLE=CALLS_ACTIVITIES&ACTION=CALLS_ACTIVITIES_CHAT_COL_2&CALL_ID=<?php echo $result->call_id?>', {target : 'CallsActivitiesChatMessages', block : {create : true, info : null, sec : null, target : 'CallsActivitiesChatMessages', data : 'Aguarde', color : 'blue', type : 'circle', size : 'sm', message : true}})">

            <h6 class="mb-1 text-truncate">

                #<?php echo $result->call_id?>

                -

                <?php echo $result->call_name?>

            </h6>

            <p class="text-truncate fs-6 mb-0">

                <?php

                /** Verifico se foi localizado a última mensagem */
                if ($CallsMessagesGetLastResult->call_mesage_id > 0)
                {

                    /** Exibição da mensagem */
                    echo $Main->decryptData($CallsMessagesGetLastResult->name_first) . ': ' . substr(trim(strip_tags($CallsMessagesGetLastResult->text)), 0, 100);

                }

                ?>

            </p>

        </div>

    <?php }?>

<?php }else{?>

    <div class="card">

        <div class="card-body text-center">

            <h1 class="card-title text-center">

                <span class="badge rounded-pill text-bg-primary">

                    CA-1

                </span>

            </h1>

            <h4 class="card-subtitle text-center text-muted">

                Não há atividades em progresso

            </h4>

        </div>

    </div>

<?php } ?>
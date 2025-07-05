<?php

/** Importação de classes */
use \vendor\model\CallsActivities;
use \vendor\model\Users;
use \vendor\model\Messages;
use \vendor\controller\messages\MessagesValidate;

/** Instânciamento de classes */
$CallsActivities = new CallsActivities();
$Users = new Users();
$Messages = new Messages();
$MessagesValidate = new MessagesValidate();

/** Parâmetros de entrada */
$MessagesValidate->setRegisterId((int)filter_input(INPUT_POST, 'CALL_ACTIVITY_ID', FILTER_SANITIZE_SPECIAL_CHARS));

/** Busco todos os participantes do chamado */
$CallsActivitiesUsersResult = $Users->AllCallsActivities($MessagesValidate->getRegisterId());

/** Busco todas as mensagens desejads */
$MessagesAllResult = $Messages->All('calls_activities', $MessagesValidate->getRegisterId());

/** Busco o registro do chamado */
$CallsActivitiesGetResult = $CallsActivities->Get($MessagesValidate->getRegisterId());

?>

<?php

/** Verifico se existem registros a serem exibidos */
if (count($MessagesAllResult) > 0){ ?>

    <div class="p-3 shadow-sm border-bottom mb-3 bg-glass sticky-top">

        Atividade:
        <h5 class="mb-0">

            #<?php echo $CallsActivitiesGetResult->call_activity_id ?> - <?php echo $CallsActivitiesGetResult->name?>

        </h5>

    </div>

    <?php

    /** Consulta os usuário cadastrados*/
    foreach ($MessagesAllResult as $key => $result) {?>

        <div class="chat-msg <?php echo @(int)$result->user_id === @(int)$_SESSION['USERSID'] ? 'owner' : null ?> animate slideIn">

            <div class="chat-msg-profile">

                <img class="chat-msg-img" src="<?php echo $Main->SetIcon($result->profile_photo, 'default/user.png'); ?>" alt="">

                <div class="chat-msg-date">

                    <?php echo $Main->decryptData($result->name_first) ?>: <?php echo date('d/m/Y H:i:s', strtotime($result->date_register)) ?>

                </div>

            </div>

            <div class="chat-msg-content">

                <div class="chat-msg-text">

                    <?php echo $result->data ?>

                </div>

            </div>

        </div>

    <?php }?>

    <script type="text/javascript">

        /** Executo a função quando a página for carregada */
        RemoveAndAddClass('CallActivityId<?php echo $CallsActivitiesGetResult->call_activity_id?>');

        function RemoveAndAddClass(target) {

            /** Obtenho a div que possui os itens */
            var wrapper = document.getElementById("CallsActivitiesChatList");

            /** Busco os itens existentes dentro do objeto encapsulador */
            var itens = wrapper.getElementsByClassName("chat-item-active");

            /** Percorro todos o itens localizados */
            for (var i = 0; i < itens.length; i++) {

                /** Removo a classe desejada */
                itens[i].classList.remove("chat-item-active");

            }

            /** Obtenho o item desejado */
            var item = document.getElementById(target);

            /** Adiciono a classe desejada */
            item.classList.toggle("chat-item-active");

        }

        /** Envio o Scrool para o final */
        ScrollToBottom("CallsActivitiesChatMessages");

        /** Envio de Requisição */
        SendRequest('FOLDER=VIEW&TABLE=CALLS_ACTIVITIES&ACTION=CALLS_ACTIVITIES_CHAT_COL_3&CALL_ACTIVITY_ID=<?php echo $MessagesValidate->getRegisterId()?>', {target : 'CallsActivitiesChatDetails', block : {create : true, info : null, sec : null, target : 'CallsActivitiesChatDetails', data : 'Aguarde', color : 'blue', type : 'circle', size : 'sm', message : true}});

    </script>

<?php }else{?>

    <div class="py-5">

        <h1 class="card-title text-center">

            <span class="badge rounded-pill text-bg-primary">

                CA-1

            </span>

        </h1>

        <h4 class="card-subtitle text-center text-muted">

            Selecione um chamado para visualizar os feedbacks

        </h4>

    </div>

<?php } ?>
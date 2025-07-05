<?php

/** Importação de classes */
use \vendor\model\Calls;
use \vendor\model\Users;
use \vendor\model\CallsMessages;
use \vendor\controller\calls_messages\CallsMessagesValidate;

/** Instânciamento de classes */
$Calls = new Calls();
$Users = new Users();
$CallsMessages = new CallsMessages();
$CallsMessagesValidate = new CallsMessagesValidate();

/** Parâmetros de entrada */
$CallsMessagesValidate->setCallId((int)filter_input(INPUT_POST, 'CALL_ID', FILTER_SANITIZE_SPECIAL_CHARS));

/** Busco todos os participantes do chamado */
$CallsActivitiesUsersResult = $Users->AllCallsActivities($CallsMessagesValidate->getCallId());

/** Busco todas as mensagens desejads */
$CallsMessagesAllResult = $CallsMessages->All(0, $CallsMessagesValidate->getCallId(), $_SESSION['USERSCOMPANYID']);

/** Busco o registro do chamado */
$CallsGetResult = $Calls->Get((int)filter_input(INPUT_POST, 'CALL_ID', FILTER_SANITIZE_SPECIAL_CHARS));

?>

<?php

/** Verifico se existem registros a serem exibidos */
if (count($CallsMessagesAllResult) > 0){ ?>

    <div class="p-4 shadow-sm border-bottom mb-3 bg-glass sticky-top">

        <div class="row">

            <div class="col-md-12 text-start">

                <h5 class="mb-0">

                    #<?php echo $CallsGetResult->call_id ?> - <?php echo $CallsGetResult->name?>

                </h5>

            </div>

        </div>

    </div>

    <?php

    /** Consulta os usuário cadastrados*/
    foreach ($CallsMessagesAllResult as $key => $result) {?>

        <div class="chat-msg <?php echo @(int)$result->user_id === @(int)$_SESSION['USERSID'] ? 'owner' : null ?>">

            <div class="chat-msg-profile">

                <img class="chat-msg-img" src="<?php echo $Main->SetIcon($result->profile_photo, 'default/user.png'); ?>" alt="">

                <div class="chat-msg-date">

                    <?php echo $Main->decryptData($result->name_first) ?>: <?php echo date('d/m/Y H:i:s', strtotime($result->date)) ?>

                </div>

            </div>

            <div class="chat-msg-content">

                <div class="chat-msg-text">

                    <?php echo $result->text ?>

                </div>

            </div>

        </div>

    <?php }?>

    <script type="text/javascript">

        /** Executo a função quando a página for carregada */
        RemoveAndAddClass('CallId<?php echo $CallsGetResult->call_id?>');

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

        // Função para fazer scroll até o final da div
        function ScrollToBottom() {

            var div = document.getElementById("CallsActivitiesChatMessages");
            div.scrollTop = div.scrollHeight;

        }

        ScrollToBottom();

        /** Envio de Requisição */
        SendRequest('FOLDER=VIEW&TABLE=CALLS_ACTIVITIES&ACTION=CALLS_ACTIVITIES_CHAT_COL_3&CALL_ID=<?php echo $CallsMessagesValidate->getCallId()?>', {target : 'CallsActivitiesChatDetails', block : {create : true, info : null, sec : null, target : 'CallsActivitiesChatDetails', data : 'Aguarde', color : 'blue', type : 'circle', size : 'sm', message : true}});

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
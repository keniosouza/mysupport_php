<?php

/** Importação de classes */
use \vendor\model\Notifications;
use \vendor\model\CallsActivities;
use \vendor\model\Messages;

/** Instânciamento de classes */
$Notifications = new Notifications();
$CallsActivities = new CallsActivities();
$Messages = new Messages();

/** Busco os registros desejados */
$NotificationsAllByUserIdResult = $Notifications->AllGroupedByUserId((int)$_POST['USER_ID'] > 0 ? (int)$_POST['USER_ID'] : (int)$_SESSION['USERSID']);

/** Verifico se existem registros a serem exibidos */
if (count($NotificationsAllByUserIdResult) > 0){ ?>

    <div class="p-3 shadow-sm border-bottom bg-glass sticky-top">

        <div class="btn-group btn-sm w-100" role="group" aria-label="Basic example">

            <button type="button" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Todas" onclick="filtrarDivs(0);">

                <i class="bi bi-filter me-1"></i>

            </button>

            <button type="button" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Nâo Lidas" onclick="filtrarDivs(2);">

                <i class="bi bi-filter-circle-fill me-1"></i>

            </button>

            <button type="button" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Lidas" onclick="filtrarDivs(3);">

                <i class="bi bi-filter-circle me-1"></i>

            </button>

        </div>

    </div>

    <?php

    /** Consulta os usuário cadastrados*/
    foreach ($NotificationsAllByUserIdResult as $key => $result) {

        /** Decodifico os daods */
        $NotificationsGetLastByTableAndRegisterIdResult = $Notifications->GetLastByTableAndRegisterId((string)$result->table, (int)$result->register_id, (int)$result->destiny_user_id);

        /** Decodifico os dados da Notificação */
        $NotificationsGetLastByTableAndRegisterIdResult->data = (object)json_decode($NotificationsGetLastByTableAndRegisterIdResult->data);

        /** Obtenho o registro da notificação */
        $CallsActivitiesGetResult = $CallsActivities->Get((int)$result->register_id);

        /** Busco a última mensagem enviada */
        $MessagesGetLastResult = $Messages->GetLast('calls_activities', (int)$result->register_id);

        /** Verifico o status do registro */
        if ($CallsActivitiesGetResult->call_activity_id > 0) { ?>

            <div id="NotificationId<?php echo $result->register_id?>" class="px-2 py-3 chat-item visible-<?php echo (int)$NotificationsGetLastByTableAndRegisterIdResult->status?>" onclick="BeforeSendRequest<?php echo $result->register_id?>()">

                <h6 class="text-truncate text-black-50 mb-0">

                    <?php echo $CallsActivitiesGetResult->call_name?>

                </h6>

                <h5 class="mb-1 text-truncate d-flex align-items-center">

                    <?php

                    /** Verifico o status do registro */
                    if ((int)$NotificationsGetLastByTableAndRegisterIdResult->status !== 3) { ?>

                        <span id="NotificationStatus<?php echo $NotificationsGetLastByTableAndRegisterIdResult->notification_id; ?>">

                            <img src="image/default/bell.gif" class="me-1" width="25px">

                        </span>

                    <?php } ?>

                    <?php

                    /** Verifico o status do registro */
                    if (empty($CallsActivitiesGetResult->date_close) && ((int)$MessagesGetLastResult->user_id != (int)$_SESSION['USERSID'])) { ?>

                        <img src="image/default/status/1.gif" class="me-1" width="25px" alt="">

                    <?php } ?>

                    <?php

                    /** Verifico o status do registro */
                    if (!(empty($CallsActivitiesGetResult->date_close))) { ?>

                        <img src="image/default/success.png" class="img-fluid me-1" width="20px">

                    <?php } ?>

                    #<?php echo $CallsActivitiesGetResult->call_activity_id?>

                    -

                    <?php echo $CallsActivitiesGetResult->name?>

                </h5>

                <p class="text-truncate fs-6 mb-0">

                    <?php echo $NotificationsGetLastByTableAndRegisterIdResult->data->MESSAGE?>

                </p>

                <small>

                    <?php echo date('d/m/Y H:i:s', strtotime($NotificationsGetLastByTableAndRegisterIdResult->date_register))?>

                </small>

            </div>

            <script type="text/javascript">

                function filtrarDivs(status) {

                    // Selecionar a div específica
                    var divPai = document.getElementById('NotificationsDetailsList'); // Substitua 'id-da-sua-div' pelo ID da sua div

                    // Remover a classe "oculto" apenas dentro dessa div
                    var divsFilhas = divPai.querySelectorAll('.display-none');
                    divsFilhas.forEach(function(divFilha) {
                        divFilha.classList.remove('display-none');
                    });

                    // Se o status for 0, mostrar todas as divs, independente do status
                    if (status === 0) {
                        return;
                    }

                    // Selecionar as divs pai
                    var divsPai = document.querySelectorAll('#NotificationsDetailsList');

                    // Iterar sobre as divs pai
                    divsPai.forEach(function(divPai) {

                        // Selecionar as divs filhas com classes status-2 ou status-3
                        var divsFilhas = divPai.querySelectorAll('.visible-2, .visible-3');

                        // Iterar sobre as divs filhas
                        divsFilhas.forEach(function(divFilha) {

                            // Verificar se a div filha possui a classe desejada
                            if (!divFilha.classList.contains('visible-' + status)) {

                                // Adicionar a classe "oculto" para ocultar a div que não atende ao filtro
                                divFilha.classList.add('display-none');

                            }

                        });

                    });

                }

                /** Procedimentos para serem realizados antes da requisição */
                function BeforeSendRequest<?php echo $result->register_id?>()
                {

                    /** Executo a função quando a página for carregada */
                    RemoveAndAddClass('NotificationId<?php echo $result->register_id?>');

                    function RemoveAndAddClass(target) {

                        /** Obtenho a div que possui os itens */
                        var wrapper = document.getElementById("NotificationsDetailsList");

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

                    <?php

                    /** Verifico o status do registro */
                    if ((int)$NotificationsGetLastByTableAndRegisterIdResult->status !== 3) { ?>

                        /** Atualizo o Status da Notificação */
                        SendRequest('FOLDER=ACTION&TABLE=NOTIFICATIONS&ACTION=NOTIFICATIONS_SAVE_STATUS&NOTIFICATION_ID=<?php echo $NotificationsGetLastByTableAndRegisterIdResult->notification_id ?>&DESTINY_USER_ID=<?php echo $NotificationsGetLastByTableAndRegisterIdResult->destiny_user_id ?>&STATUS=3', {target : null, block : {create : true, info : null, sec : null, target : 'NotificationsDetailsItem', data : 'Aguarde', color : 'blue', type : 'circle', size : 'sm', message : true}});

                        /** Removo o elemento desejado */
                        AddClass('NotificationStatus<?php echo $NotificationsGetLastByTableAndRegisterIdResult->notification_id; ?>', 'display-none');

                    <?php } ?>

                    /** Envio de requisição */
                    SendRequest('FOLDER=VIEW&TABLE=CALLS_ACTIVITIES&ACTION=CALLS_ACTIVITIES_DETAILS&CALL_ACTIVITY_ID=<?php echo $result->register_id?>', {target : 'NotificationsDetailsItem', loader : {create: true, type: 2, padding: '0px', target : 'NotificationsDetailsItem', data : 'Aguarde...'}})

                }

            </script>

        <?php } ?>

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
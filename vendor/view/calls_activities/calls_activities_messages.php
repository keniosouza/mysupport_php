<?php

/** Importação de classes */
use \vendor\model\Files;
use \vendor\model\Messages;
use \vendor\model\CallsActivities;
use \vendor\controller\calls_activities\CallsActivitiesValidate;

/** Instânciamento de classes */
$Files = new Files();
$Messages = new Messages();
$CallsActivities = new CallsActivities();
$CallsActivitiesValidate = new CallsActivitiesValidate();

/** Parâmetros de entrada */
$CallsActivitiesValidate->setCallActivityId((int)filter_input(INPUT_POST, 'CALL_ACTIVITY_ID', FILTER_SANITIZE_SPECIAL_CHARS));

/** Busco todas as mensagens enviadas */
$MessagesAllResult = $Messages->All('calls_activities', $CallsActivitiesValidate->getCallActivityId()); ?>

<?php

/** Verifico se existem mensagens */
if (count($MessagesAllResult) > 0){?>

    <div class="card">

        <div class="card-body">

            <div id="CallsActivitiesChatMessages" class="custom-scrollbar" style="max-height: 350px">

                <div class="timeline block">

                    <?php

                    /** Listo os acessos realizados */
                    foreach ($MessagesAllResult as $key => $result) {?>

                        <div class="tl-item <?php echo (int)$result->user_id === (int)$_SESSION['USERSID'] ? 'active' : null; ?>">

                            <div class="tl-dot b-light"></div>

                            <div class="tl-content">

                                <div class="">

                                    <b>

                                        <?php echo $Main->decryptData($result->name_first)?> <?php echo $Main->decryptData($result->name_last)?>

                                    </b>

                                    comentou:

                                    <div class="card-text p-3 bg-light border-0 rounded">

                                        <?php echo $result->data?>

                                    </div>

                                </div>

                                <div class="tl-date text-muted mt-1">

                                    <?php echo date('d/m/Y H:i:s', strtotime($result->date_register)) ?>

                                </div>

                            </div>

                        </div>

                    <?php } ?>

                </div>

            </div>

        </div>

    </div>

    <script type="text/javascript">

        /** Envio o Scrool para o final */
        ScrollToBottom("CallsActivitiesChatMessages");

    </script>

<?php }?>

<div class="col-md-12">

    <div id="CallsActivitiesMessagesResult"></div>

    <form id="CallsActivitiesMessagesForm" class="form-group mt-2 animate slideIn">

        <div class="input-group mb-3">

            <input type="text" class="form-control" id="data" name="data" placeholder="Escreva um comentário">

            <button class="btn btn-primary" type="button" id="button-addon2" onclick="SendRequest('CallsActivitiesMessagesForm', {target : 'CallsActivitiesMessagesResult', block : {create : true, info : null, sec : null, target : 'CallsActivitiesMessagesResult', data : 'Aguarde...', color : 'blue', type : 'circle', size : 'sm', message : true}});">

                <i class="bi bi-send me-1"></i>Enviar

            </button>

        </div>

        <input type="hidden" name="FOLDER" value="ACTION" />
        <input type="hidden" name="TABLE" value="CALLS_ACTIVITIES_MESSAGES" />
        <input type="hidden" name="ACTION" value="CALLS_ACTIVITIES_MESSAGES_SAVE" />
        <input type="hidden" name="message_table" value="calls_activities" />
        <input type="hidden" name="message_register_id" value="<?php echo $CallsActivitiesValidate->getCallActivityId()?>" />

    </form>

</div>

<?php

/** Importação de classes */
use \vendor\model\Calls;
use \vendor\controller\calls\CallsValidate;

/** Instânciamento de classes */
$Calls = new Calls();
$CallsValidate = new CallsValidate();

/** Tratamento dos dados de entrada */
$CallsValidate->setCallId(@(int)filter_input(INPUT_POST, 'CALL_ID', FILTER_SANITIZE_SPECIAL_CHARS));

/** Busca de registro */
$CallsGetResult = $Calls->Get($CallsValidate->getCallId()); ?>

<div class="border shadow-sm bg-white animate slideIn p-0">

    <div class="row g-0">

        <div class="col-md-12 border-end custom-scrollbar" id="CallsActivitiesChatMessages" style="max-height: 600px">

            <script type="text/javascript">

                /** Envio de Requisição */
                SendRequest('FOLDER=VIEW&TABLE=CALLS&ACTION=CALLS_CHAT_COL_2&CALL_ID=<?php echo $CallsGetResult->call_id?>', {target : 'CallsActivitiesChatMessages', block : {create : true, info : null, sec : null, target : 'CallsActivitiesChatMessages', data : 'Aguarde', color : 'blue', type : 'circle', size : 'sm', message : true}});

            </script>

        </div>

    </div>

</div>
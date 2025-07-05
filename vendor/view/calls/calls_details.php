<?php

/** Importação de classes */
use \vendor\model\Calls;
use \vendor\controller\calls\CallsValidate;

/** Instânciamento de classes */
$Calls = new Calls();
$CallsValidate = new CallsValidate();

/** Tratamento dos dados de entrada */
$CallsValidate->setCallId(@(int)filter_input(INPUT_POST, 'CALL_ID', FILTER_SANITIZE_SPECIAL_CHARS));
$CallsValidate->setCompanyId(@(int)$_SESSION['USERSCOMPANYID']);?>

<div class="col-md-10">

    <h5 class="card-title">

        Chamados / <b> Detalhes </b> /

        <button type="button" class="btn btn-primary btn-sm mb-0" onclick="SendRequest('FOLDER=VIEW&TABLE=CALLS&ACTION=CALLS_DATAGRID', {target : null, loader : {create: true, padding: '0px', type: 2, target : 'wrapper', data : 'Aguarde...'}});">

            <i class="bi bi-arrow-left-short me-1"></i>Voltar

        </button>

    </h5>

</div>

<div class="col-md-2 text-end">

    <button type="button" class="btn btn-primary btn-sm mb-0" onclick="SendRequest('FOLDER=VIEW&TABLE=CALLS&ACTION=CALLS_DETAILS&CALL_ID=<?php echo $CallsValidate->getCallId() ?>', {target : null, loader : {create: true, padding: '0px', type: 2, target : 'wrapper', data : 'Aguarde...'}});">

        <i class="bi bi-arrow-clockwise me-1"></i>Atualizar

    </button>

</div>

<div class="col-md-12">

    <div id="CallsHome">

        <script type="text/javascript">

            /** Envio de Requisição */
            SendRequest('FOLDER=VIEW&TABLE=CALLS&ACTION=CALLS_HOME&CALL_ID=<?php echo $CallsValidate->getCallId()?>', {target : 'CallsHome', loader : {create: true, padding: '0px', type: 2, target : 'CallsHome', data : 'Aguarde...'}});

        </script>

    </div>

    <!--  Espaço reservado para montagem do html da requisições  -->
    <div id="CallsDetailsWrapper">

        <script type="text/javascript">

            /** Envio de Requisição */
            SendRequest('FOLDER=VIEW&TABLE=CALLS_ACTIVITIES&ACTION=CALLS_ACTIVITIES_DATAGRID&CALL_ID=<?php echo $CallsValidate->getCallId()?>', {target : 'CallsDetailsWrapper', loader : {create: true, padding: '0px', type: 2, target : 'CallsDetailsWrapper', data : 'Aguarde...'}});

        </script>

    </div>

</div>
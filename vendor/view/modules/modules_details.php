<?php

/** Importação de classes */
use \vendor\controller\main\Main;
use \vendor\model\Modules;

/** Instânciamento de classes */
$Main = new Main;
$Modules = new Modules();

/** Busco todos os registros */
$ModulesGetResult = $Modules->Get($_POST['MODULES_ID']);

?>

<h5 class="card-title">

    Módulos / <b>Detalhes</b> /

    <button type="button" class="btn btn-primary btn-sm" onclick="SendRequest('FOLDER=VIEW&TABLE=MODULES&ACTION=MODULES_DATAGRID', {target : null, block : {create : true, info : null, sec : null, target : null, data : 'Aguarde', color : 'blue', type : 'circle', size : 'sm', message : true}});">

        <i class="bi bi-arrow-left-short me-1"></i>Voltar

    </button>

</h5>

<div class="card mb-1 animate slideIn">

    <div class="card-body">

        <h5>

            <span class="badge rounded-pill bg-primary mt-2">

                #<?php echo @(int)$ModulesGetResult->modules_id ?>

            </span>

            -

            <?php echo $ModulesGetResult->name; ?> - <?php echo $ModulesGetResult->description; ?>

        </h5>

    </div>

</div>

<div id="ModulesAclDatagridOrForm">

    <script type="text/javascript">

        /** Envio de Requisição */
        SendRequest('FOLDER=VIEW&TABLE=MODULES_ACLS&ACTION=MODULES_ACLS_DATAGRID&MODULES_ID=<?php echo $ModulesGetResult->modules_id ?>', {target : 'ModulesAclDatagridOrForm', block : {create : true, info : null, sec : null, target : 'ModulesAclDatagridOrForm', data : 'Aguarde', color : 'blue', type : 'circle', size : 'sm', message : true}});

    </script>

</div>
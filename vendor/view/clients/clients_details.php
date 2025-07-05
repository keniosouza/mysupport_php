<?php

/** Importação de classes */
use \vendor\controller\main\Main;
use \vendor\model\Clients;
use \vendor\controller\clients\ClientsValidate;
use \vendor\model\ClientsLogs;

/** Instânciamento de classes */
$Main = new Main();
$Clients = new Clients();
$ClientsValidate = new ClientsValidate();
$ClientsLogs = new ClientsLogs();

/** Tratamento dos dados de entrada */
$ClientsValidate->setClientsId(@(int)filter_input(INPUT_POST, 'CLIENT_ID', FILTER_SANITIZE_SPECIAL_CHARS));

/** Verifico se existe registro */
if ($ClientsValidate->getClientsId() > 0) {

    /** Busca de registro */
    $ClientsGetResult = $Clients->Get($ClientsValidate->getClientsId());

    /** Verifico o status do usuário */
    $ClientsGetResult->phrase = $ClientsGetResult->active === 'S' ? 'Ativo' : 'Inativo';
    $ClientsGetResult->class = $ClientsGetResult->active === 'S' ? 'primary' : 'danger';

}

?>

<div class="col-md-10">

    <h5 class="card-title">

        Clientes / <b> Detalhes </b> /

        <button type="button" class="btn btn-primary btn-sm mb-0" onclick="SendRequest('FOLDER=VIEW&TABLE=CLIENTS&ACTION=CLIENTS_DATAGRID', {target : null, block : {create : true, info : null, sec : null, target : null, data : 'Aguarde', color : 'blue', type : 'circle', size : 'sm', message : true}});">

            <i class="bi bi-arrow-left-short me-1"></i>Voltar

        </button>

    </h5>

</div>

<div class="col-md-2 text-end">

    <button type="button" class="btn btn-primary btn-sm mb-0" onclick="SendRequest('FOLDER=VIEW&TABLE=CLIENTS&ACTION=CLIENTS_DETAILS&CLIENT_ID=<?php echo $ClientsGetResult->clients_id ?>', {target : null, block : {create : true, info : null, sec : null, target : null, data : 'Aguarde', color : 'blue', type : 'circle', size : 'sm', message : true}});">

        <i class="bi bi-arrow-clockwise me-1"></i>Atualizar

    </button>

</div>

<div class="col-md-12">

    <div class="card animate slideIn">

        <div class="card-body">

            <h4>

                <b>

                    <span class="badge rounded-pill bg-<?php echo @(string)$ClientsGetResult->class ?>">

                        <?php echo @(string)$ClientsGetResult->phrase ?>

                    </span>

                    -

                    #<?php echo $ClientsGetResult->clients_id;?> -
                    <?php echo $ClientsGetResult->client_name;?>

                </b>

            </h4>

            <div class="row h-100">

                <div class="col my-auto">

                    <h6>

                        CNPJ:
                        <br>
                        <b>

                            <?php echo $ClientsGetResult->document == '' ? 'Sem Informações' : $ClientsGetResult->document;?>

                        </b>

                    </h6>

                </div>

                <div class="col my-auto">

                    <h6>

                        CNS:
                        <br>
                        <b>

                            <?php echo $ClientsGetResult->cns == '' ? 'Sem Informações' : $ClientsGetResult->cns;?>

                        </b>

                    </h6>

                </div>

                <div class="col my-auto">

                    <h6>

                        Estado:
                        <br>
                        <b>

                            <?php echo $ClientsGetResult->state == '' ? 'Sem Informações' : $ClientsGetResult->state;?>

                        </b>

                    </h6>

                </div>

                <div class="col my-auto">

                    <h6>

                        Cidade:
                        <br>
                        <b>

                            <?php echo $ClientsGetResult->city == '' ? 'Sem Informações' : $ClientsGetResult->city;?>

                        </b>

                    </h6>

                </div>

                <div class="col my-auto">

                    <h6>

                        CEP:
                        <br>
                        <b>

                            <?php echo $ClientsGetResult->zip_code == '' ? 'Sem Informações' : $ClientsGetResult->zip_code;?>

                        </b>

                    </h6>

                </div>

            </div>

        </div>

    </div>

</div>

<div class="col-md-12" id="">

    <div class="mt-1" id="ClientsBackupsLogsCalendar">

        <script type="text/javascript">

            /** Envio de Requisição */
            SendRequest('FOLDER=VIEW&TABLE=CLIENTS_BACKUPS_LOGS&ACTION=CLIENTS_BACKUPS_LOGS_CALENDAR&CLIENT_ID=<?php echo $ClientsGetResult->clients_id;?>', {target : 'ClientsBackupsLogsCalendar', block : {create : true, info : null, sec : null, target : 'ClientsBackupsLogsCalendar', data : 'Aguarde', color : 'blue', type : 'circle', size : 'sm', message : true}});

        </script>

    </div>

</div>
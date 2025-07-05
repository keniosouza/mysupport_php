<?php

/** Importação de classes */
use vendor\model\Files;
use vendor\model\Products;
use vendor\model\ClientsLogs;

/** Instânciamento de classes */
$Files = new Files();
$Products = new Products();
$ClientsLogs = new ClientsLogs();

/** Parâmetros de Entrada */
$dateStart = date('Y-m-d');
$dateStart = '2024-01-01';
$dateEnd = date('Y-m-d');

/** Busco todos os produtos que recebem log */
$ProductsAllWhereSistemaIdIsNotNullResult = $Products->AllWhereSistemaIdIsNotNull()?>

<div class="col-md-12">

    <div class="card">

        <div class="card-body text-center">

            <h5 id="ClientsLogsPanelDateRegister">

                01/01/2021 15:01:01

            </h5>

            <img src="image/default/error.png" alt="">

            <h1 id="ClientsLogsPanelClientName">

                MUTUNóPOLIS/GO - TABELIONATO DE NOTAS, DE PROTESTOS DE TíTULOS, TABELIONATO E OFICIALATO DE REGISTRO DE CONTRATOS MARíTIMOS, REGISTRO DE IMóVEIS, REGISTRO DE TíTULOS E DOCUMENTOS, CIVIL DAS PESSOAS JURíDICAS E CíVEL DAS PESSOAS NATURAIS E DE INTERDIçõES E TUTELAS

            </h1>

            <div class="p-3 rounded bg-light border">

                <h2 id="ClientsLogsPanelMessage">

                    #64 - Could not convert variant of type (Null) into type (Currency) Form: frmIrregularidadesTitulos Objeto: btnConfirmar Erro: Could not convert variant of type (Null) into type (Currency)

                </h2>

            </div>

        </div>

    </div>

</div>

<div class="custom-scrollbar p-1" style="max-height: 400px">

    <div class="row g-1">

        <?php

        /** Consulta os usuário cadastrados*/
        foreach ($ClientsLogs->All($dateStart, $dateEnd) as $key => $result) {

            /** Converto em objeto os dados da mensagem */
            $result->data = (object)json_decode($result->data);

            /** Busco a imagem */
            $result->file = $Files->Last($result->client_id, 'clients');?>

            <div class="card">

                <div class="card-body">

                    <div class="row">

                        <div class="col-md">

                            <div class="fw-normal">

                                Data:

                            </div>

                            <div class="fw-medium fs-5">

                                <?php echo date('d/m/Y H:i:s', strtotime($result->date_register))?>

                            </div>

                        </div>

                        <div class="col-md">

                            <div class="fw-normal">

                                Categoria:

                            </div>

                            <div class="fw-medium fs-5">

                                <?php echo $result->client_name?>

                            </div>

                        </div>

                        <div class="col-md">

                            <div class="fw-normal">

                                Usuário:

                            </div>

                            <div class="fw-medium fs-5">

                                <?php echo $result->data->usuario?>

                            </div>

                        </div>

                        <div class="col-md">

                            <div class="fw-normal">

                                Cliente:

                            </div>

                            <div class="fw-medium fs-5">

                                <?php echo $result->client_name?>

                            </div>

                        </div>

                        <div class="col-md-12">

                            <div class="fw-normal">

                                Mensagem:

                            </div>

                            <div class="fw-medium fs-5 p-3 bg-light rounded">

                                #<?php echo $result->client_error_log_id?> - <?php echo $result->data->mensagem?>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        <?php }?>

    </div>

</div>

<script type="text/javascript">

    // SendRequest('FOLDER=ACTION&TABLE=CLIENTS_LOGS&ACTION=CLIENTS_LOGS_PANEL', {target : null, loader : {create: false}});
    //
    // /** envio a requisição desejada */
    // // Define a função que você quer repetir
    // function minhaFuncao() {
    //     SendRequest('FOLDER=ACTION&TABLE=CLIENTS_LOGS&ACTION=CLIENTS_LOGS_PANEL', {target : null, loader : {create: false}});
    //     // Coloque aqui o código que você quer executar a cada minuto
    // }
    //
    //
    // setInterval(minhaFuncao, 60000);
    //
    // function ClientsLogPanelRefresh(data)
    // {
    //
    //     let objeto = JSON.parse(data.data.data);
    //
    //     document.getElementById('ClientsLogsPanelDateRegister').innerText = data.data.date_register;
    //     document.getElementById('ClientsLogsPanelClientName').innerText = data.data.client_name;
    //     document.getElementById('ClientsLogsPanelMessage').innerText = objeto.mensagem;
    //
    // }

</script>
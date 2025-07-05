<?php

/** Importação de classes */
use \vendor\model\CallsClients;

/** Instânciamento de classes */
$CallsClients = new CallsClients();

/** Parâmetros de entrada */
$callId = @(int)filter_input(INPUT_POST, 'CALL_ID', FILTER_SANITIZE_SPECIAL_CHARS);

/** Busco as imagens vinculadas */
$resultCallsClients = $CallsClients->All($callId, @(int)$_SESSION['USERSCOMPANYID']);

?>

<?php

/** Verifico se existem registros */
if (@(int)count($resultCallsClients) > 0) { ?>

    <div class="row">

        <div class="col-md-6">

            <h6 class="card-title text-muted">

                <i class="fas fa-users me-1"></i>Clientes - <span class="badge rounded-pill text-bg-primary"><?php echo count($resultCallsClients) ?></span>

            </h6>

        </div>

        <?php

        /** Verifico se a permissão */
        if (@(string)$resultUserAcl->chamado->vincular_cliente === 'true') { ?>

            <?php

            /** Verifico o status do registro */
            if (empty(@(string)$resultCalls->date_close)) { ?>

                <div class="col-md-6 text-end">

                    <a class="btn btn-primary btn-sm" type="button" onclick="request('FOLDER=VIEW&TABLE=CALLS_CLIENTS&ACTION=CALLS_CLIENTS_FORM&CALL_ID=<?php echo @(int)$resultCalls->call_id ?>', '#loadContent', true, '', '', '', 'Preparando formulário', 'blue', 'circle', 'sm', true)">

                        <i class="bi bi-plus me-1"></i>Novo

                    </a>

                </div>

            <?php } ?>

        <?php } ?>

    </div>

    <table class="table table-bordered table-borderless table-hover bg-white border">

        <thead>

        <tr>

            <th class="text-center">

                Nº

            </th>

            <th>

                Nome

            </th>

            <?php

            /** Verifico o status do registro */
            if (empty(@(string)$resultCalls->date_close)) { ?>

                <th class="text-center">

                    Operações

                </th>

            <?php } ?>

        </tr>

        </thead>

        <tbody>

        <?php

        /** Consulta os usuário cadastrados*/
        foreach ($resultCallsClients as $keyResultCallsClients => $result) {

            /** Listo os acessos realizados */
            foreach (json_decode($result->history, TRUE) as $keyResultHistory => $resultHistory) {

                /** Crio um campo para ordenação */
                $resultHistory['date_time'] = date('Y/m/d', strtotime($resultHistory['date'])) . ' ' . $resultHistory['time'];

                /** Formatação do histórico */
                array_push($resultHistoryFormatted, $resultHistory);

            }

            /** Crio o nome da função */
            $result->delete = 'function_delete_' . md5(microtime());

            ?>

            <tr class="border-top">

                <td class="text-center">

                    <?php echo @(int)$result->call_client_id; ?>

                </td>

                <td class="text-wrap">

                    <?php echo @(string)$result->fantasy_name; ?>

                </td>

                <?php

                /** Verifico o status do registro */
                if (empty(@(string)$resultCalls->date_close)) { ?>

                    <td class="text-center">

                        <div role="form" id="formProductsCompanies<?php echo @(int)$keyResultCallsClients ?>" class="btn-group dropleft">

                            <button class="btn btn-primary dropdown-toggle" type="button" id="buttonDropdown_<?php echo @(int)$keyResultCallsClients ?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                                <i class="fas fa-cog"></i>

                            </button>

                            <div class="dropdown-menu shadow-sm" aria-labelledby="dropdownMenuButton">

                                <a type="button" class="dropdown-item" data-toggle="collapse" href="#collapse_calls_clients_<?php echo @(int)$keyResultCallsClients ?>">

                                                        <span class="badge rounded-pill text-bg-primary me-1">

                                                            <i class="bi bi-eye me-1"></i>Detalhes

                                                        </span>

                                    Detalhes

                                </a>

                                <?php

                                /** Verifico se a permissão */
                                if (@(string)$resultUserAcl->chamado->vincular_cliente === 'true') { ?>

                                    <div class="dropdown-divider"></div>

                                    <a type="button" class="dropdown-item" onclick="modalPage(true, 0, 0, 'Atenção', 'Deseja realmente remover o registro?', '', 'question', <?php echo @(string)$result->delete ?>)">

                                                            <span class="badge rounded-pill text-bg-danger me-1">

                                                                <i class="bi bi-fire me-1"></i>Remover

                                                            </span>

                                        Excluir

                                    </a>

                                <?php } ?>

                            </div>

                            <?php

                            /** Verifico se a permissão */
                            if (@(string)$resultUserAcl->chamado->vincular_cliente === 'true') { ?>

                                <script type="text/javascript">

                                    /** Carrega a função de logout */
                                    let <?php echo @(string)$result->delete?> = "request('FOLDER=ACTION&TABLE=CALLS_CLIENTS&ACTION=CALLS_CLIENTS_DELETE&CALL_ID=<?php echo @(int)$result->call_id?>&CALL_CLIENT_ID=<?php echo @(int)$result->call_client_id?>', '', true, '', 0, '', 'Removendo cliente', 'yellow', 'circle', 'sm', true)";

                                </script>

                            <?php } ?>

                        </div>

                    </td>

                <?php } ?>

            </tr>

            <tr class="collapse" id="collapse_calls_clients_<?php echo @(int)$keyResultCallsClients ?>">

                <td class="border-top bg-gray" colspan="3">

                    <div class="main-card card shadow-sm">

                        <div class="card-body">

                            <div class="vertical-timeline vertical-timeline--animate vertical-timeline--one-column">

                                <?php

                                /** Pego o histórico existente */
                                $history = json_decode($result->history, TRUE);

                                /** Listo os acessos realizados */
                                foreach ($history as $keyResultHistory => $resultHistory) { ?>

                                    <div class="vertical-timeline-item vertical-timeline-element">

                                        <div>

                                                                <span class="vertical-timeline-element-icon bounce-in">

                                                                    <i class="badge badge-dot badge-dot-xl <?php echo @(string)$resultHistory['class'] ?>"> </i>

                                                                </span>

                                            <div class="vertical-timeline-element-content bounce-in">

                                                <h4 class="timeline-title">

                                                    <?php echo @(string)$resultHistory['title'] ?> - <?php echo @(string)$resultHistory['user'] ?>

                                                </h4>

                                                <p>

                                                    <?php echo @(string)$resultHistory['description'] ?>

                                                    <a href="javascript:void(0);" data-abc="true">

                                                        <?php echo @(string)$resultHistory['date'] ?>

                                                    </a>

                                                </p>

                                                <span class="vertical-timeline-element-date">

                                                                        <?php echo @(string)$resultHistory['time'] ?>

                                                                    </span>

                                            </div>

                                        </div>

                                    </div>

                                <?php } ?>

                            </div>

                        </div>

                    </div>

                </td>

            </tr>

        <?php } ?>

        </tbody>

    </table>

<?php } else { ?>

    <div class="card card-hover border border-dashed w-100 text-center">

        <div class="card-body">

            <img src="img/emptybox.png" class="img-fluid " width="300px" alt="">

            <h3 class="card-title">

                <b>

                    Não foram localizados clientes para este chamado

                </b>

            </h3>

            <div class="card-text">

                <a type="button" class="stretched-link text-decoration-none badge badge-light" onclick="request('FOLDER=VIEW&TABLE=CALLS_CLIENTS&ACTION=CALLS_CLIENTS_FORM&CALL_ID=<?php echo @(int)$resultCalls->call_id ?>', '#loadContent', true, '', '', '', 'Preparando formulário', 'blue', 'circle', 'sm', true)">

                    Clique para vincular

                </a>

            </div>

        </div>

    </div>

<?php } ?>
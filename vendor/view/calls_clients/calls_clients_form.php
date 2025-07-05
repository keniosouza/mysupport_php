<?php

/** Importação de classes */
use \vendor\controller\main\Main;
use \vendor\model\Clients;
use \vendor\model\CallsClients;
use \vendor\controller\calls_clients\CallsClientsValidate;

/** Instânciamento de classes */
$Main = new Main();
$Clients = new Clients();
$CallsClients = new CallsClients();
$CallsClientsValidate = new CallsClientsValidate();

/** Tratamento dos dados de entrada */
$CallsClientsValidate->setCallId(@(int)filter_input(INPUT_POST, 'CALL_ID', FILTER_SANITIZE_SPECIAL_CHARS));
$CallsClientsValidate->setCompanyId(@(int)$_SESSION['USERSCOMPANYID']);

/** Verifico se existe registro */
if ($CallsClientsValidate->getCompanyId() > 0) {

    /** Busca de registro */
    $resultClients = $Clients->AllNoLimit(@(int)$_SESSION['USERSCOMPANYID'], $CallsClientsValidate->getCallId());

}

?>

    <form id="formDrafts">

        <div class="row">

            <div class="col-md-10">

                <div class="form-group mb-2">

                    <input type="text" class="form-control form-control-solid" placeholder="Pesquise por: Nome" id="search" name="search">

                </div>

            </div>

            <div class="col-md-2">

                <button class="btn btn-primary w-100" id="selectAll" type="button" onclick="selectAllCheckBox()">

                    <i class="far fa-check-circle me-1"></i>Todos

                </button>

            </div>

        </div>

        <div style="overflow-y: scroll; max-height: 200px">

            <table class="table table-bordered table-borderless table-hover bg-white shadow-sm border" id="search_table">

                <thead id="search_table_head">
                <tr>

                    <th>

                        UF

                    </th>

                    <th>

                        Nome

                    </th>

                </tr>

                </thead>

                <tbody>

                <?php

                /** Consulta os usuário cadastrados*/
                foreach ($resultClients as $keyResultClients => $result) {?>

                    <tr class="border-top">

                        <td>

                            <?php echo @(string)$result->state_initials ?>

                        </td>

                        <td>

                            <div class="form-group">

                                <div class="custom-control custom-switch">

                                    <input type="checkbox" class="custom-control-input" id="customSwitch<?php echo @(int)$keyResultClients ?>" value="<?php echo @(int)$result->clients_id ?>" name="call_client_id[]">

                                    <label class="custom-control-label" for="customSwitch<?php echo @(int)$keyResultClients ?>">

                                        <?php echo @(string)$result->fantasy_name ?>

                                    </label>

                                </div>

                            </div>

                        </td>

                    </tr>

                <?php } ?>

                </tbody>

            </table>

        </div>

        <button type="button" class="btn btn-primary w-100 mb-0 " onclick="sendForm('#formDrafts', 'N', true, '', 0, '', '', 'random', 'circle', 'md', true)">

            <i class="bi bi-check me-1"></i>Salvar

        </button>

        <input type="hidden" name="call_id" value="<?php echo @(string)$CallsClientsValidate->getCallId() ?>"/>
        <input type="hidden" name="FOLDER" value="ACTION"/>
        <input type="hidden" name="TABLE" value="CALLS_CLIENTS"/>
        <input type="hidden" name="ACTION" value="CALLS_CLIENTS_SAVE"/>

    </form>

    <script type="text/javascript">

        /** Carrego o LiveSearch */
        ;

    </script>

<?php

/** Pego a estrutura do arquivo */
$div = ob_get_contents();

/** Removo o arquivo incluido */
ob_clean();

/** Result **/
$result = array(

    'code' => 201,
    'data' => $div,
    'title' => 'Vinculo de Clientes',
    'width' => '880',

);

/** Envio **/
echo json_encode($result);

/** Paro o procedimento **/
exit;

?>
<?php

/** Importação de classes */
use \vendor\controller\main\Main;
use \vendor\model\Products;
use \vendor\model\CallsProducts;
use \vendor\controller\calls_products\CallsProductsValidate;

/** Instânciamento de classes */
$Main = new Main();
$Products = new Products();
$CallsProducts = new CallsProducts();
$CallsProductsValidate = new CallsProductsValidate();

/** Tratamento dos dados de entrada */
$CallsProductsValidate->setCallId(@(int)filter_input(INPUT_POST, 'CALL_ID', FILTER_SANITIZE_SPECIAL_CHARS));
$CallsProductsValidate->setCompanyId(@(int)$_SESSION['USERSCOMPANYID']);

/** Verifico se existe registro */
if ($CallsProductsValidate->getCompanyId() > 0) {

    /** Busca de registro */
    $resultUsers = $Products->AllNoLimit($CallsProductsValidate->getCompanyId());

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

                        Nome

                    </th>

                </tr>

                </thead>

                <tbody>

                <?php

                /** Consulta os usuário cadastrados*/
                foreach ($resultUsers as $keyResultUsers => $result) {
                    ?>

                    <tr class="border-top">

                        <td>

                            <div class="form-group">

                                <div class="custom-control custom-switch">

                                    <input type="checkbox" class="custom-control-input" id="customSwitch<?php echo @(int)$keyResultUsers ?>" value="<?php echo @(int)$result->products_id ?>" name="call_product_id[]">

                                    <label class="custom-control-label" for="customSwitch<?php echo @(int)$keyResultUsers ?>">

                                        <?php echo @(string)$result->name ?>

                                    </label>

                                </div>

                            </div>

                        </td>

                    </tr>

                <?php } ?>

                </tbody>

            </table>

        </div>

        <button type="button" class="btn btn-primary w-100" onclick="sendForm('#formDrafts', 'N', true, '', 0, '', '', 'random', 'circle', 'md', true)">

            <i class="bi bi-check me-1"></i>Salvar

        </button>

        <input type="hidden" name="call_id" value="<?php echo utf8_decode(@(string)$CallsProductsValidate->getCallId()) ?>"/>
        <input type="hidden" name="FOLDER" value="ACTION"/>
        <input type="hidden" name="TABLE" value="CALLS_PRODUCTS"/>
        <input type="hidden" name="ACTION" value="CALLS_PRODUCTS_SAVE"/>

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
    'title' => 'Gerenciando movimentação',
    'width' => '880',

);

/** Envio **/
echo json_encode($result);

/** Paro o procedimento **/
exit;

?>
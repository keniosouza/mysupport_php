<?php

/** Importação de classes  */
use vendor\model\Products;
use vendor\model\ProductsType;

/** Instânciamento de classes  */
$Products = new Products();
$ProductsType = new ProductsType();

/** Parametros de entrada */
$productsId = @(int)filter_input(INPUT_POST, 'products_id', FILTER_SANITIZE_SPECIAL_CHARS);

/** Consulta os dados do controle de acesso */
$ProductsResult = $Products->Get($productsId);

?>

<div class="col-md-12">

    <div class="card shadow-sm animate slideIn">

        <div class="card-body">

            <form id="ProductsForm">

                <div class="row">

                    <div class="col-md-6 mb-2">

                        <label for="name">

                            <b>Nome</b>

                        </label>

                        <input type="text" class="form-control form-control-solid" id="name" name="name" value="<?php echo (string)$ProductsResult->name; ?>">

                    </div>

                    <div class="col-md-6">

                        <label for="products_type_id">

                            <b>Tipo</b>

                        </label>

                        <select class="form-control form-control-solid form-control form-control-solid" id="products_type_id" name="products_type_id">

                            <option value="0"> Selecione</option>

                            <?php

                            $ProductsTypeResult = $ProductsType->All(0, 0);
                            foreach ($ProductsTypeResult as $ProductsTypeResultKey => $Result) { ?>

                                <option value="<?php echo (int)$Result->products_type_id; ?>" <?php echo (int)$ProductsResult->products_type_id === (int)$Result->products_type_id ? 'selected' : null; ?>>

                                    <?php echo (string)$Result->description; ?>

                                </option>

                            <?php } ?>

                        </select>

                    </div>

                    <div class="col-md-12 mb-2">

                        <label for="description ">

                            <b>Descrição</b>

                        </label>

                        <main>

                            <div id="description_toolbar"></div>

                            <div class="row-editor">

                                <div class="editor-container">

                                    <div class="editor" id="description">

                                        <?php echo (string)$ProductsResult->description ?>

                                    </div>

                                </div>

                            </div>

                        </main>

                    </div>

                    <div class="col-md-12 pt-2" id="ProductsMessages"></div>

                    <div class="col-md-12 text-end">

                        <button type="button" class="btn btn-primary w-100 mt-3" id="ProductsSaveButton" onclick="SendRequest('ProductsForm', {target : 'ProductsMessages', loader : {create: true, padding: '0px', type: 3, target : 'ProductsSaveButton', data : 'Aguarde...'}});">

                            <i class="bi bi-check me-1"></i>Salvar

                        </button>

                    </div>

                </div>

                <input type="hidden" name="TABLE" value="products" />
                <input type="hidden" name="ACTION" value="products_save" />
                <input type="hidden" name="FOLDER" value="action" />
                <input type="hidden" name="products_id" value="<?php echo (int)$ProductsResult->products_id; ?>" />

            </form>

        </div>

    </div>

</div>

<script type="text/javascript">

    /** inputs mask */
    loadCKEditor();

</script>

<?php

/** Prego a estrutura do arquivo */
$html = ob_get_contents();

/** Removo o arquivo incluido */
ob_clean();

/** Result **/
$result = array(

    'code' => 201,
    'title' => 'Produtos / Formulário /',
    'data' => $html,
    'size' => 'lg',
    'color_modal' => null,
    'color_border' => null,
    'type' => null,
    'procedure' => null,
    'time' => null

);

/** Envio **/
echo json_encode($result);

/** Paro o procedimento **/
exit;

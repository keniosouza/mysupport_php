<?php

/** Importação de classes  */
use vendor\model\ProductsVersions;
use vendor\controller\products_versions\ProductsVersionsValidate;

/** Instânciamento de classes  */
$ProductsVersions = new ProductsVersions();
$ProductsVersionsValidate = new ProductsVersionsValidate();

/** Parametros de entrada */
$ProductsVersionsValidate->setProductId(@(int)filter_input(INPUT_POST, 'product_id', FILTER_SANITIZE_SPECIAL_CHARS));
$ProductsVersionsValidate->setProductVersionId(@(int)filter_input(INPUT_POST, 'product_version_id', FILTER_SANITIZE_SPECIAL_CHARS));

/** Verifica se o ID do projeto foi informado */
if ($ProductsVersionsValidate->getProductVersionId() > 0) {

    /** Consulta os dados do controle de acesso */
    $resultProductsVersions = $ProductsVersions->Get($ProductsVersionsValidate->getProductVersionId());

} else {

    /** Consulta os dados do controle de acesso */
    $resultProductsVersions = $ProductsVersions->Describe();

} ?>

    <div class="card">

        <div class="card-body">

            <form id="ProductsVersionsForm">

                <div class="row g-2">

                    <div class="col-md-12">

                        <div class="form-group">

                            <label for="number">

                                Numero

                            </label>

                            <input type="text" class="form-control form-control-solid" id="number" name="number" value="<?php echo @(string)$resultProductsVersions->number; ?>">

                        </div>

                    </div>

                    <div class="col-md-12">

                        <div class="form-group">

                            <label for="description ">

                                Descrição

                            </label>

                            <main>

                                <div id="description_toolbar"></div>

                                <div class="row-editor" style="max-height: 200px">

                                    <div class="editor-container">

                                        <div class="editor" id="description">

                                            <?php echo @(string)$resultProductsVersions->description ?>

                                        </div>

                                    </div>

                                </div>

                            </main>

                        </div>

                    </div>

                    <div class="col-md-12 pt-2" id="ProductsVersionsMessages"></div>

                    <div class="col-md-12 text-end">

                        <button type="button" class="btn btn-primary w-100 mt-3" id="ProductsVersionSaveButton" onclick="SendRequest('ProductsVersionsForm', {target : 'ProductsVersionsMessages', loader : {create: true, type: 3, target : 'ProductsVersionSaveButton', data : 'Aguarde...'}});">

                            <i class="bi bi-check me-1"></i>Salvar

                        </button>

                    </div>

                </div>

                <input type="hidden" name="TABLE" value="products_versions"/>
                <input type="hidden" name="ACTION" value="products_versions_save"/>
                <input type="hidden" name="FOLDER" value="action"/>
                <input type="hidden" name="product_id" value="<?php echo (int)$ProductsVersionsValidate->getProductId(); ?>"/>
                <input type="hidden" name="product_version_id" value="<?php echo (int)$ProductsVersionsValidate->getProductVersionId(); ?>"/>

            </form>

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
    'title' => 'Produto / Versão / Formulário',
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

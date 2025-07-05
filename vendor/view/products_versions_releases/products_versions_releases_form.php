<?php

/** Importação de classes */
use vendor\controller\products_versions\ProductsVersionsValidate;
use vendor\model\ProductsVersionsReleases;
use vendor\controller\products_versions_releases\ProductsVersionsReleasesValidate;

/** Instânciamento de classes  */
$ProductsVersionsValidate = new ProductsVersionsValidate();
$ProductsVersionsReleases = new ProductsVersionsReleases();
$ProductsVersionsReleasesValidate = new ProductsVersionsReleasesValidate();

/** Parametros de entrada */
$ProductsVersionsValidate->setProductId(@(int)filter_input(INPUT_POST, 'product_id', FILTER_SANITIZE_SPECIAL_CHARS));
$ProductsVersionsReleasesValidate->setProductVersionId(@(int)filter_input(INPUT_POST, 'product_version_id', FILTER_SANITIZE_SPECIAL_CHARS));
$ProductsVersionsReleasesValidate->setProductVersionReleaseId(@(int)filter_input(INPUT_POST, 'product_version_release_id', FILTER_SANITIZE_SPECIAL_CHARS));

/** Verifica se o ID do projeto foi informado */
if ($ProductsVersionsReleasesValidate->getProductVersionReleaseId() > 0) {

    /** Consulta os dados do controle de acesso */
    $resultProductsVersionsReleasesReleases = $ProductsVersionsReleases->Get($ProductsVersionsReleasesValidate->getProductVersionReleaseId());

} ?>

    <div class="card">

        <div class="card-body">

            <form class="row" id="ProductsVersionsReleasesForm">

                <div class="col-md-6">

                    <div class="form-group">

                        <label for="status">

                            <b>Status</b>

                        </label>

                        <select name="status" id="status" class="form-control form-select form-control-solid">

                            <option value="1" <?php echo @(int)$resultProductsVersionsReleasesReleases->status === 1 ? 'selected' : null; ?>>

                                1º - Desenvolvimento

                            </option>

                            <option value="2" <?php echo @(int)$resultProductsVersionsReleasesReleases->status === 2 ? 'selected' : null; ?>>

                                2º - Homologação

                            </option>

                            <option value="3" <?php echo @(int)$resultProductsVersionsReleasesReleases->status === 3 ? 'selected' : null; ?>>

                                3º - Produção

                            </option>

                            <option value="4" <?php echo @(int)$resultProductsVersionsReleasesReleases->status === 4 ? 'selected' : null; ?>>

                                4º - Encerrado

                            </option>

                        </select>

                    </div>

                </div>

                <div class="col-md-6">

                    <div class="form-group">

                        <label for="number">

                            <b>Numero</b>

                        </label>

                        <input type="text" class="form-control form-control-solid" id="number" name="number" value="<?php echo @(string)$resultProductsVersionsReleasesReleases->number; ?>">

                    </div>

                </div>

                <div class="col-md-12 mb-2">

                    <div class="form-group">

                        <label for="description">

                            <b>Descrição</b>

                        </label>

                        <main>

                            <div id="description_toolbar"></div>

                            <div class="row-editor">

                                <div class="editor-container">

                                    <div class="editor" id="description">

                                        <?php echo @(string)$resultProductsVersionsReleasesReleases->description ?>

                                    </div>

                                </div>

                            </div>

                        </main>

                    </div>

                </div>

                <div class="col-md-12" id="ProductsVersionsReleasesMessages"></div>

                <div class="col-md-12 text-end">

                    <button type="button" class="btn btn-primary w-100" id="ProductsReleaseSaveButton" onclick="SendRequest('ProductsVersionsReleasesForm', {target : 'ProductsVersionsReleasesMessages', loader : {create: true, type: 3, target : 'ProductsReleaseSaveButton', data : 'Aguarde...'}});">

                        <i class="bi bi-check me-1"></i>Salvar

                    </button>

                </div>

                <input type="hidden" name="TABLE" value="products_versions_releases"/>
                <input type="hidden" name="ACTION" value="products_versions_releases_save"/>
                <input type="hidden" name="FOLDER" value="action"/>
                <input type="hidden" name="product_id" value="<?php echo (int)$ProductsVersionsValidate->getProductId(); ?>"/>
                <input type="hidden" name="product_version_id" value="<?php echo (int)$ProductsVersionsReleasesValidate->getProductVersionId(); ?>"/>
                <input type="hidden" name="product_version_release_id" value="<?php echo (int)$ProductsVersionsReleasesValidate->getProductVersionReleaseId(); ?>"/>

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
    'title' => 'Produtos / Versões / Releases / Formulário',
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

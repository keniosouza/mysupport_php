<?php

/** Importação de classes */
use vendor\model\ProductsVersions;
use vendor\controller\products_versions\ProductsVersionsValidate;

/** Instânciamento de classes  */
$ProductsVersions = new ProductsVersions();
$ProductsVersionsValidate = new ProductsVersionsValidate();

/** Parametros de entrada */
$ProductsVersionsValidate->setProductVersionId(@(int)filter_input(INPUT_POST, 'product_version_id', FILTER_SANITIZE_SPECIAL_CHARS));

/** Verifica se o ID do projeto foi informado */
if ($ProductsVersionsValidate->getProductVersionId() > 0) {

    /** Consulta os dados do controle de acesso */
    $resultProductsVersions = $ProductsVersions->Get($ProductsVersionsValidate->getProductVersionId());

    $resultProductsVersions->history = json_decode($resultProductsVersions->history, TRUE);

} ?>

    <div class="card">

        <div class="card-body">

            <div class="timeline block">

                <?php

                /** Listo os acessos realizados */
                foreach ($resultProductsVersions->history as $keyResultHistory => $result) { ?>

                    <div class="tl-item <?php echo ($keyResultHistory + 1) === count($resultProductsVersions->history) ? 'active' : null ?>">

                        <div class="tl-dot b-<?php echo str_replace('badge-', '', @(string)$result['class']) ?>"></div>

                        <div class="tl-content">

                            <div class="">

                                <b>

                                    <?php echo @(string)$result['user'] ?>

                                </b>

                                - <?php echo @(string)$result['description'] ?>

                            </div>

                            <div class="tl-date text-muted mt-1">

                                <?php echo @(string)$result['date'] ?> - <?php echo @(string)$result['time'] ?>

                            </div>

                        </div>

                    </div>

                <?php } ?>

            </div>

        </div>

    </div>

<?php

/** Prego a estrutura do arquivo */
$html = ob_get_contents();

/** Removo o arquivo incluido */
ob_clean();

/** Result **/
$result = array(

    'code' => 201,
    'title' => 'Produtos / Versões / Histórico',
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

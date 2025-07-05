<?php

/** Importação de classes */
use vendor\model\ProductsVersionsReleases;
use vendor\controller\products_versions_releases\ProductsVersionsReleasesValidate;

/** Instânciamento de classes  */
$ProductsVersionsReleases = new ProductsVersionsReleases();
$ProductsVersionsReleasesValidate = new ProductsVersionsReleasesValidate();

/** Parametros de entrada */
$ProductsVersionsReleasesValidate->setProductVersionId(@(int)filter_input(INPUT_POST, 'product_version_id', FILTER_SANITIZE_SPECIAL_CHARS));
$ProductsVersionsReleasesValidate->setProductVersionReleaseId(@(int)filter_input(INPUT_POST, 'product_version_release_id', FILTER_SANITIZE_SPECIAL_CHARS));

/** Verifica se o ID do projeto foi informado */
if ($ProductsVersionsReleasesValidate->getProductVersionReleaseId() > 0) {

    /** Consulta os dados do controle de acesso */
    $resultProductsVersionsReleasesReleases = $ProductsVersionsReleases->Get($ProductsVersionsReleasesValidate->getProductVersionReleaseId());

    /** Decodifição do Histórico */
    $resultProductsVersionsReleasesReleases->history = json_decode($resultProductsVersionsReleasesReleases->history, TRUE);

}

?>

<div class="card">

    <div class="card-body">

        <div class="timeline block">

            <?php

            /** Listo os acessos realizados */
            foreach ($resultProductsVersionsReleasesReleases->history as $keyResultHistory => $result) { ?>

                <div class="tl-item <?php echo ($keyResultHistory + 1) === count($resultProductsVersionsReleasesReleases->history) ? 'active' : null ?>">

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
    'title' => 'Produtos / Versões / Releases / Histórico',
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

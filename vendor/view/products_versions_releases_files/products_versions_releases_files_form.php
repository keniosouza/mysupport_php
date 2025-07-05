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

<!-- Espaço reservado para construção do formulário de arquivo -->
<div id="FilesFormWrapper">

    <script type="text/javascript">

        <?php

        /** Defino a opções de exibição do form */
        $options = new stdClass();
        /** Defino para aceitar apenas imagens */
        $options->accept = null;
        /** Defino para selecionar apenas um arquivo */
        $options->multiple = true;
        /** defino o tipo de exbição que deve ser feito: 1 - List, 2 - Recorte */
        $options->preview = 1;
        /** defino o tipo de exbição que deve ser feito: 1 - List, 2 - Recorte */
        $options->phrase = 'Solte seus arquivos aqui';

        ?>

        /** Envio de Requisição */
        SendRequest('FOLDER=VIEW&TABLE=FILES&ACTION=FILES_FORM&OPTIONS=<?php echo json_encode($options)?>', {target : 'FilesFormWrapper', block : {create : true, info : null, sec : null, target : 'FilesFormWrapper', data : 'Aguarde', color : 'blue', type : 'circle', size : 'sm', message : true}});

    </script>

</div>

<form id="FilesFormHeader">

    <input type="hidden" name="TABLE" value="products_versions_releases_files"/>
    <input type="hidden" name="ACTION" value="products_versions_releases_files_save"/>
    <input type="hidden" name="FOLDER" value="action"/>
    <input type="hidden" name="product_id" value="<?php echo @(int)$ProductsVersionsValidate->getProductId(); ?>"/>
    <input type="hidden" name="product_version_id" value="<?php echo @(int)$ProductsVersionsReleasesValidate->getProductVersionId(); ?>"/>
    <input type="hidden" name="product_version_release_id" value="<?php echo @(int)$ProductsVersionsReleasesValidate->getProductVersionReleaseId(); ?>"/>

</form>

<?php

/** Prego a estrutura do arquivo */
$html = ob_get_contents();

/** Removo o arquivo incluido */
ob_clean();

/** Result **/
$result = array(

    'code' => 201,
    'title' => 'Produtos / Versões / Releases / Arquivos',
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

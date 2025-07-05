<?php

/** Importação de classes  */
use vendor\model\Files;
use vendor\controller\files\FilesValidate;
use vendor\model\ProductsVersionsReleases;
use vendor\controller\products_versions_releases\ProductsVersionsReleasesValidate;
use vendor\controller\products_versions\ProductsVersionsValidate;

/** Instânciamento de classes  */
$Files = new Files();
$FilesValidate = new FilesValidate();
$ProductsVersionsReleases = new ProductsVersionsReleases();
$ProductsVersionsReleasesValidate = new ProductsVersionsReleasesValidate();
$ProductsVersionsValidate = new ProductsVersionsValidate();

/** Parametros de entrada  */
$productId = (int)filter_input(INPUT_POST, 'product_id', FILTER_SANITIZE_SPECIAL_CHARS);
$productVersionReleaseId = (int)filter_input(INPUT_POST, 'product_version_release_id', FILTER_SANITIZE_SPECIAL_CHARS);
$productVersionReleaseFilesId = (int)filter_input(INPUT_POST, 'product_version_release_file_id', FILTER_SANITIZE_SPECIAL_CHARS);
$productVersionId = (int)filter_input(INPUT_POST, 'product_version_id', FILTER_SANITIZE_SPECIAL_CHARS);

/** Validando os campos de entrada */
$FilesValidate->setFileId($productVersionReleaseFilesId);
$ProductsVersionsValidate->setProductId($productId);
$ProductsVersionsReleasesValidate->setProductVersionReleaseId($productVersionReleaseId);
$ProductsVersionsReleasesValidate->setProductVersionId($productVersionId);

/** Verifico a existência de erros */
if (!empty($ProductsVersionsReleasesValidate->getErrors())) {

    /** Retorno mensagem de erro */
    throw new InvalidArgumentException($ProductsVersionsReleasesValidate->getErrors(), 0);

} else {

    /** Busco o registro desejado */
    $resultFiles = $Files->Get($FilesValidate->getFileId());

    /** Verifico se o usuário foi localizado */
    if ($Files->Delete((int)$resultFiles->file_id)) {

        /** Removo o arquivo do disco */
        unlink((string)$resultFiles->path . '/' . $resultFiles->name);

        /** Result **/
        $result = [

            'code' => 200,
            'title' => 'Sucesso',
            'data' => $Main->generateAlertHtml('success', 'Atenção', 'Arquivo removido com sucesso'),
            'redirect' => [
                [
                    'url' => 'FOLDER=VIEW&TABLE=PRODUCTS_VERSIONS_RELEASES_FILES&ACTION=PRODUCTS_VERSIONS_RELEASES_FILES_DATAGRID&PRODUCT_VERSION_RELEASE_ID=' . $resultFiles->register_id,
                    'target' => 'ProductVersionRelease' . $resultFiles->register_id,
                ]
            ]

        ];

    } else {

        /** Retorno mensagem de erro */
        throw new InvalidArgumentException('Não foi possivel salvar o registro', 0);

    }

}

/** Envio **/
echo json_encode($result);

/** Paro o procedimento **/
exit;
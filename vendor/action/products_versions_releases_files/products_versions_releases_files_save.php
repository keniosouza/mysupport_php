<?php

/** Importação de classes  */
use vendor\model\Files;
use vendor\controller\files\FilesValidate;
use vendor\controller\files\FilesProcedures;
use vendor\model\ProductsVersionsReleases;
use vendor\controller\products_versions_releases\ProductsVersionsReleasesValidate;
use vendor\controller\products_versions\ProductsVersionsValidate;

/** Instânciamento de classes  */
$Files = new Files();
$FilesValidate = new FilesValidate();
$FilesProcedures = new FilesProcedures();
$ProductsVersionsReleases = new ProductsVersionsReleases();
$ProductsVersionsReleasesValidate = new ProductsVersionsReleasesValidate();
$ProductsVersionsValidate = new ProductsVersionsValidate();

/** Parametros de entrada dos PRODUTOS  */
$productId = (int)filter_input(INPUT_POST, 'product_id', FILTER_SANITIZE_SPECIAL_CHARS);
$productVersionId = (int)filter_input(INPUT_POST, 'product_version_id', FILTER_SANITIZE_SPECIAL_CHARS);
$productVersionReleaseId = (int)filter_input(INPUT_POST, 'product_version_release_id', FILTER_SANITIZE_SPECIAL_CHARS);

/** Parametros de entrada dos ARQUIVOS */
$fileId = (int)filter_input(INPUT_POST, 'file_id', FILTER_SANITIZE_SPECIAL_CHARS);
$registerId = (int)filter_input(INPUT_POST, 'product_version_release_id', FILTER_SANITIZE_SPECIAL_CHARS);
$table = 'products_versions_releases';

/** Parâmetros de entrada dos ARQUIVOS */
$name = (string)filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
$hash = $_POST['hash'];

/** Validando os campos de entrada */
$ProductsVersionsValidate->setProductId($productId);
$ProductsVersionsValidate->setProductVersionId($productVersionId);

/** Validando os campos de entrada */
$ProductsVersionsReleasesValidate->setProductVersionReleaseId($productVersionReleaseId);

/** Define o local do arquivo e realiza validações */
$FilesValidate->setFileId($fileId);
$FilesValidate->setRegisterId($registerId);
$FilesValidate->setTable($table);
$FilesValidate->setGenerateHistory();
$FilesValidate->setPath('temp/' . $hash);
$FilesValidate->setName($name);

/** Verifica a existência de erros durante a validação */
if (!empty($FilesValidate->getErrors())) {

    /** Caso ocorra algum erro, lança uma exceção com a mensagem de erro. */
    throw new InvalidArgumentException($FilesValidate->getErrors(), 0);

} else {

    /** Busco a RELEASE DO PRODUTO desejado */
    $resultProductVersionsReleases = $ProductsVersionsReleases->Load($ProductsVersionsReleasesValidate->getProductVersionReleaseId());

    /** Defino o local do arquivo */
    $FilesValidate->setPath('document/products/' . $resultProductVersionsReleases->products_id . '_product/' . $resultProductVersionsReleases->product_version_id . '_product_version/' . $resultProductVersionsReleases->product_version_release_id . '_product_version_release/');

    /** Realizo a junção das partes do arquivo */
    $FilesProcedures->merge('temp/' . $hash, $FilesValidate->getName(), $FilesValidate->getPath());

    /** Efetua um novo cadastro ou salva os novos dados */
    if ($Files->Save($FilesValidate->getFileId(), $FilesValidate->getRegisterId(), $FilesValidate->getTable(), $FilesValidate->getName(), $FilesValidate->getPath(), $FilesValidate->getGenerateHistory())) {

        /** Result **/
        $result = [

            'code' => 200,
            'end' => true,
            'title' => 'Sucesso',
            'data' => $Main->generateAlertHtml('success', 'Atenção', 'Registro Salvo com sucesso'),
            'redirect' => 'FOLDER=VIEW&TABLE=PRODUCTS_VERSIONS_RELEASES_FILES&ACTION=PRODUCTS_VERSIONS_RELEASES_FILES_DATAGRID&PRODUCT_VERSION_RELEASE_ID=' . $resultProductVersionsReleases->product_version_release_id,
            'target' => 'ProductVersionRelease' . $resultProductVersionsReleases->product_version_release_id,

        ];

    } else {

        /** Caso ocorra algum erro, informo */
        throw new InvalidArgumentException('Não foi possível atualizar o cadastro', 0);

    }

}

/** Envio do resultado em formato JSON */
echo json_encode($result);

/** Encerra o procedimento */
exit;

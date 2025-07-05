<?php

/** Importação de classes  */
use vendor\model\ProductsVersionsReleases;
use vendor\controller\products_versions_releases\ProductsVersionsReleasesValidate;
use vendor\controller\products_versions\ProductsVersionsValidate;

/** Instânciamento de classes  */
$ProductsVersionsReleases = new ProductsVersionsReleases();
$ProductsVersionsReleasesValidate = new ProductsVersionsReleasesValidate();
$ProductsVersionsValidate = new ProductsVersionsValidate();

/** Parametros de entrada  */
$productVersionReleaseId = (int)filter_input(INPUT_POST, 'product_version_release_id', FILTER_SANITIZE_SPECIAL_CHARS);

/** Validando os campos de entrada */
$ProductsVersionsReleasesValidate->setProductVersionReleaseId($productVersionReleaseId);

/** Verifico a existência de erros */
if (!empty($ProductsVersionsReleasesValidate->getErrors())) {

    /** Retorno mensagem de erro */
    throw new InvalidArgumentException($ProductsVersionsReleasesValidate->getErrors(), 0);

} else {

    /** Busco o registro desejado */
    $ResultProductsVersionsReleases = $ProductsVersionsReleases->Get($ProductsVersionsReleasesValidate->getProductVersionReleaseId());

    /** Verifico se o usuário foi localizado */
    if ($ProductsVersionsReleases->delete($ProductsVersionsReleasesValidate->getProductVersionReleaseId())) {

        /** Result **/
        $result = [

            'code' => 200,
            'title' => 'Sucesso',
            'procedure' => [
               [
                   'name' => 'RemoveHtml',
                   'options' => [
                       'target' => 'ProductVersionReleaseItem' . $ProductsVersionsReleasesValidate->getProductVersionReleaseId(),
                   ]
               ]
            ]

        ];

    } else {

        /** Retorno mensagem de erro */
        throw new InvalidArgumentException('Não foi possivel remover o registro', 0);

    }

}

/** Envio **/
echo json_encode($result);

/** Paro o procedimento **/
exit;
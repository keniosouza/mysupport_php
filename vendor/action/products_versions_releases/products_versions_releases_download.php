<?php

/** Importação de classes  */
use vendor\model\ProductsVersionsReleases;
use vendor\controller\products_versions_releases\ProductsVersionsReleasesValidate;
use vendor\controller\history\HistoryValidate;

/** Instânciamento de classes  */
$ProductsVersionsReleases = new ProductsVersionsReleases();
$ProductsVersionsReleasesValidate = new ProductsVersionsReleasesValidate();
$HistoryValidate = new HistoryValidate();

/** Parametros de entrada  */
$productVersionReleaseId = @(int)filter_input(INPUT_POST, 'product_version_release_id', FILTER_SANITIZE_SPECIAL_CHARS);

/** Validando os campos de entrada */
$ProductsVersionsReleasesValidate->setProductVersionReleaseId($productVersionReleaseId);

/** Verifico a existência de erros */
if (!empty($ProductsVersionsReleasesValidate->getErrors())) {

    /** Caso ocorra algum erro, informo */
    throw new InvalidArgumentException($ProductsVersionsReleasesValidate->getErrors(), 0);

} else {

    /** Verifico se devo pegar o histórico já existente */
    if ($ProductsVersionsReleasesValidate->getProductVersionReleaseId() > 0) {

        /** Busco o registro desejado */
        $resultProductsVersionsReleases = $ProductsVersionsReleases->get($ProductsVersionsReleasesValidate->getProductVersionReleaseId());

        /** Defino o histórico do registro de mensagem */
        $ProductsVersionsReleasesValidate->setHistory($HistoryValidate->generate($resultProductsVersionsReleases->history, 'Release de Versão de Produto!', 'Download de Release de Versão de Produto', 'badge-info', @(string)$_SERVER['REMOTE_ADDR']));

    } else {

        /** Defino o histórico do registro de mensagem */
        $ProductsVersionsReleasesValidate->setHistory($HistoryValidate->generate(null, 'Release de Versão de Produto!', 'Download de Release de Versão de Produto', 'badge-info', @(string)$_SERVER['REMOTE_ADDR']));

    }

    /** Efetua um novo cadastro ou salva os novos dados */
    if ($ProductsVersionsReleases->SaveHistory($ProductsVersionsReleasesValidate->getProductVersionReleaseId(), $ProductsVersionsReleasesValidate->getHistory())) {

        /** Result **/
        $result = [

            'code' => 211,
            'title' => 'Sucesso',
            'message' => 'Log Registrado com Sucesso'

        ];

    } else {

        /** Caso ocorra algum erro, informo */
        throw new InvalidArgumentException('Não foi possível atualizar o cadastro', 0);

    }

}

/** Envio **/
echo json_encode($result);

/** Paro o procedimento **/
exit;
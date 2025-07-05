<?php

/** Importação de classes */
use vendor\model\ProductsVersions;
use vendor\controller\products_versions\ProductsVersionsValidate;

/** Instânciamento de classes */
$ProductsVersions = new ProductsVersions();
$ProductsVersionsValidate = new ProductsVersionsValidate();

/** Parâmetros de entrada */
$ProductsVersionsValidate->setProductVersionId(@(int)filter_input(INPUT_POST, 'product_version_id', FILTER_SANITIZE_SPECIAL_CHARS));
$ProductsVersionsValidate->setProductId(@(int)filter_input(INPUT_POST, 'product_id', FILTER_SANITIZE_SPECIAL_CHARS));

/** Verifico a existência de erros */
if (!empty($ProductsVersionsValidate->getErrors())) {

    /** Retorno mensagem de erro */
    throw new InvalidArgumentException($ProductsVersionsValidate->getErrors(), 0);

} else {

    /** Verifico se o usuário foi localizado */
    if ($ProductsVersions->delete($ProductsVersionsValidate->getProductVersionId())) {

        /** Result **/
        $result = [

            'code' => 200,
            'title' => 'Sucesso',
            'message' => 'Registro removido com sucesso',
            'redirect' => [
                [
                    'url' => 'FOLDER=VIEW&TABLE=products&ACTION=products_datagrid_col_2&products_id=' . $ProductsVersionsValidate->getProductId(),
                    'target' => 'ProdcutsDatagridItem'
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
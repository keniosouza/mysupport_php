<?php

/** Importação de classes  */
use vendor\model\Products;
use vendor\controller\products\ProductsValidate;

/** Instânciamento de classes  */
$Products = new Products();
$ProductsValidate = new ProductsValidate();

/** Parametros de entrada  */
$productsId = (int)filter_input(INPUT_POST, 'products_id', FILTER_SANITIZE_SPECIAL_CHARS);
$companyId = (int)$_SESSION['USERSCOMPANYID'];
$productsTypeId = (int)filter_input(INPUT_POST, 'products_type_id', FILTER_SANITIZE_SPECIAL_CHARS);
$name = (string)filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
$description = $_POST['description'];

/** Validando os campos de entrada */
$ProductsValidate->setProductsId($productsId);
$ProductsValidate->setCompanyId($companyId);
$ProductsValidate->setProductsTypeId($productsTypeId);
$ProductsValidate->setName($name);
$ProductsValidate->setDescription($description);

/** Verifico a existência de erros */
if (!empty($ProductsValidate->getErrors())) {

    /** Caso ocorra algum erro, informo */
    throw new InvalidArgumentException($ProductsValidate->getErrors(), 0);

} else {

    /** Efetua um novo cadastro ou salva os novos dados */
    if ($Products->Save($ProductsValidate->getProductsId(), $ProductsValidate->getCompanyId(), $ProductsValidate->getProductsTypeId(), $ProductsValidate->getName(), $ProductsValidate->getDescription())) {

        /** Result **/
        $result = [

            'code' => 200,
            'title' => 'Sucesso',
            'data' => 'Registro Salvo com Sucesso',
            'redirect' => [
                [
                    'url' => 'FOLDER=VIEW&TABLE=PRODUCTS&ACTION=PRODUCTS_DATAGRID'
                ],
                [
                    'url' => 'FOLDER=VIEW&TABLE=PRODUCTS&ACTION=PRODUCTS_DATAGRID_COL_2&products_id=' . $ProductsValidate->getProductsId(),
                    'target' => 'ProdcutsDatagridItem'
                ]
            ]

        ];

    } else {

        /** Caso ocorra algum erro, informo */
        throw new InvalidArgumentException('Não foi salvar o registro', 0);

    }

}

/** Envio **/
echo json_encode($result);

/** Paro o procedimento **/
exit;
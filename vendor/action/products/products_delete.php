<?php

/** Importação de classes */
use vendor\model\Products;
use vendor\controller\products\ProductsValidate;

/** Instânciamento de classes */
$Products = new Products();
$ProductsValidate = new ProductsValidate();

/** Parâmetros de entrada */
$ProductsValidate->setProductsId(@(int)filter_input(INPUT_POST, 'products_id', FILTER_SANITIZE_SPECIAL_CHARS));

/** Verifico a existência de erros */
if (!empty($ProductsValidate->getErrors())) {

    /** Retorno mensagem de erro */
    throw new InvalidArgumentException($ProductsValidate->getErrors(), 0);

} else {

    /** Verifico se o usuário foi localizado */
    if ($Products->Delete($ProductsValidate->getProductsId())) {

        /** Result **/
        $result = [

            'code' => 200,
            'title' => 'Sucesso',
            'data' => $Main->generateAlertHtml('success', 'Atenção', 'Registro Removido Com Sucesso'),
            'redirect' => [
                [
                    'url' => 'FOLDER=VIEW&TABLE=PRODUCTS&ACTION=PRODUCTS_DATAGRID'
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
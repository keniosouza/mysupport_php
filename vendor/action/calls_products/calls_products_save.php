<?php

/** Importação de classes */
use vendor\model\Products;
use vendor\controller\products\ProductsValidate;
use vendor\model\Calls;
use vendor\controller\calls\CallsValidate;
use vendor\model\CallsProducts;
use vendor\controller\calls_products\CallsProductsValidate;
use vendor\controller\history\HistoryValidate;

try {

    /** Percorro todos os registros */
    foreach ($_POST['call_product_id'] as $keyResult => $result) {

        /** Instânciamento de classes */
        $Products = new Products();
        $ProductsValidate = new ProductsValidate();
        $Calls = new Calls();
        $CallsValidate = new CallsValidate();
        $CallsProducts = new CallsProducts();
        $CallsProductsValidate = new CallsProductsValidate();
        $HistoryValidate = new HistoryValidate();

        /** Parâmetros de entrada */
        $CallsProductsValidate->setCallProductId(@(int)filter_input(INPUT_POST, 'call_product_id', FILTER_SANITIZE_SPECIAL_CHARS));
        $CallsProductsValidate->setCallId(@(int)filter_input(INPUT_POST, 'call_id', FILTER_SANITIZE_SPECIAL_CHARS));
        $CallsProductsValidate->setProductId($result);
        $CallsProductsValidate->setCompanyId(@(int)$_SESSION['USERSCOMPANYID']);

        /** Verifico a existência de erros */
        if (!empty($CallsProductsValidate->getErrors())) {

            /** Retorno mensagem de erro */
            throw new InvalidArgumentException($CallsProductsValidate->getErrors(), 0);

        } else {

            /** Busco o registro desejado */
            $resultProducts = $Products->Get($CallsProductsValidate->getProductId());

            /** Montagem do histórico */
            $CallsProductsValidate->setHistory($HistoryValidate->generate(null, 'Produto!', 'Novo produto vinculado: ' . $resultProducts->name, 'rounded-pill text-bg-primary', @(string)$_SESSION['USERSNAMEFIRST']));

            /** Verifico se o usuário foi localizado */
            if ($CallsProducts->Save($CallsProductsValidate->getCallProductId(), $CallsProductsValidate->getCallId(), $CallsProductsValidate->getProductId(), $CallsProductsValidate->getCompanyId(), $CallsProductsValidate->getHistory())) {

                /** Result **/
                $result = [

                    'code' => 200,
                    'title' => 'Sucesso',
                    'redirect' => [
                        [
                            'url' => 'FOLDER=VIEW&TABLE=CALLS&ACTION=CALLS_DETAILS&CALL_ID=' . $CallsProductsValidate->getCallId()
                        ]
                    ]

                ];

            } else {

                /** Retorno mensagem de erro */
                throw new InvalidArgumentException('Não foi possivel salvar o registro', 0);

            }

        }

    }

    /** Envio **/
    echo json_encode($result);

    /** Paro o procedimento **/
    exit;

} catch (Exception $exception) {

    /** Preparo o formulario para retorno **/
    $result = [

        'code' => 0,
        'message' => '<div class="alert alert-danger" role="alert">' . $exception->getMessage() . '</div>',
        'title' => 'Atenção',
        'type' => 'exception',

    ];

    /** Envio **/
    echo json_encode($result);

    /** Paro o procedimento **/
    exit;

}
<?php

/** Importação de classes  */
use vendor\model\ProductsVersions;
use vendor\controller\products_versions\ProductsVersionsValidate;
use vendor\controller\history\HistoryValidate;
use vendor\controller\mail\Mail;

/** Instânciamento de classes  */
$ProductsVersions = new ProductsVersions();
$ProductsVersionsValidate = new ProductsVersionsValidate();
$HistoryValidate = new HistoryValidate();
$Mail = new Mail();

/** Parametros de entrada  */
$productVersionId = (int)filter_input(INPUT_POST, 'product_version_id', FILTER_SANITIZE_SPECIAL_CHARS);
$productId = (int)filter_input(INPUT_POST, 'product_id', FILTER_SANITIZE_SPECIAL_CHARS);
$description = (string)$_POST['description'];
$number = (string)filter_input(INPUT_POST, 'number', FILTER_SANITIZE_SPECIAL_CHARS);

/** Validando os campos de entrada */
$ProductsVersionsValidate->setProductVersionId($productVersionId);
$ProductsVersionsValidate->setProductId($productId);
$ProductsVersionsValidate->setDescription($description);
$ProductsVersionsValidate->setNumber($number);

/** Verifico a existência de erros */
if (!empty($ProductsVersionsValidate->getErrors())) {

    /** Caso ocorra algum erro, informo */
    throw new InvalidArgumentException($ProductsVersionsValidate->getErrors(), 0);

} else {

    /** Verifico se devo pegar o histórico já existente */
    if ($ProductsVersionsValidate->getProductVersionId() > 0) {

        /** Busco o registro desejado */
        $resultProductsVersions = $ProductsVersions->get($ProductsVersionsValidate->getProductVersionId());

        /** Defino o histórico do registro de mensagem */
        $ProductsVersionsValidate->setHistory($HistoryValidate->generate($resultProductsVersions->history, 'Versão de Produto!', 'Alteração de Versão de Produto', 'rounded-pill text-bg-warning', @(string)$_SESSION['USERSNAMEFIRST']));

    } else {

        /** Defino o histórico do registro de mensagem */
        $ProductsVersionsValidate->setHistory($HistoryValidate->generate(null, 'Versão de Produto!', 'Cadastro de Versão de Produto', 'rounded-pill text-bg-primary', @(string)$_SESSION['USERSNAMEFIRST']));

    }

    /** Efetua um novo cadastro ou salva os novos dados */
    if ($ProductsVersions->Save($ProductsVersionsValidate->getProductVersionId(), $ProductsVersionsValidate->getProductId(), $ProductsVersionsValidate->getDescription(), $ProductsVersionsValidate->getNumber(), $ProductsVersionsValidate->getHistory())) {

        /** Result **/
        $result = [

            'code' => 200,
            'title' => 'Sucesso',
            'data' => 'Registro Salvo com Sucesso',
            'redirect' => [
                [
                    'url' => 'FOLDER=VIEW&TABLE=products&ACTION=products_datagrid_col_2&products_id=' . $ProductsVersionsValidate->getProductId(),
                    'target' => 'ProdcutsDatagridItem'
                ]
            ]

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
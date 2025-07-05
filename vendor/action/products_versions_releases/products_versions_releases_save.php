<?php

/** Importação de classes  */
use vendor\model\ProductsVersionsReleases;
use vendor\model\Products;
use vendor\controller\products_versions_releases\ProductsVersionsReleasesValidate;
use vendor\controller\products_versions\ProductsVersionsValidate;
use vendor\controller\history\HistoryValidate;
use vendor\controller\mail\Mail;

/** Instânciamento de classes  */
$ProductsVersionsReleases = new ProductsVersionsReleases();
$Products = new Products();
$ProductsVersionsReleasesValidate = new ProductsVersionsReleasesValidate();
$ProductsVersionsValidate = new ProductsVersionsValidate();
$HistoryValidate = new HistoryValidate();
$Mail = new Mail();

/** Parametros de entrada  */
$productId = @(int)filter_input(INPUT_POST, 'product_id', FILTER_SANITIZE_SPECIAL_CHARS);
$productVersionReleaseId = @(int)filter_input(INPUT_POST, 'product_version_release_id', FILTER_SANITIZE_SPECIAL_CHARS);
$productVersionId = @(int)filter_input(INPUT_POST, 'product_version_id', FILTER_SANITIZE_SPECIAL_CHARS);
$description = @(string)$_POST['description'];
$number = @(string)filter_input(INPUT_POST, 'number', FILTER_SANITIZE_SPECIAL_CHARS);
$status = @(string)filter_input(INPUT_POST, 'status', FILTER_SANITIZE_SPECIAL_CHARS);

/** Validando os campos de entrada */
$ProductsVersionsValidate->setProductId($productId);
$ProductsVersionsReleasesValidate->setProductVersionReleaseId($productVersionReleaseId);
$ProductsVersionsReleasesValidate->setProductVersionId($productVersionId);
$ProductsVersionsReleasesValidate->setDescription($description);
$ProductsVersionsReleasesValidate->setNumber($number);
$ProductsVersionsReleasesValidate->setStatus($status);

/** Verifico a existência de erros */
if (!empty($ProductsVersionsReleasesValidate->getErrors())) {

    /** Caso ocorra algum erro, informo */
    throw new InvalidArgumentException($ProductsVersionsReleasesValidate->getErrors(), 0);

} else {

    /** Verifico se devo pegar o histórico já existente */
    if ($ProductsVersionsReleasesValidate->getProductVersionId() > 0) {

        /** Busco o registro desejado */
        $resultProductsVersionsReleases = $ProductsVersionsReleases->get($ProductsVersionsReleasesValidate->getProductVersionReleaseId());

        /** Defino o histórico do registro de mensagem */
        $ProductsVersionsReleasesValidate->setHistory($HistoryValidate->generate($resultProductsVersionsReleases->history, 'Release de Versão de Produto!', 'Alteração de Release de Versão de Produto', 'rounded-pill text-bg-warning', @(string)$_SESSION['USERSNAMEFIRST']));

    } else {

        /** Defino o histórico do registro de mensagem */
        $ProductsVersionsReleasesValidate->setHistory($HistoryValidate->generate(null, 'Release de Versão de Produto!', 'Cadastro de Release de Versão de Produto', 'rounded-pill text-bg-primary', @(string)$_SESSION['USERSNAMEFIRST']));

    }

    /** Efetua um novo cadastro ou salva os novos dados */
    if ($ProductsVersionsReleases->Save($ProductsVersionsReleasesValidate->getProductVersionReleaseId(), $ProductsVersionsReleasesValidate->getProductVersionId(), $ProductsVersionsReleasesValidate->getDescription(), $ProductsVersionsReleasesValidate->getNumber(), $ProductsVersionsReleasesValidate->getStatus(), $ProductsVersionsReleasesValidate->getHistory())) {

        $ProductsResult = $Products->Get($ProductsVersionsValidate->getProductId());

        /** Inicio a coleta de dados */
        ob_start();

        /** Inclusão do arquivo desejado */
        @include_once 'vendor/view/products_versions_releases/products_versions_releases_email.php';

        /** Prego a estrutura do arquivo */
        $html = ob_get_contents();

        /** Removo o arquivo incluido */
        ob_clean();

        $data = new stdClass();
        $data->email = 'suporte@softwiki.com.br';
        $data->name = 'Suporte';
        $subject = $ProductsVersionsReleasesValidate->getNumber() . '|' . $ProductsVersionsReleasesValidate->getProductVersionReleaseId() ===  0 ? 'Nova versão publicada' : 'Alteração na versão';

        $preferences = new stdClass();
        $preferences->email_host = 'mail.mysupport.com.br';
        $preferences->email_username = 'mysupport@mysupport.com.br';
        $preferences->email_password = '@Sun147oi';
        $preferences->email_description = 'MySupport | Gestor Empresarial';
        $preferences->email_port = '465';

        //$Mail->send($html, $data, $subject, $preferences);

        /** Result **/
        $result = [

            'code' => 200,
            'title' => 'Sucesso',
            'data' => $Main->generateAlertHtml('success', 'Atenção', 'Registro Salvo com sucesso'),
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
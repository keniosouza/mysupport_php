<?php

/** Importação de classes */
use \vendor\model\Products;
use \vendor\controller\products\ProductsValidate;
use \vendor\model\ProductsVersions;
use \vendor\controller\products_versions\ProductsVersionsValidate;

/** Instânciamento de classes */
$Products = new Products();
$ProductsValidate = new ProductsValidate();
$ProductsVersions = new ProductsVersions();
$ProductsVersionsValidate = new ProductsVersionsValidate();

/** Tratamento dos dados de entrada */
$ProductsValidate->setProductsId(@(int)filter_input(INPUT_POST, 'products_id', FILTER_SANITIZE_SPECIAL_CHARS));
$ProductsVersionsValidate->setProductVersionId(@(int)filter_input(INPUT_POST, 'product_version_id', FILTER_SANITIZE_SPECIAL_CHARS));

/** Busco o produto desejado */
$ProductGetResult = $Products->Get($ProductsValidate->getProductsId());

/** Busca de registro */
$ProductsVersionsAllResult = $ProductsVersions->All($ProductsValidate->getProductsId());

/** Verifico se existe registro */
if ($ProductsValidate->getProductsId() > 0 && $ProductsVersionsValidate->getProductVersionId() === 0) {

    /** Realizo a busca da ultima versão existente */
    $resultProductVersion = $ProductsVersions->GetLast($ProductsValidate->getProductsId());

    /** Definição de função */
    $resultProductVersion->delete = 'function_version_delete_' . md5(microtime());

}
else
{

    /** Busco a Versão do Produto Desejada */
    $resultProductVersion = $ProductsVersions->Get($ProductsVersionsValidate->getProductVersionId());

    /** Definição de função */
    $resultProductVersion->delete = 'function_version_delete_' . md5(microtime());

}

?>

<div class="col-md-12">

    <?php

    /** Verifico se existem registros */
    if ((int)$resultProductVersion->product_version_id > 0) { ?>

        <div class="card mb-2 animate slideIn">

            <div class="card-body">

               <h4 class="card-title cursor-pointer" id="ProductsEditButton" onclick="SendRequest('FOLDER=VIEW&TABLE=PRODUCTS&ACTION=PRODUCTS_FORM&products_id=<?php echo $ProductGetResult->products_id?>', {target : null, loader : {create: true, padding: '0px', type: 3, target : 'ProductsEditButton', data : 'Aguarde...'}});">

                   <i class="bi bi-pencil me-1"></i><?php echo $ProductGetResult->name?>

               </h4>

                <div class="row">

                    <div class="col my-auto">

                        <select name="product_version_id" id="product_version_id" class="form-control form-select form-control-solid" onchange="ChangeVersion()">

                            <?php

                            /** Consulta os usuário cadastrados*/
                            foreach ($ProductsVersionsAllResult as $key => $result) { ?>

                                <option value="<?php echo @(int)$result->product_version_id ?>" <?php echo @(int)$result->product_version_id === @(int)$resultProductVersion->product_version_id ? 'selected' : null?>>

                                    <?php echo @(string)$result->name ?> - <?php echo @(string)$result->number ?>

                                </option>

                            <?php } ?>

                        </select>

                    </div>

                    <div class="col my-auto text-end">

                        <div class="btn-group w-100">

                            <?php

                            /** Verificação de permissão */
                            if (@(string)$resultUserAcl->produtos_versoes->criar === 'true') { ?>

                                <a class="btn btn-primary" id="ProductsVersionForm" onclick="SendRequest('FOLDER=view&TABLE=PRODUCTS_VERSIONS&ACTION=PRODUCTS_VERSIONS_FORM&product_id=<?php echo $ProductsValidate->getProductsId()?>', {target : null, loader : {create: true, type: 3, target : 'ProductsVersionForm', data : 'Aguarde...'}});">

                                    <i class="bi bi-plus"></i>

                                </a>

                            <?php } ?>

                            <?php

                            /** Verificação de permissão */
                            if (@(string)$resultUserAcl->produtos_versoes->editar === 'true') { ?>

                                <a class="btn btn-primary" id="ProductsEditButton<?php echo @(int)$resultProductVersion->product_version_id; ?>" onclick="SendRequest('FOLDER=view&TABLE=products_versions&ACTION=products_versions_form&product_id=<?php echo @(int)$resultProductVersion->product_id; ?>&product_version_id=<?php echo @(int)$resultProductVersion->product_version_id; ?>', {target : null, loader : {create: true, type: 3, target : 'ProductsEditButton<?php echo @(int)$resultProductVersion->product_version_id; ?>', data : 'Aguarde...'}});">

                                    <i class="bi bi-pencil"></i>

                                </a>

                            <?php } ?>

                            <?php

                            /** Verificação de permissão */
                            if (@(string)$resultUserAcl->produtos_versoes->remover === 'true') {?>

                                <a class="btn btn-primary" id="ProductsRemoveButton<?php echo @(int)$resultProductVersion->product_version_id; ?>" onclick="modalConstruct(true, 'Deseja remover a versão?', '', 'md', null, null, 'question', <?php echo @(string)$resultProductVersion->delete ?>, null, null)">

                                    <i class="bi bi-fire"></i>

                                </a>

                                <script type="text/javascript">

                                    /** Carrega a função de logout */
                                    var <?php echo @(string)$resultProductVersion->delete?> = "SendRequest('FOLDER=ACTION&TABLE=products_versions&ACTION=products_versions_delete&product_id=<?php echo @(int)$resultProductVersion->product_id ?>&product_version_id=<?php echo @(int)$resultProductVersion->product_version_id ?>', {target : null, loader : {create: true, type: 3, target : 'ProductsRemoveButton<?php echo @(int)$resultProductVersion->product_version_id; ?>', data : 'Aguarde...'}});";

                                </script>

                            <?php } ?>

                            <a class="btn btn-primary" id="ProductsHistoryButton<?php echo @(int)$resultProductVersion->product_version_id; ?>" onclick="SendRequest('FOLDER=VIEW&TABLE=products_versions&ACTION=products_versions_history&product_version_id=<?php echo @(string)$resultProductVersion->product_version_id ?>', {target : null, loader : {create: true, type: 3, target : 'ProductsHistoryButton<?php echo @(int)$resultProductVersion->product_version_id; ?>', data : 'Aguarde...'}});">

                                <i class="bi bi-clock-history"></i>

                            </a>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <ul class="nav nav-pills nav-fill animate slideIn" id="pills-tab">

            <?php

            /** Verifico se a permissão */
            if (@(string)$resultUserAcl->produtos_versoes_releases->criar === 'true') { ?>

                <li class="nav-item me-1 mb-2 rounded border">

                    <a class="nav-link" id="ProductsReleaseFormButton<?php echo @(int)$resultProductVersion->product_version_id; ?>" onclick="SendRequest('FOLDER=VIEW&TABLE=products_versions_releases&ACTION=products_versions_releases_form&product_id=<?php echo (int)$ProductsValidate->getProductsId(); ?>&product_version_id=<?php echo (int)$resultProductVersion->product_version_id; ?>', {target : null, loader : {create: true, type: 3, target : 'ProductsReleaseFormButton<?php echo @(int)$resultProductVersion->product_version_id; ?>', data : 'Aguarde...'}});">

                        <i class="bi bi-plus me-1"></i>Realease

                    </a>

                </li>

            <?php } ?>

            <li class="nav-item me-1 mb-2 rounded border">

                <a class="nav-link active" id="pills-1-tab" data-bs-toggle="pill" href="#pills-1" aria-controls="pills-1" aria-selected="false">

                    <i class="bi bi-info me-1"></i>Desenvolvimento

                </a>

            </li>

            <li class="nav-item me-1 mb-2 rounded border">

                <a class="nav-link" id="pills-2-tab" data-bs-toggle="pill" href="#pills-2" aria-controls="pills-2">

                    <i class="bi bi-exclamation-lg me-1"></i>Homologação

                </a>

            </li>

            <li class="nav-item me-1 mb-2 rounded border">

                <a class="nav-link" id="pills-3-tab" data-bs-toggle="pill" href="#pills-3" aria-controls="pills-3" aria-selected="false">

                    <i class="bi bi-check me-1"></i>Produção

                </a>

            </li>

            <li class="nav-item mb-2 rounded border">

                <a class="nav-link" id="pills-4-tab" data-bs-toggle="pill" href="#pills-4" aria-controls="pills-4" aria-selected="false">

                    <i class="bi bi-x me-1"></i>Encerrada

                </a>

            </li>

        </ul>

        <div class="tab-content animate slideIn" id="myTabContent">

            <?php

            /** Listagem dos registros */
            for ($status = 1; $status <= 4; $status++) {?>

                <div class="tab-pane fade <?php echo $status == 1 ? 'show active' : null?>" id="pills-<?php echo $status?>" aria-labelledby="home-tab">

                    <script type="text/javascript">

                        /** Envio de Requisição */
                        SendRequest('FOLDER=VIEW&TABLE=PRODUCTS_VERSIONS_RELEASES&ACTION=PRODUCTS_VERSIONS_RELEASES_DATAGRID&PRODUCT_VERSION_ID=<?php echo $resultProductVersion->product_version_id?>&STATUS=<?php echo $status?>', {target : 'pills-<?php echo $status?>', loader : {create: true, padding: '0px', type: 2, target : 'pills-<?php echo $status?>', data : 'Aguarde...'}});

                    </script>

                </div>

            <?php }?>

        </div>

    <?php } else { ?>

        <div class="card animate slideIn">

            <div class="card-body text-center">

                <h1 class="card-title text-center">

                    <span class="badge rounded-pill text-bg-primary">

                        PV-1

                    </span>

                </h1>

                <h4 class="card-subtitle text-center text-muted">

                    Não foram localizados versões para este produto

                </h4>

            </div>

        </div>

    <?php } ?>

</div>

<script type="text/javascript">

    /** Seleção de versão antes do envio da requisição */
    function ChangeVersion() {

        /** Variaveis da função */
        var productVersionId = document.getElementById('product_version_id').value;

        /** Realizo a requisição da página */
        SendRequest('FOLDER=VIEW&TABLE=PRODUCTS&ACTION=PRODUCTS_DATAGRID_COL_2&products_id=<?php echo $ProductsValidate->getProductsId()?>&product_version_id=' + productVersionId, {target : 'ProdcutsDatagridItem', loader : {create: true, padding: '5px', type: 2, target : 'ProdcutsDatagridItem', data : 'Aguarde...'}});

    }

</script>

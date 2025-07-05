<?php

/** Importação de classes */
use \vendor\model\Files;
use \vendor\model\ProductsVersionsReleases;
use \vendor\controller\products_versions_releases\ProductsVersionsReleasesValidate;

/** Instânciamento de classes */
$Files = new Files();
$ProductsVersionsReleases = new ProductsVersionsReleases();
$ProductsVersionsReleasesValidate = new ProductsVersionsReleasesValidate();

/** Tratamento dos dados de entrada */
$ProductsVersionsReleasesValidate->setProductVersionId(@(int)filter_input(INPUT_POST, 'PRODUCT_VERSION_ID', FILTER_SANITIZE_SPECIAL_CHARS));
$ProductsVersionsReleasesValidate->setStatus(@(int)filter_input(INPUT_POST, 'STATUS', FILTER_SANITIZE_SPECIAL_CHARS));

/** Listo os registros vinculados */
$resultProductsVersionsReleases = $ProductsVersionsReleases->All($ProductsVersionsReleasesValidate->getProductVersionId(), $ProductsVersionsReleasesValidate->getStatus());

/** Verifico se existem registros */
if (@(int)count($resultProductsVersionsReleases) > 0) { ?>

    <?php

    /** Consulta os usuário cadastrados*/
    foreach ($resultProductsVersionsReleases as $keyProductsVersionsReleases => $resultReleases) {

        /** Arquivos vinculados a release */
        $resultReleases->files = $Files->All((int)$resultReleases->product_version_release_id, 'products_versions_releases');

        /** Defino o nome da função */
        $resultReleases->delete = 'function_delete_product_versions_releases_' . md5(microtime());

        /** Classe CSS */
        $resultReleases->classBorder = null;

        /** Verifico a situação */
        switch ($resultReleases->status) {

            /** Desenvolvimento */
            case 1:

                $resultReleases->classBorder = 'primary';
                break;

            /** Homologação */
            case 2:

                $resultReleases->classBorder = 'warning';
                break;

            /** Produção */
            case 3:

                $resultReleases->classBorder = 'success';
                break;

            /** Encerrado */
            case 4:

                $resultReleases->classBorder = 'dark';
                break;

        }

        ?>

        <div class="card mb-1 animate slideIn" id="ProductVersionReleaseItem<?php echo $resultReleases->product_version_release_id?>">

            <div class="card-body">

                <div class="row g-2">

                    <div class="col-md my-auto">

                        Release: <b><?php echo @(string)$resultReleases->number ?></b>

                    </div>

                    <div class="col-md my-auto text-end">

                        <div class="btn-group w-100">

                            <?php

                            /** Verifico se a permissão */
                            if (@(string)$resultUserAcl->produtos_versoes_releases->editar === 'true') { ?>

                                <a class="btn btn-primary" id="ProductVersionReleaseEditButton<?php echo $resultReleases->product_version_release_id?>" onclick="SendRequest('FOLDER=VIEW&TABLE=products_versions_releases&ACTION=products_versions_releases_form&product_id=<?php echo @(int)$resultReleases->product_id ?>&product_version_id=<?php echo @(int)$resultReleases->product_version_id ?>&product_version_release_id=<?php echo @(int)$resultReleases->product_version_release_id ?>', {target : null, loader : {create: true, padding: '0px', type: 3, target : 'ProductVersionReleaseEditButton<?php echo $resultReleases->product_version_release_id?>', data : 'Aguarde...'}});">

                                    <i class="bi bi-pencil me-1"></i>Editar

                                </a>

                            <?php } ?>

                            <?php

                            /** Verifico a situação */
                            if (@(int)$resultReleases->status !== 4) { ?>

                                <?php

                                /** Verifico se a permissão */
                                if (@(string)$resultUserAcl->produtos_versoes_releases_files->criar === 'true') { ?>

                                    <a class="btn btn-primary" id="ProductVersionReleaseFilesButton<?php echo $resultReleases->product_version_release_id?>" onclick="SendRequest('FOLDER=VIEW&TABLE=products_versions_releases_files&ACTION=products_versions_releases_files_form&product_id=<?php echo @(int)$resultReleases->product_id?>&product_version_id=<?php echo @(int)$resultReleases->product_version_id?>&product_version_release_id=<?php echo @(int)$resultReleases->product_version_release_id?>', {target : null, loader : {create: true, padding: '0px', type: 3, target : 'ProductVersionReleaseFilesButton<?php echo $resultReleases->product_version_release_id?>', data : 'Aguarde...'}});">

                                        <i class="bi bi-plus me-1"></i>Arquivos

                                    </a>

                                <?php } ?>

                                <?php

                                /** Verifico se a permissão */
                                if (@(string)$resultUserAcl->produtos_versoes_releases->remover === 'true') { ?>

                                    <a class="btn btn-primary" id="ProductVersionReleaseRemoveButton<?php echo $resultReleases->product_version_release_id?>" onclick="modalConstruct(true, 'Deseja remover a atividade?', '', 'md', null, null, 'question', <?php echo @(string)$resultReleases->delete ?>, null, null)">

                                        <i class="bi bi-fire me-1"></i>Remover

                                    </a>

                                    <script type="text/javascript">

                                        /** Carrega a função de logout */
                                        var <?php echo @(string)$resultReleases->delete?> = "SendRequest('FOLDER=ACTION&TABLE=products_versions_releases&ACTION=products_versions_releases_delete&product_version_release_id=<?php echo @(int)$resultReleases->product_version_release_id?>', {target : null, loader : {create: true, padding: '0px', type: 3, target : 'ProductVersionReleaseRemoveButton<?php echo $resultReleases->product_version_release_id?>', data : 'Aguarde...'}});";

                                    </script>

                                <?php } ?>

                            <?php } ?>

                            <a class="btn btn-primary" id="ProductVersionReleaseHistoryButton<?php echo $resultReleases->product_version_release_id?>" onclick="SendRequest('FOLDER=VIEW&TABLE=products_versions_releases&ACTION=products_versions_releases_history&product_id=<?php echo @(int)$resultProduct->products_id; ?>&product_version_id=<?php echo @(string)$resultReleases->product_version_id ?>&product_version_release_id=<?php echo @(string)$resultReleases->product_version_release_id ?>', {target : null, loader : {create: true, padding: '0px', type: 3, target : 'ProductVersionReleaseHistoryButton<?php echo $resultReleases->product_version_release_id?>', data : 'Aguarde...'}});">

                                <i class="bi bi-clock-history me-1"></i>Histórico

                            </a>

                        </div>

                    </div>

                    <div class="col-md-12">

                        <div class="card bg-light">

                            <div class="card-body">

                                <?php echo @(string)$resultReleases->description ?>

                            </div>

                        </div>

                    </div>

                    <div class="col-md-12">

                        <div id="ProductVersionRelease<?php echo $resultReleases->product_version_release_id?>">

                            <button class="btn btn-primary w-100" id="ProductVersionReleaseFilesListButton<?php echo $resultReleases->product_version_release_id?>" onclick="SendRequest('FOLDER=VIEW&TABLE=PRODUCTS_VERSIONS_RELEASES_FILES&ACTION=PRODUCTS_VERSIONS_RELEASES_FILES_DATAGRID&PRODUCT_VERSION_RELEASE_ID=<?php echo $resultReleases->product_version_release_id?>', {target : 'ProductVersionRelease<?php echo $resultReleases->product_version_release_id?>', loader : {create: true, padding: '0px', type: 3, target : 'ProductVersionReleaseFilesListButton<?php echo $resultReleases->product_version_release_id?>', data : 'Aguarde...'}});">

                                <i class="bi bi-file-earmark-text-fill me-1"></i>Exibir Arquivos

                            </button>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    <?php } ?>

<?php }else{ ?>

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

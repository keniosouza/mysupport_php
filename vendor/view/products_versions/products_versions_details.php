<?php

/** Importação de classes  */
use vendor\controller\main\Main;
use vendor\model\Files;
use vendor\model\ProductsVersions;
use vendor\controller\products_versions\ProductsVersionsValidate;
use vendor\model\ProductsVersionsReleases;
use vendor\controller\products_versions_releases\ProductsVersionsReleasesValidate;

/** Instânciamento de classes  */
$Main = new Main();
$Files = new Files();
$ProductsVersions = new ProductsVersions();
$ProductsVersionsValidate = new ProductsVersionsValidate();
$ProductsVersionsReleases = new ProductsVersionsReleases();
$ProductsVersionsReleasesValidate = new ProductsVersionsReleasesValidate();

/** Parametros de entrada */
$ProductsVersionsValidate->setProductId(@(int)filter_input(INPUT_POST, 'product_id', FILTER_SANITIZE_SPECIAL_CHARS));
$ProductsVersionsReleasesValidate->setProductVersionId(@(int)filter_input(INPUT_POST, 'product_version_id', FILTER_SANITIZE_SPECIAL_CHARS));

/** Verifica se o ID do projeto foi informado */
if ($ProductsVersionsReleasesValidate->getProductVersionId() > 0) {

    /** Consulta os dados do controle de acesso */
    $resultProductsVersionsReleases = $ProductsVersionsReleases->All($ProductsVersionsReleasesValidate->getProductVersionId());

} ?>

<div class="col-md-6 fadeIn">

    <h5 class="card-title">

        <b>

            <i class="fas fa-box me-1"></i>

            Produtos

        </b>

        /Versões/Detalhes/

        <button type="button" class="btn btn-primary btn-sm mb-0" onclick="request('FOLDER=VIEW&TABLE=products&ACTION=products_details&products_id=<?php echo (int)$ProductsVersionsValidate->getProductId(); ?>', '#loadContent', true, '', '', '', 'Preparando formulário', 'blue', 'circle', 'sm', true)">

            <i class="bi bi-arrow-left-short me-1"></i>Voltar

        </button>

    </h5>

</div>

<?php

/** Verifico se a permissão */
if (@(string)$resultUserAcl->produtos_versoes_releases->criar === 'true') { ?>

    <div class="col-md-6 text-end fadeIn">

        <button type="button" class="btn btn-primary btn-sm" onclick="request('FOLDER=VIEW&TABLE=products_versions_releases&ACTION=products_versions_releases_form&product_id=<?php echo (int)$ProductsVersionsValidate->getProductId(); ?>&product_version_id=<?php echo (int)$ProductsVersionsReleasesValidate->getProductVersionId(); ?>', '#loadContent', true, '', '', '', 'Preparando formulário', 'blue', 'circle', 'sm', true)">

            <i class="bi bi-plus me-1"></i>Novo

        </button>

    </div>

<?php } ?>

<div class="col-md-12">

    <div class="card animate slideIn">

        <div class="card-body">

            <?php

            /** Verifico se existem registros */
            if (@(int)count($resultProductsVersionsReleases) > 0) { ?>

                <?php

                /** Consulta os usuário cadastrados*/
                foreach ($resultProductsVersionsReleases as $keyProductsVersionsReleases => $result) {

                    /** Crio o nome da função */
                    $function = 'function_delete_products_versions_releases_' . md5(@(int)$keyProductsVersionsReleases . '_' . rand(1, 1000));
                    $functionGerarLink = 'function_gerar_link' . md5(microtime());

                    /** Classe CSS */
                    $classBorder = null;

                    /** Verifico a situação */
                    switch ($result->status) {

                        /** Desenvolvimento */
                        case 1:

                            $classBorder = 'border-primary';
                            break;

                        /** Homologação */
                        case 2:

                            $classBorder = 'border-warning';
                            break;

                        /** Produção */
                        case 3:

                            $classBorder = 'border-success';
                            break;

                        /** Encerrado */
                        case 4:

                            $classBorder = 'border-dark';
                            break;

                    }

                    ?>

                    <div class="card shadow-sm  <?php echo @(string)$classBorder ?>">

                        <div class="card-body">

                            <div class="card shadow-sm bg-gray ">

                                <div class="card-body">

                                    <div class="row grid-divider">

                                        <div class="col-md">

                                            <h6 class="mt-0 mb-0">

                                                Release:

                                            </h6>

                                            <h6>

                                                <b>

                                                    <?php echo @(string)$result->number ?>

                                                </b>

                                            </h6>

                                        </div>

                                        <div class="col-md">

                                            <h6 class="mt-0 mb-0">

                                                Status:

                                            </h6>

                                            <h6>

                                                <b>

                                                    <?php

                                                    /** Verifico a situação */
                                                    switch ($result->status) {

                                                        /** Desenvolvimento */
                                                        case 1:

                                                            echo 'Desenvolvimento';
                                                            break;

                                                        /** Homologação */
                                                        case 2:

                                                            echo 'Homologação';
                                                            break;

                                                        /** Produção */
                                                        case 3:

                                                            echo 'Produção';
                                                            break;

                                                        /** Encerrado */
                                                        case 4:

                                                            echo 'Encerrado';
                                                            break;

                                                    }

                                                    ?>

                                                </b>

                                            </h6>

                                        </div>

                                    </div>

                                </div>

                            </div>

                            <div class="card-text my-3 bg-light p-3 rounded shadow-sm border" style="overflow-y: scroll; max-height: 400px">

                                <?php echo @(string)$result->description ?>

                            </div>

                            <div class="row">

                                <?php

                                /** Verifico se a permissão */
                                if (@(string)$resultUserAcl->produtos_versoes_releases->editar === 'true') { ?>

                                    <div class="col-md">

                                        <button class="btn btn-warning w-100" type="button" onclick="request('FOLDER=VIEW&TABLE=products_versions_releases&ACTION=products_versions_releases_form&product_id=<?php echo (int)$ProductsVersionsValidate->getProductId(); ?>&product_version_id=<?php echo (int)$ProductsVersionsReleasesValidate->getProductVersionId(); ?>&product_version_release_id=<?php echo (int)$result->product_version_release_id; ?>', '#loadContent', true, '', '', '', 'Preparando formulário', 'blue', 'circle', 'sm', true)">

                                            <i class="bi bi-pencil me-1"></i>Editar

                                        </button>

                                    </div>

                                <?php } ?>

                                <?php

                                /** Verifico se a permissão */
                                if (@(string)$resultUserAcl->produtos_versoes_releases_files->criar === 'true') { ?>

                                    <?php

                                    /** Verifico a situação */
                                    if (@(int)$result->status !== 4) { ?>

                                        <div class="col-md">

                                            <button class="btn btn-primary w-100" type="button" onclick="request('FOLDER=VIEW&TABLE=products_versions_releases_files&ACTION=products_versions_releases_files_form&product_id=<?php echo (int)$ProductsVersionsValidate->getProductId(); ?>&product_version_id=<?php echo (int)$ProductsVersionsReleasesValidate->getProductVersionId(); ?>&product_version_release_id=<?php echo (int)$result->product_version_release_id; ?>', '#loadContent', true, '', '', '', 'Preparando formulário', 'blue', 'circle', 'sm', true)">

                                                <i class="far fa-file-archive me-1"></i>Vincular Arquivos

                                            </button>

                                        </div>

                                    <?php } ?>

                                <?php } ?>

                                <?php

                                /** Verifico se a permissão */
                                if (@(string)$resultUserAcl->produtos_versoes_releases->gerar_link === 'true') { ?>

                                    <div class="col-md">

                                        <button class="btn btn-primary w-100" type="button" onclick="modalPage(true, 840, 0, 'Atenção', <?php echo $functionGerarLink ?>, '', '', '', '', 0)">

                                            <i class="fas fa-link me-1"></i>Gerar Link

                                        </button>

                                        <script type="text/javascript">

                                            let <?php echo $functionGerarLink ?> = '<form id="formCallsActivitiesUsersClose" role="form">';
                                                <?php echo $functionGerarLink ?> += '   <div class="card">';
                                                <?php echo $functionGerarLink ?> += '       <div class="card-body">';
                                                <?php echo $functionGerarLink ?> += '           <div class="card-text">';
                                                <?php echo $functionGerarLink ?> += '              https://mysupport.softwiki.com.br/download/release/<?php echo $Main->encryptData(@(string)$result->product_version_release_id)?>';
                                                <?php echo $functionGerarLink ?> += '           </div>';
                                                <?php echo $functionGerarLink ?> += '       </div>';
                                                <?php echo $functionGerarLink ?> += '   </div>';
                                                <?php echo $functionGerarLink ?> += '</form>';

                                        </script>

                                    </div>

                                <?php } ?>

                                <?php

                                /** Verifico se a permissão */
                                if (@(string)$resultUserAcl->produtos_versoes_releases->remover === 'true') { ?>

                                    <?php

                                    /** Verifico a situação */
                                    if (@(int)$result->status !== 4) { ?>

                                        <div class="col-md">

                                            <button class="btn btn-danger-soft w-100" type="button" onclick="modalPage(true, 0, 0, 'Atenção', 'Deseja realmente remover o registro?', '', 'question', <?php echo @(string)$function ?>)">

                                                <i class="bi bi-fire me-1"></i>Remover

                                            </button>

                                        </div>

                                        <script type="text/javascript">

                                            /** Carrega a função de logout */
                                            let <?php echo @(string)$function?> = "request('FOLDER=ACTION&TABLE=products_versions_releases&ACTION=products_versions_releases_delete&product_id=<?php echo @(int)$ProductsVersionsValidate->getProductId()?>&product_version_id=<?php echo @(int)$ProductsVersionsReleasesValidate->getProductVersionId()?>&product_version_release_id=<?php echo @(int)$result->product_version_release_id?>', '', true, '', 0, '', 'Removendo cliente', 'yellow', 'circle', 'sm', true)";

                                        </script>

                                    <?php } ?>

                                <?php } ?>

                            </div>

                            <?php

                            /** Busco os arquivos vinculados */
                            $resultProductsVersionsReleasesFiles = $Files->All((int)$result->product_version_release_id, 'products_versions_releases');

                            /** Verifico a situação */
                            if (count($resultProductsVersionsReleasesFiles) > 0) { ?>

                                <h6 class="card-title text-muted ">

                                    <i class="fas fa-info me-1"></i>Arquivos

                                </h6>

                                <div class="row ">

                                    <?php

                                    /** Consulta os usuário cadastrados*/
                                    foreach ($resultProductsVersionsReleasesFiles as $keyProductsVersionsReleasesFiles => $resultFiles) {

                                        /** Crio o nome da função */
                                        $function = 'function_delete_products_versions_releases_files_' . md5(microtime());

                                        ?>

                                        <div class="col-md-3  d-flex">

                                            <div class="card bg-light text-black shadow-sm w-100">

                                                <div class="card-body">

                                                    <?php echo @(string)$resultFiles->name ?>

                                                </div>

                                                <div class="card-footer border-0">

                                                    <div class="row">

                                                        <?php

                                                        /** Verifico se a permissão */
                                                        if (@(string)$resultUserAcl->produtos_versoes_releases_files->remover === 'true') { ?>

                                                            <?php

                                                            /** Verifico a situação */
                                                            if (@(int)$result->status !== 4) { ?>

                                                                <div class="col-md">

                                                                    <button class="btn btn-danger-soft w-100" type="button" onclick="modalPage(true, 0, 0, 'Atenção', 'Deseja realmente remover o registro?', '', 'question', <?php echo @(string)$function ?>)">

                                                                        <i class="bi bi-fire me-1"></i>Remover

                                                                    </button>

                                                                    <script type="text/javascript">

                                                                        /** Carrega a função de logout */
                                                                        let <?php echo @(string)$function?> = "request('FOLDER=ACTION&TABLE=products_versions_releases_files&ACTION=products_versions_releases_files_delete&product_id=<?php echo (int)$ProductsVersionsValidate->getProductId(); ?>&product_version_id=<?php echo (int)$ProductsVersionsReleasesValidate->getProductVersionId(); ?>&product_version_release_file_id=<?php echo (int)$resultFiles->file_id; ?>', '', true, '', 0, '', 'Removendo cliente', 'yellow', 'circle', 'sm', true)";

                                                                    </script>

                                                                </div>

                                                            <?php } ?>

                                                        <?php } ?>


                                                        <div class="col-md">

                                                            <a class="btn btn-primary w-100" type="button" href="<?php echo @(string)$resultFiles->path ?>/<?php echo @(string)$resultFiles->name ?>" download="<?php echo @(string)$resultFiles->name ?>" target="_blank">

                                                                <i class="bi bi-cloud-arrow-down-fill me-1"></i>Downlaod

                                                            </a>

                                                        </div>

                                                    </div>

                                                </div>

                                            </div>

                                        </div>

                                    <?php } ?>

                                </div>

                            <?php } ?>

                        </div>

                    </div>

                <?php } ?>

            <?php } else { ?>

                <div class="card shadow-sm mt-2 bg-light">

                    <div class="card-body text-center">

                        <img src="img/emptybox.png" class="img-fluid " width="300px" alt="">

                        <div class="row">

                            <div class="col-md-6 mx-auto">

                                <h2 class="card-title text-center text-muted">

                                    <b>

                                        Não foram localizados releases para esta versão

                                    </b>

                                </h2>

                            </div>

                        </div>

                    </div>

                </div>

            <?php } ?>

        </div>

    </div>

</div>
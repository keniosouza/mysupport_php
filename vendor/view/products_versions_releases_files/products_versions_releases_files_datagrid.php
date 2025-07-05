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
$ProductsVersionsReleasesValidate->setProductVersionReleaseId(@(int)filter_input(INPUT_POST, 'PRODUCT_VERSION_RELEASE_ID', FILTER_SANITIZE_SPECIAL_CHARS));

/** Arquivos vinculados a release */
$ResultProductsVersionsReleasesFiles = $Files->All((int)$ProductsVersionsReleasesValidate->getProductVersionReleaseId(), 'products_versions_releases');

/** Registro desejado */
$ResultProductsVersionsReleases = $ProductsVersionsReleases->Get($ProductsVersionsReleasesValidate->getProductVersionReleaseId());

?>

<?php

/** Verifico se existem arquivos vinculados */
if (count($ResultProductsVersionsReleasesFiles) > 0) { ?>

    <div class="row g-2 animate slideIn">

        <?php

        /** Consulta os usuário cadastrados*/
        foreach ($ResultProductsVersionsReleasesFiles as $keyFiles => $resultFiles) {

            /** Obtenho a extensão do arquivo */
            $resultFiles->icon = 'image/default/files/' . pathinfo($resultFiles->name, PATHINFO_EXTENSION) . '.png';

            /** Verifico se o icone existe */
            $resultFiles->icon = file_exists($resultFiles->icon) ? $resultFiles->icon : 'image/default/files/default.png';

            /** Crio o nome da função */
            $resultFiles->delete = 'function_delete_products_versions_releases_files_' . md5(microtime());

            ?>

            <div class="col-md-3 d-flex">

                <div class="card text-black w-100">

                    <div class="card-body">

                        <h6 class="card-title">

                            <?php echo $resultFiles->name?>

                        </h6>

                        <div class="d-flex align-items-center">

                            <div class="flex-shrink-0">

                                <img src="<?php echo $resultFiles->icon ?>" alt="<?php echo $resultFiles->name ?>" width="50px">

                            </div>

                            <div class="flex-grow-1 ms-3 text-break">

                                <?php

                                /** Verifico a situação */
                                if (!empty(@(int)$ResultProductsVersionsReleases->status)) { ?>

                                    <div class="btn-group w-100 text-break ">

                                        <a class="btn btn-primary" href="<?php echo @(string)$resultFiles->path ?>/<?php echo @(string)$resultFiles->name ?>" download="<?php echo @(string)$resultFiles->name ?>" target="_blank">

                                            <i class="bi bi-cloud-arrow-down-fill me-1"></i>Download

                                        </a>

                                        <?php

                                        /** Verifico se a permissão */
                                        if (@(string)$resultUserAcl->produtos_versoes_releases_files->remover === 'true') { ?>

                                            <?php

                                            /** Verifico a situação */
                                            if (@(int)$ResultProductsVersionsReleases->status !== 4) { ?>

                                                <a class="btn btn-primary" onclick="modalConstruct(true, 'Deseja remover o arquivo?', '', 'md', null, null, 'question', <?php echo @(string)$resultFiles->delete ?>, null, null)">

                                                    <i class="bi bi-fire me-1"></i>Remover

                                                </a>

                                                <script type="text/javascript">

                                                    /** Carrega a função de logout */
                                                    var <?php echo @(string)$resultFiles->delete?> = "SendRequest('FOLDER=ACTION&TABLE=products_versions_releases_files&ACTION=products_versions_releases_files_delete&product_id=<?php echo @(int)$ResultProductsVersionsReleases->product_id?>&product_version_id=<?php echo @(int)$ResultProductsVersionsReleases->product_version_id?>&product_version_release_file_id=<?php echo (int)$resultFiles->file_id; ?>', {target : null, block : {create : true, info : null, sec : null, target : null, data : 'Aguarde', color : 'blue', type : 'circle', size : 'sm', message : true}});";

                                                </script>

                                            <?php } ?>

                                        <?php } ?>

                                    </div>

                                <?php } ?>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        <?php } ?>

    </div>

<?php }else{ ?>

    <div class="card">

        <div class="card-body text-center">

            <h1 class="card-title text-center">

                <span class="badge rounded-pill text-bg-primary">

                    PVRF-1

                </span>

            </h1>

            <h4 class="card-subtitle text-center text-muted">

                Não há aquivos vinculados

            </h4>

        </div>

    </div>

<?php } ?>
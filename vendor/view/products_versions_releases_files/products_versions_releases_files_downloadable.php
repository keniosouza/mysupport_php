<?php

/** Importação de classes */
use vendor\model\ProductsVersionsReleases;

/** Instânciamento de classes */
$ProductsVersionsReleases = new ProductsVersionsReleases();

/** Consulta os usuário cadastrados*/
$ProductsVersionsReleasesAllDownloadableResult = $ProductsVersionsReleases->AllDownloadable(@(int)$_SESSION['USERSCOMPANYID']);?>

<h6>

    Versões para Download

</h6>


<div class="row g-1">

    <?php

    /** Listo todos os registros de produtos */
    foreach ($ProductsVersionsReleasesAllDownloadableResult as $key => $result) {

        /** Verifico se o icone existe */
        $result->icon = 'image/default/files/default.png';

        /** Verifico o status da versão */
        switch ($result->status){

            /** Versão em Desenvolvimento */
            case 1:

                $result->css = 'primary';
                $result->phrase = 'Desenvolvimento';
                break;

            /** Versão em Homologação */
            case 2:

                $result->css = 'warning';
                $result->phrase = 'Homologação';
                break;

            /** Versão em Produção */
            case 3:

                $result->css = 'success';
                $result->phrase = 'Produção';
                break;

            /** Versão Encerrada */
            case 4:

                $result->css = 'dark';
                $result->phrase = 'Encerrado';
                break;

        }

        ?>

        <div class="col-md-4 d-flex">

            <div class="card mb-1 animate slideIn w-100">

                <div class="card-body">

                    <div class="d-flex align-items-center">

                        <h6 class="text-break">

                        <span class="badge rounded-pill bg-<?php echo @(string)$result->css ?>">

                            <?php echo @(string)$result->phrase ?>

                        </span>

                        -

                        <?php echo @(string)$result->number_version ?>.<?php echo @(string)$result->number_release ?>

                        -

                        <?php echo @(string)$result->name ?>

                        </h6>

                    </div>

                </div>

                <div class="card-footer border-0 bg-transparent">

                    <input type="hidden" value="<?php echo $resultConfig->app->url_aplication ?>download/release/<?php echo base64_encode(@(int)$result->product_version_release_id) ?>" id="<?php echo @(int)$key; ?>">

                    <a class="btn btn-primary w-100 btn-sm" type="button" onclick="copyContentToClipboard(<?php echo @(int)$key; ?>)">

                        <i class="bi bi-link me-1"></i>Link

                    </a>

                </div>

            </div>

        </div>

    <?php }?>

</div>
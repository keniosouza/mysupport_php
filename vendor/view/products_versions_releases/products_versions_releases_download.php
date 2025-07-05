<?php

/** Importação de classes */
use vendor\model\Files;
use vendor\model\ProductsVersionsReleases;
use vendor\controller\products_versions_releases\ProductsVersionsReleasesValidate;

/** Instânciamento de classes */
$Files = new Files;
$ProductsVersionsReleases = new ProductsVersionsReleases;
$ProductsVersionsReleasesValidate = new ProductsVersionsReleasesValidate;

/** Paramedtros de entrada */
$token = @(string)filter_input(INPUT_POST, 'TOKEN', FILTER_SANITIZE_SPECIAL_CHARS);

/** Verifico se o o TOKEN foi preenchido */
if (!empty($token)) {

    /** Pasta Aleatório */
    $path = 'temp/download_' . md5(microtime());

    /** Descriptografia do TOKEN */
    $token = base64_decode($token);

    /** Busco o registro desejado */
    $resultProductsVersionsReleases = $ProductsVersionsReleases->Load($token);

    /** Verifico se deve manipular os arquivos
     * Código 3 -> Homologação
     * Código 4 -> Produção
     */
    if ((int)$resultProductsVersionsReleases->status === 2 || (int)$resultProductsVersionsReleases->status === 3) {

        /** Listo todos os arquivos */
        $resultFiles = $Files->All((int)$token, 'products_versions_releases');

        /** Crio a pasta para copia de arquivo */
        mkdir($path, 0777, true);

        /** Movo todos os meus arquivos para uma pasta temporária */
        foreach ($resultFiles as $keyProductsVersionsReleasesFiles => $result) {

            /** Copia dos arquivos para pasta temporária */
            copy($result->path . '/' . $result->name, $path . '/' . $result->name);

        }

    }

    /** Defino a classe CSS */
    $classCSS = null;

    /** Verifico o tipo de STATUS */
    switch ((int)$resultProductsVersionsReleases->status) {

        /** Desenvolvimento */
        case 1:

            /** Informativo */
            $classCSS = 'primary';
            break;

        /** Homologação */
        case 2:

            /** Atenção */
            $classCSS = 'warning';
            break;

        /** Produção */
        case 3:

            /** Sucesso */
            $classCSS = 'success';
            break;

        /** Encerrada */
        case 4:

            /** Fim */
            $classCSS = 'dark';
            break;

    }

}

?>

<div class="col-md-9 mx-auto">

    <div class="card shadow-sm my-3 animate slideIn border-<?php echo @(string)$classCSS ?>">

        <div class="card-body">

            <?php

            /** Verifico o tipo de STATUS */
            if ($resultProductsVersionsReleases->product_version_release_id > 0){?>

                <h5 class="card-title mb-2">

                    <b>

                        Donwnload de Versão

                    </b>

                </h5>

                <div class="card mb-3">

                    <div class="card-body">

                        <h5 class="mt-0">

                            <b class="badge bg-<?php echo @(string)$classCSS ?>">

                                <?php

                                /** Verifico o tipo de STATUS */
                                switch ((int)$resultProductsVersionsReleases->status) {

                                    /** Desenvolvimento */
                                    case 1:

                                        /** Informativo */
                                        echo 'Desenvolvimento';
                                        break;

                                    /** Homologação */
                                    case 2:

                                        /** Atenção */
                                        echo 'Homologação';
                                        break;

                                    /** Produção */
                                    case 3:

                                        /** Sucesso */
                                        echo 'Produção';
                                        break;

                                    /** Encerrada */
                                    case 4:

                                        /** Fim */
                                        echo 'Encerrado';
                                        break;

                                }

                                ?>

                            </b>

                            -

                            <?php echo @(string)$resultProductsVersionsReleases->name ?>

                        </h5>

                        <h6 class="mt-0">

                            <b>

                                <?php echo @(string)$resultProductsVersionsReleases->number ?>.<?php echo @(string)$resultProductsVersionsReleases->number_release ?>

                            </b>

                        </h6>

                    </div>

                </div>

                <div class="card-text border rounded p-3 mb-3" style="overflow-y: scroll; max-height: 350px">

                    <?php echo @(string)$resultProductsVersionsReleases->description_release ?>

                </div>

                <?php

                /** Defino a palavra */
                $word = null;

                /** Verifico o tipo de STATUS */
                switch ((int)$resultProductsVersionsReleases->status) {

                    /** Desenvolvimento */
                    case 1:

                        /** Informativo */
                        $word = 'em Desenvolvimento';
                        break;

                    /** Desenvolvimento */
                    case 2:

                        /** Informativo */
                        $word = 'em Homologação';
                        break;

                    /** Encerrada */
                    case 4:

                        /** Fim */
                        $word = 'Encerrada';
                        break;

                }

                /** Verifica se pode fazer downlod */
                if ((int)$resultProductsVersionsReleases->status === 1 || (int)$resultProductsVersionsReleases->status === 2 || (int)$resultProductsVersionsReleases->status === 4) { ?>

                    <div class="alert alert-<?php echo @(string)$classCSS ?> mb-3">

                        <h4 class="alert-heading">

                            Atenção! Versão <b><?php echo @(string)$word ?></b>

                        </h4>

                        <p>

                            <?php

                            /** Verifica se pode fazer downlod */
                            if ((int)$resultProductsVersionsReleases->status === 1 || (int)$resultProductsVersionsReleases->status === 4) { ?>

                                A versão não se encontra disponível para download, pois, o mesmo está com o andamento <b><?php echo @(string)$word ?></b>

                            <?php } elseif ((int)$resultProductsVersionsReleases->status === 2) { ?>

                                A versão encontra-se <b><?php echo @(string)$word ?></b>, algumas funcionalidades podem não estar funcionando corretamente!

                            <?php } ?>

                        </p>

                    </div>

                <?php } ?>

                <?php

                /** Verifica se pode fazer downlod */
                if ((int)$resultProductsVersionsReleases->status === 2 || (int)$resultProductsVersionsReleases->status === 3) { ?>

                    <div class="row g-1">

                        <?php

                        /** Consulta os usuário cadastrados*/
                        foreach ($resultFiles as $keyProductsVersionsReleasesFiles => $result) { ?>

                            <div class="col-md-3 d-flex">

                                <div class="card bg-light text-black w-100">

                                    <div class="card-body">

                                        <?php echo @(string)$result->name ?>

                                    </div>

                                    <div class="card-footer border-0">

                                        <a class="btn btn-primary w-100" type="button" href="<?php echo @(string)$path ?>/<?php echo @(string)$result->name ?>" download="<?php echo @(string)$result->name ?>" target="_blank" onclick="SendRequest('ProductsVersionsReleasesDownload', {target : null, block : {create : true, info : null, sec : null, target : null, data : 'Aguarde...', color : 'blue', type : 'circle', size : 'sm', message : true}});">

                                            <i class="bi bi-cloud-arrow-down-fill me-1"></i>Donwload

                                        </a>

                                    </div>

                                </div>

                            </div>

                        <?php } ?>

                    </div>

                <?php } ?>

                <form id="ProductsVersionsReleasesDownload">

                    <input type="hidden" name="product_version_release_id" value="<?php echo @(int)$resultProductsVersionsReleases->product_version_release_id ?>"/>
                    <input type="hidden" name="FOLDER" value="ACTION"/>
                    <input type="hidden" name="TABLE" value="products_versions_releases"/>
                    <input type="hidden" name="ACTION" value="products_versions_releases_download"/>

                </form>

            <?php }else{?>

                <div class="alert alert-danger" role="alert">

                    <h4 class="alert-heading">

                        Atenção

                    </h4>

                    <p>

                        O link informado é inválido, por favor entrar em contato com o fornecedor

                    </p>

                </div>

            <?php }?>

        </div>

    </div>

</div>
<?php

/** Importação de classes */
use vendor\model\Files;

/** Instânciamento de classes */
$Files = new Files();

/** Consulta os usuário cadastrados*/
$FilesAllNoFilteredResult = $Files->AllLast(20);

?>

<div class="row g-1">

    <?php

    /** Listo todos os registros de produtos */
    foreach ($FilesAllNoFilteredResult as $key => $result) {

        /** Obtenho a extensão do arquivo */
        $result->icon = 'image/default/files/' . pathinfo($result->name, PATHINFO_EXTENSION) . '.png';

        /** Verifico se o icone existe */
        $result->icon = file_exists($result->icon) ? $result->icon : 'image/default/files/default.png';

        ?>

        <div class="col-md-4 d-flex">

            <div class="card w-100">

                <div class="card-body">

                    <h6 class="card-title">

                        <?php echo $result->name?>

                    </h6>

                </div>

                <div class="card-footer border-0 bg-transparent">

                    <div class="d-flex align-items-center">

                        <div class="flex-shrink-0">

                            <img src="<?php echo $result->icon ?>" alt="<?php echo $result->name ?>" width="50px">

                        </div>

                        <div class="flex-grow-1 ms-3 text-break">

                            <div class="btn-group w-100 text-break">

                                <a type="button" class="btn btn-primary" href="<?php echo $result->path ?>/<?php echo $result->name ?>" download="">

                                    <i class="bi bi-download me-1"></i>Download

                                </a>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    <?php }?>

</div>
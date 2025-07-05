<?php

/** Importação de classes */
use \vendor\controller\main\Main;
use \vendor\model\Modules;

/** Instânciamento de classes */
$Main = new Main;
$Modules = new Modules();

/** Operações */
$Main->SessionStart();

/** Busco todos os registros */
$resultModules = $Modules->All(@(int)$_SESSION['USERSCOMPANYID']);

?>

<div class="col-md-6 fadeIn">

    <h5 class="card-title">

        Módulos /
    </h5>

</div>

<div class="col-md-6 text-end fadeIn">

    <button type="button" class="btn btn-primary btn-sm" onclick="SendRequest('FOLDER=VIEW&TABLE=MODULES&ACTION=MODULES_FORM', {target : null, block : {create : true, info : null, sec : null, target : null, data : 'Aguarde', color : 'blue', type : 'circle', size : 'sm', message : true}});">

        <i class="bi bi-plus me-1"></i>Novo

    </button>

</div>

<?php

/** Verifico se existem registros */
if (count($resultModules) > 0) { ?>

    <table class="table table-hover bg-white shadow-sm align-items-center border animate slideIn mt-2">

        <thead id="search_table_head">
        <tr>
            <th class="text-center">

                Nº

            </th>

            <th>

                Nome

            </th>

            <th class="text-center">

                Operações

            </th>

        </tr>

        </thead>

        <tbody>

        <?php

        /** Consulta os usuário cadastrados*/
        foreach ($resultModules as $keyResultModules => $result) {

            /** Crio o nome da função */
            $result->delete = 'delete_modules_' . $keyResultModules . '_' . $result->modules_id;

            ?>

            <tr class="border-top">

                <td class="text-center">

                    <?php echo @(int)$result->modules_id; ?>

                </td>

                <td>

                    <?php echo @(string)$result->name; ?>

                </td>

                <td class="text-center align-middle">

                    <div class="btn-group btn-group-sm w-100 text-break">

                        <button type="button" class="btn btn-primary" onclick="SendRequest('FOLDER=VIEW&TABLE=MODULES&ACTION=MODULES_DETAILS&MODULES_ID=<?php echo utf8_encode(@(int)$result->modules_id) ?>', {target : null, block : {create : true, info : null, sec : null, target : null, data : 'Aguarde', color : 'blue', type : 'circle', size : 'sm', message : true}});">

                            <i class="bi bi-eye me-1"></i>Detalhes

                        </button>

                        <button type="button" class="btn btn-primary" onclick="SendRequest('FOLDER=VIEW&TABLE=MODULES&ACTION=MODULES_FORM&MODULES_ID=<?php echo utf8_encode(@(int)$result->modules_id) ?>', {target : null, block : {create : true, info : null, sec : null, target : null, data : 'Aguarde', color : 'blue', type : 'circle', size : 'sm', message : true}});">

                            <i class="bi bi-pencil me-1"></i>Editar

                        </button>

                        <button type="button" class="btn btn-primary" onclick="modalConstruct(true, 'Deseja remover o módulo?', '', 'md', null, null, 'question', <?php echo @(string)$result->delete  ?>, null, null)">

                            <i class="bi bi-fire me-1"></i>Remover

                            <script type="text/javascript">

                                /** Carrega a função de logout */
                                var <?php echo $result->delete ?> = "SendRequest('FOLDER=ACTION&TABLE=MODULES&ACTION=MODULES_DELETE&MODULES_ID=<?php echo @(int)$result->modules_id?>', {target : null, block : {create : true, info : null, sec : null, target : null, data : 'Aguarde', color : 'blue', type : 'circle', size : 'sm', message : true}});";

                            </script>

                        </button>

                    </div>

                </td>

            </tr>

        <?php } ?>

        </tbody>

    </table>

    <?php

} else { ?>

    <div class="col-md-12 animate slideIn">

        <div class="card shadow-sm ">

            <div class="card-body text-center">

                <h1 class="card-title text-center">

                <span class="badge rounded-pill text-bg-primary">

                    M-1

                </span>

                </h1>

                <h4 class="card-subtitle text-center text-muted">

                    Ainda não foram cadastrado módulos.

                </h4>

            </div>

        </div>

    </div>

<?php } ?>
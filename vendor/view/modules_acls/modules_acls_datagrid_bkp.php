<?php

/** Importação de classes */
use \vendor\controller\main\Main;
use \vendor\model\ModulesAcls;

/** Instânciamento de classes */
$Main = new Main;
$ModulesAcl = new ModulesAcls();

/** Operações */
$Main->SessionStart();

/** Busco todos os registros */
$resultModulesAcl = $ModulesAcl->All(@(int)$_SESSION['USERSCOMPANYID']);

?>

<div class="col-md-6 fadeIn">

    <h5 class="card-title">

        <b>
            <i class="fas fa-file-word me-1"></i>
        </b>

            Controles de Acesso 


    </h5>

</div>

<div class="col-md-6 text-end fadeIn">

    <button type="button" class="btn btn-primary btn-sm" onclick="request('FOLDER=VIEW&TABLE=modules_acls&ACTION=modules_acls_form', '#loadContent', true, '', '', '', 'Preparando formulário', 'blue', 'circle', 'sm', true)">

        <i class="bi bi-plus me-1"></i>Novo

    </button>

</div>

<?php

/** Verifico se existem registros */
if (count($resultModulesAcl) > 0) { ?>

    <div class="col-md-12 animate slideIn">

        <div class="form-group mb-2">

            <input type="text" class="form-control form-control-solid" placeholder="Pesquise por: Nome" id="search" name="search">

        </div>

        <div class="table-responsive">

            <table class="table table-bordered table-borderless table-hover bg-white shadow-sm border" id="search_table">

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
                foreach ($resultModulesAcl as $keyResultModulesAcl => $result) {

                    /** Crio o nome da função */
                    $function = 'function_delete_moduloes_' . $keyResultModulesAcl . '_' . rand(1, 1000);

                    ?>

                    <tr class="border-top">

                        <td class="text-center">

                            <?php echo utf8_encode(@(int)$result->modules_acls_id); ?>

                        </td>

                        <td>

                            <?php echo @(string)$result->name; ?> / <?php echo @(string)$result->description; ?>

                        </td>

                        <td class="text-center">

                            <div class="btn-group dropleft">

                                <button class="btn btn-primary dropdown-toggle" type="button" id="buttonDropdown_<?php echo $keyResultModulesAcl ?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                                    <i class="fas fa-cog"></i>

                                </button>

                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                                    <a type="button" class="dropdown-item" onclick="request('FOLDER=VIEW&TABLE=modules_acls&ACTION=modules_acls_form&modules_acls_id=<?php echo @(int)$result->modules_acls_id ?>', '#loadContent', true, '', '', '', 'Preparando formulário', 'blue', 'circle', 'sm', true)">

                                        <span class="badge rounded-pill text-bg-primary me-1">

                                            <i class="fas fa-user-edit"></i>

                                        </span>

                                        Editar

                                    </a>

                                    <div class="dropdown-divider"></div>

                                    <a type="button" class="dropdown-item" onclick="modalPage(true, 0, 0,   'Atenção', 'Deseja realmente remover o registro?', '', 'question', <?php echo @(string)$function ?>)">

                                        <span class="badge rounded-pill text-bg-danger me-1">

                                            <i class="bi bi-fire me-1"></i>Remover

                                        </span>

                                        Excluir

                                    </a>

                                </div>

                            </div>

                            <script type="text/javascript">

                                /** Carrega a função de logout */
                                let <?php echo utf8_encode(@(string)$function)?> = "request('FOLDER=ACTION&TABLE=modules_acls&ACTION=modules_acls_delete&modules_acls_id=<?php echo @(int)$result->modules_acls_id?>', '', true, '', 0, '', 'Removendo registro', 'random', 'circle', 'sm', true)";

                            </script>

                        </td>

                    </tr>

                <?php } ?>

                </tbody>

            </table>

        </div>

    </div>

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

<script type="text/javascript">

    /** Carrego o LiveSearch */
    ;

</script>
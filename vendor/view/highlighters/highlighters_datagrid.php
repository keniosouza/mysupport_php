<?php

/** Importação de classes */
use \vendor\controller\main\Main;
use \vendor\model\Highlighters;

/** Instânciamento de classes */
$Main = new Main;
$Highlighters = new Highlighters();

/** Operações */
$Main->SessionStart();

/** Busco todos os registros */
$resultHighlighter = $Highlighters->All(@(int)$_SESSION['USERSCOMPANYID']);

?>


<div class="col-md-6">

        <h5 class="card-title">

            <b>
                <i class="fas fa-highlighter me-1"></i>
            </b>
                Marcações
        </h5>

    </div>

    <div class="col-md-6 text-end">

        <button type="button" class="btn btn-primary btn-sm" onclick="request('FOLDER=VIEW&TABLE=HIGHLIGHTERS&ACTION=HIGHLIGHTERS_FORM', '#loadContent', true, '', '', '', 'Preparando formulário', 'blue', 'circle', 'sm', true)">

            <i class="bi bi-plus me-1"></i>Novo

        </button>

    </div>

<?php

/** Verifico se existem registros */
if (count($resultHighlighter) > 0)

{ ?>
     <div class="col-md-12">

            <div class="form-group mb-2">

                <input type="text" class="form-control form-control-solid shadow-sm" placeholder="Pesquise por: Nome" id="search" name="search">

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
                    foreach ($Highlighters->All(@(int)$_SESSION['USERSCOMPANYID']) as $keyResultHighlighter => $resultHighlighter)

                    {
                        /** Crio o nome da função */
                        $function = 'function_delete_highlighter_' . $keyResultHighlighter . '_' . rand(1, 1000);?>

                        <tr class="border-top">

                            <td class="text-center">

                                <?php echo utf8_encode($resultHighlighter->highlighter_id); ?>

                            </td>

                            <td>

                                <?php echo utf8_encode($resultHighlighter->name); ?>

                            </td>

                            <td class="text-center">

                                <div class="btn-group dropleft">

                                    <button class="btn btn-primary dropdown-toggle" type="button" id="buttonDropdown_<?php echo utf8_encode($keyResultHighlighter)?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                                        <i class="fas fa-cog"></i>

                                    </button>

                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                                        <a type="button" class="dropdown-item" onclick="request('FOLDER=VIEW&TABLE=HIGHLIGHTERS&ACTION=HIGHLIGHTERS_FORM&HIGHLIGHTER_ID=<?php echo utf8_encode(@(int)$resultHighlighter->highlighter_id)?>', '#loadContent', true, '', '', '', 'Preparando formulário', 'blue', 'circle', 'sm', true)">

                                            <span class="badge rounded-pill text-bg-primary me-1">

                                                <i class="fas fa-user-edit"></i>

                                            </span>

                                            Editar

                                        </a>

                                        <div class="dropdown-divider"></div>

                                        <a type="button" class="dropdown-item" onclick="modalPage(true, 0, 0,   'Atenção', 'Deseja realmente remover o registro?', '', 'question', <?php echo @(string)$function?>)">

                                            <span class="badge rounded-pill text-bg-danger me-1">

                                                <i class="bi bi-fire me-1"></i>Remover

                                            </span>

                                            Excluir

                                        </a>

                                    </div>

                                    <script type="text/javascript">

                                        /** Carrega a função de logout */
                                        let <?php echo @(string)$function?> = "request('FOLDER=ACTION&TABLE=HIGHLIGHTERS&ACTION=HIGHLIGHTERS_DELETE&HIGHLIGHTER_ID=<?php echo utf8_encode(@(int)$resultHighlighter->highlighter_id)?>', '', true, '', 0, '', 'Removendo registro', 'random', 'circle', 'sm', true)";

                                    </script>

                            </td>

                        </tr>

                    <?php } ?>

                    </tbody>

                </table>

            </div>

        </div>


    <?php

}else{ ?>

    <div class="col-md-12">

        <div class="card shadow-sm  animate slideIn">

            <div class="card-body text-center">

                <h1 class="card-title text-center">

                <span class="badge rounded-pill text-bg-primary">

                    MC-1

                </span>

                </h1>

                <h4 class="card-subtitle text-center text-muted">

                    Ainda não foram cadastradas marcações.

                </h4>

            </div>

        </div>

    </div>

<?php }?>

<script type="text/javascript">

    /** Carrego as mascaras */
    loadMask();

    /** Carrego o LiveSearch */
    ;

</script>
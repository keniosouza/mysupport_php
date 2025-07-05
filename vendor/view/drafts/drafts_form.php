<?php

/** Importação de classes */

use \vendor\controller\main\Main;
use \vendor\model\Highlighters;
use \vendor\model\Drafts;
use \vendor\controller\drafts\DraftsValidate;

/** Instânciamento de classes */
$Main = new Main();
$Highlighters = new Highlighters();
$Drafts = new Drafts();
$DraftsValidate = new DraftsValidate();

/** Operações */
$Main->SessionStart();

/** Tratamento dos dados de entrada */
$DraftsValidate->setDraftId(@(int)filter_input(INPUT_POST, 'DRAFT_ID', FILTER_SANITIZE_SPECIAL_CHARS));

/** Verifico se existe registro */
if ($DraftsValidate->getDraftId() > 0) {

    /** Busca de registro */
    $resultDraft = $Drafts->get($DraftsValidate->getDraftId());

    /** Decodifico o texto */
    $resultDraft->text = base64_decode($resultDraft->text);
}

?>

<div class="col-md-6">

    <h5 class="card-title">

        <b>
            <i class="fas fa-file-word me-1"></i>
        </b>

        Minutas <i class="fas fa-chevron-right"></i><b> Formulário</b>
    </h5>

</div>
    
<div class="col-md-6 text-end">
    <button type="button" class="btn btn-outline-primary btn-sm mb-0" onclick="request('FOLDER=VIEW&TABLE=DRAFTS&ACTION=DRAFTS_DATAGRID', '#loadContent', true, '', '', '', 'Preparando formulário', 'blue', 'circle', 'sm', true)">

        <i class="bi bi-arrow-left-short me-1"></i>Voltar

    </button>

</div>
<div class="col-md-12">

    <div class="card shadow-sm border">

        <form class="card-body" role="form" id="formDrafts">

            <div class="row">

                <div class="col-md-12">

                    <div class="form-group">

                        <label for="name">

                           <b>Nome</b>

                        </label>

                        <input id="name" type="text" class="form-control form-control-solid" name="name" value="<?php echo @(string)$resultDraft->name ?>">

                    </div>

                </div>

                <div class="col-md-12">

                    <div class="form-group">

                        <label for="text">

                           <b>Texto</b>

                        </label>

                        <main>

                            <div id="text_toolbar"></div>

                            <div class="row-editor">

                                <div class="editor-container">

                                    <div class="editor" id="text">

                                        <?php echo @(string)$resultDraft->text ?>

                                    </div>

                                </div>

                            </div>

                        </main>

                    </div>

                </div>

                <div class="col-md-12 text-center">

                    <div class="form-group">

                        <a class="btn btn-primary w-100" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">

                        <i class="fas fa-chevron-right"></i><i class="fas fa-highlighter me-1"></i>Marcações<i class="bi bi-arrow-left-short"></i>

                        </a>

                        <div class="collapse" id="collapseExample">

                            <div class="form-group my-2">

                                <input type="text" class="form-control form-control-solid shadow-sm" placeholder="Pesquise por: Nome" id="search" name="search">

                            </div>

                            <table class="table table-bordered table-borderless table-hover bg-white shadow-sm border " id="search_table">

                                <thead id="search_table_head">
                                    <tr>

                                        <th>

                                            Nome

                                        </th>

                                    </tr>

                                </thead>

                                <tbody>

                                    <?php

                                    /** Consulta os usuário cadastrados*/
                                    foreach ($Highlighters->All(@(int)$_SESSION['USERSCOMPANYID']) as $keyResultHighlighter => $resultHighlighter) {
                                    ?>

                                        <tr class="border-top">

                                            <td id="text_<?php echo $keyResultHighlighter ?>">

                                                <?php echo $resultHighlighter->name; ?>

                                            </td>

                                        </tr>

                                    <?php } ?>

                                </tbody>

                            </table>

                        </div>

                    </div>

                </div>

                <div class="col-md-12 text-end">

                    <button type="button" class="btn btn-success" onclick="sendForm('#formDrafts', 'S')">

                        <i class="far fa-save me-1"></i>Salvar

                    </button>

                </div>

            </div>

            <input type="hidden" name="draft_id" value="<?php echo @(int)$resultDraft->draft_id ?>" />
            <input type="hidden" name="FOLDER" value="ACTION" />
            <input type="hidden" name="TABLE" value="DRAFTS" />
            <input type="hidden" name="ACTION" value="DRAFTS_SAVE" />

        </form>

    </div>

</div>

<script type="text/javascript">
    /** Carrego o editor de texto */
    loadCKEditor();
</script>
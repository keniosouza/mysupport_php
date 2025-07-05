<?php

/** Importação de classes */

use \vendor\model\Highlighters;
use \vendor\controller\highlighters\HighlightersValidate;

/** Instânciamento de classes */
$Highlighters = new Highlighters();
$HighlightersValidate = new HighlightersValidate();

/** Tratamento dos dados de entrada */
$HighlightersValidate->setHighlighterId(@(int)filter_input(INPUT_POST, 'HIGHLIGHTER_ID', FILTER_SANITIZE_SPECIAL_CHARS));

/** Verifico se devo buscar registro */
if ($HighlightersValidate->getHighlighterId() > 0) {

    /** Busca de registro */
    $resultHighlighters = $Highlighters->Get($HighlightersValidate->getHighlighterId());

    /** Decodifico o coropo do texto */
    $resultHighlighters->text = (object)json_decode($resultHighlighters->text);
}

?>

<div class="col-md-6">

    <h5 class="card-title">

        <b>
            <i class="fas fa-highlighter me-1"></i>
        </b>

        Marcações <i class="fas fa-chevron-right"></i> <b> Formulário</b>

    </h5>

</div>

<div class="col-md-6 text-end">
    <a type="button" class="btn btn-outline-primary btn-sm" onclick="request('FOLDER=VIEW&ACTION=HIGHLIGHTERS_DATAGRID&TABLE=HIGHLIGHTERS', '#loadContent', true, '', '', '', 'Preparando formulário', 'blue', 'circle', 'sm', true)">

        <i class="bi bi-arrow-left-short me-1"></i>Voltar

    </a>

</div>

<div class="col-md-12">

    <div class="card shadow-sm border">

        <form class="card-body" role="form" id="formUsers">

            <div class="row">

                <div class="col-md-12">

                    <div class="form-group">

                        <label for="name">

                           <b>Nome</b>

                        </label>

                        <input type="text" id="name" class="form-control form-control-solid" name="name" value="<?php echo @(string)$resultHighlighters->name ?>">

                    </div>

                </div>

                <div class="col-md-4">

                    <div class="form-group">

                        <label for="table">

                            Tabela

                        </label>

                        <input type="text" id="table" class="form-control form-control-solid" name="table" value="<?php echo @(string)$resultHighlighters->text->table ?>">

                    </div>

                </div>

                <div class="col-md-4">

                    <div class="form-group">

                        <label for="column">

                            Coluna

                        </label>

                        <input type="text" id="column" class="form-control form-control-solid" name="column" value="<?php echo @(string)$resultHighlighters->text->column ?>">

                    </div>

                </div>

                <div class="col-md-4">

                    <div class="form-group">

                        <label for="primary_key">

                            Chave Primária

                        </label>

                        <input type="text" id="primary_key" class="form-control form-control-solid" name="primary_key" value="<?php echo @(string)$resultHighlighters->text->primary_key ?>">

                    </div>

                </div>

                <div class="col-md-12 text-end">

                    <button type="button" class="btn btn-success" onclick="sendForm('#formUsers')">

                        <i class="far fa-save me-1"></i>Salvar

                    </button>

                </div>

            </div>

            <input type="hidden" name="highlighter_id" value="<?php echo @(int)$resultHighlighters->highlighter_id ?>" />
            <input type="hidden" name="FOLDER" value="ACTION" />
            <input type="hidden" name="TABLE" value="HIGHLIGHTERS" />
            <input type="hidden" name="ACTION" value="HIGHLIGHTERS_SAVE" />

        </form>

    </div>

</div>
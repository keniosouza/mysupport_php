<?php

/** Importação de classes */
use \vendor\model\Calls;
use \vendor\controller\calls\CallsValidate;

/** Instânciamento de classes */
$Calls = new Calls();
$CallsValidate = new CallsValidate();

/** Tratamento dos dados de entrada */
$CallsValidate->setCallId(@(int)filter_input(INPUT_POST, 'CALL_ID', FILTER_SANITIZE_SPECIAL_CHARS));

/** Verifico se existe registro */
if ($CallsValidate->getCallId() > 0) {

    /** Busca de registro */
    $CallsGetResult = $Calls->get($CallsValidate->getCallId());
}

?>

    <form id="CallsForm">

        <div class="card">

            <div class="card-body" role="form" id="CallsForm">

                <div class="row g-2">

                    <div class="col-md-12">

                        <div class="form-group">

                            <label for="name">

                                Nome

                            </label>

                            <input type="text" class="form-control form-control-solid" name="name" id="name" value="<?php echo @(string)$CallsGetResult->name ?>">

                        </div>

                    </div>

                    <div class="col-md-12">

                        <div class="form-group">

                            <label for="description">

                                Descrição

                            </label>

                            <main>

                                <div id="description_toolbar"></div>

                                <div class="row-editor">

                                    <div class="editor-container">

                                        <div class="editor" id="description">

                                            <?php echo @(string)$CallsGetResult->description ?>

                                        </div>

                                    </div>

                                </div>

                            </main>

                        </div>

                    </div>

                </div>

                <input type="hidden" name="call_id" value="<?php echo @(int)$CallsGetResult->call_id ?>" />
                <input type="hidden" name="FOLDER" value="ACTION" />
                <input type="hidden" name="TABLE" value="CALLS" />
                <input type="hidden" name="ACTION" value="CALLS_SAVE" />

            </div>

        </div>

        <div class="col-md-12 pt-2" id="CallsMessages"></div>

        <div class="col-md-12 text-end">

            <button type="button" class="btn btn-primary w-100 mt-3" onclick="SendRequest('CallsForm', {target : 'CallsMessages', block : {create : true, info : null, sec : null, target : null, data : 'Aguarde...', color : 'blue', type : 'circle', size : 'sm', message : true}});">

                <i class="bi bi-check me-1"></i>Salvar

            </button>

        </div>

        <script type="text/javascript">

            /** Carrego o editor de texto */
            loadCKEditor();

        </script>

    </form>

<?php

/** Prego a estrutura do arquivo */
$html = ob_get_contents();

/** Removo o arquivo incluido */
ob_clean();

/** Result **/
$result = array(

    'code' => 201,
    'title' => 'Chamados / Atividades / Formulário /',
    'data' => $html,
    'size' => 'lg',
    'color_modal' => null,
    'color_border' => null,
    'type' => null,
    'procedure' => null,
    'time' => null

);

/** Envio **/
echo json_encode($result);

/** Paro o procedimento **/
exit;

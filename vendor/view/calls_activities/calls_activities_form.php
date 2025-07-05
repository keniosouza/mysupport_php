<?php

/** Importação de classes */
use \vendor\model\Sections;
use \vendor\model\CallsActivities;
use \vendor\controller\calls_activities\CallsActivitiesValidate;

/** Instânciamento de classes */
$Sections = new Sections();
$CallsActivities = new CallsActivities();
$CallsActivitiesValidate = new CallsActivitiesValidate();

/** Tratamento dos dados de entrada */
$CallsActivitiesValidate->setCallId(@(int)filter_input(INPUT_POST, 'CALL_ID', FILTER_SANITIZE_SPECIAL_CHARS));
$CallsActivitiesValidate->setCallActivityId(@(int)filter_input(INPUT_POST, 'CALL_ACTIVITY_ID', FILTER_SANITIZE_SPECIAL_CHARS));

/** Verifico se existe registro */
if ($CallsActivitiesValidate->getCallActivityId() > 0) {

    /** Busca de registro */
    $resultCallsActivities = $CallsActivities->get($CallsActivitiesValidate->getCallActivityId());

}

/** Inicio a coleta de dados */
ob_start();?>

    <form role="form" id="CallsActivitiesForm">

        <div class="card">

            <div class="card-body">

                <div class="row g-3">

                    <div class="col-md-12">

                        <div class="form-group">

                            <label for="name">

                                Seção:

                            </label>

                            <select name="section_id" id="section_id" class="form-control form-select form-control-solid">

                                <option value=''>Selecione</option>

                                <?php
                                /** Consulta os CallsActivitiesTypes cadastrados*/
                                foreach ($Sections->All($CallsActivitiesValidate->getCallId(), 'calls') as $key => $result)
                                {?>

                                    <option value='<?php echo ($result->section_id)?>' <?php  echo $resultCallsActivities->section_id == $result->section_id ? 'Selected' : Null  ?>>

                                        <?php echo (@(string)$result->name)?>

                                    </option>

                                <?php }?>

                            </select>

                        </div>

                    </div>

                    <div class="col-md-12">

                        <div class="form-group">

                            <label for="name">

                                Nome:

                            </label>

                            <input type="text" class="form-control form-control-solid" name="name" id="name" value="<?php echo @(string)$resultCallsActivities->name ?>">

                        </div>

                    </div>

                    <div class="col-md-12">

                        <div class="form-group">

                            <label for="keywords">

                                Palavras Chave <small class="text-danger">(Separar por ponto e virgula ;)</small>:

                            </label>

                            <input type="text" class="form-control form-control-solid" name="keywords" id="keywords" value="<?php echo @(string)$resultCallsActivities->keywords ?>" placeholder="Exemplos: Erro; Correção; Bug;">

                        </div>

                    </div>

                    <div class="col-md-12">

                        <div class="form-group">

                            <label for="description">

                                Descrição:

                            </label>

                            <main>

                                <div id="description_toolbar"></div>

                                <div class="row-editor" style="max-height: 200px">

                                    <div class="editor-container">

                                        <div class="editor" id="description">

                                            <?php echo @(string)$resultCallsActivities->description ?>

                                        </div>

                                    </div>

                                </div>

                            </main>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <input type="hidden" name="call_activity_id" value="<?php echo @(int)$resultCallsActivities->call_activity_id ?>"/>
        <input type="hidden" name="call_id" value="<?php echo @(int)$CallsActivitiesValidate->getCallId() ?>"/>
        <input type="hidden" name="FOLDER" value="ACTION"/>
        <input type="hidden" name="TABLE" value="CALLS_ACTIVITIES"/>
        <input type="hidden" name="ACTION" value="CALLS_ACTIVITIES_SAVE"/>

        <div class="col-md-12" id="CallsActivitiesMessages"></div>

        <div class="col-md-12 text-end mt-2">

            <button type="button" class="btn btn-primary w-100" onclick="SendRequest('CallsActivitiesForm', {target : 'CallsActivitiesMessages', block : {create : true, info : null, sec : null, target : 'CallsActivitiesMessages', data : 'Aguarde', color : 'blue', type : 'circle', size : 'sm', message : true}});">

                <i class="bi bi-check me-1"></i>Salvar

            </button>

        </div>

    </form>

    <script type="text/javascript">

        /** Carrego o editor de texto */
        loadCKEditor();

    </script>

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

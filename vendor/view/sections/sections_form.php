<?php

/** Importação de classes */
use \vendor\model\Sections;
use \vendor\controller\sections\SectionsValidate;

/** Instânciamento de classes */
$Sections = new Sections();
$SectionsValidate = new SectionsValidate();

/** Tratamento dos dados de entrada */
$SectionsValidate->setSectionId(@(int)filter_input(INPUT_POST, 'SECTION_ID', FILTER_SANITIZE_SPECIAL_CHARS));
$SectionsValidate->setRegisterId(@(int)filter_input(INPUT_POST, 'REGISTER_ID', FILTER_SANITIZE_SPECIAL_CHARS));

/** Verifico se existe registro */
if ($SectionsValidate->getSectionId() > 0) {

    /** Busca de registro */
    $SectionGetResult = $Sections->get($SectionsValidate->getSectionId());
    
}?>

    <form id="CallsForm">

        <div class="card">

            <div class="card-body" role="form" id="CallsForm">

                <div class="row g-2">

                    <div class="col-md-6">

                        <div class="form-group">

                            <label for="name">

                                Nome

                            </label>

                            <input type="text" class="form-control form-control-solid" name="name" id="name" value="<?php echo @(string)$SectionGetResult->name ?>">

                        </div>

                    </div>

                    <div class="col-md-6">

                        <div class="form-group">

                            <label for="position">

                                Posição

                            </label>

                            <input type="text" class="form-control form-control-solid" name="position" id="position" value="<?php echo @(string)$SectionGetResult->position ?>">

                        </div>

                    </div>

                </div>

                <input type="hidden" name="FOLDER" value="ACTION" />
                <input type="hidden" name="TABLE" value="SECTIONS" />
                <input type="hidden" name="ACTION" value="SECTIONS_SAVE" />
                <input type="hidden" name="section_id" value="<?php echo @(int)$SectionGetResult->section_id ?>" />
                <input type="hidden" name="register_id" value="<?php echo @(int)$SectionsValidate->getRegisterId() ?>" />

            </div>

        </div>

        <div class="col-md-12 pt-2" id="SectionsMessages"></div>

        <div class="col-md-12">

            <div class="btn-group w-100">

                <button type="button" class="btn btn-primary" onclick="SendRequest('CallsForm', {target : 'SectionsMessages', block : {create : true, info : null, sec : null, target : null, data : 'Aguarde...', color : 'blue', type : 'circle', size : 'sm', message : true}});">

                    <i class="bi bi-check me-1"></i>Salvar

                </button>

                <?php

                /** Verifico se existe registro */
                if ($SectionGetResult->section_id > 0) {?>

                    <button type="button" class="btn btn-danger-soft" onclick="SendRequest('FOLDER=ACTION&TABLE=SECTIONS&ACTION=SECTIONS_DELETE&SECTION_ID=<?php echo $SectionGetResult->section_id;?>&REGISTER_ID=<?php echo $SectionGetResult->register_id;?>', {target : null, block : {create : true, info : null, sec : null, target : null, data : 'Aguarde', color : 'blue', type : 'circle', size : 'sm', message : true}});">

                        <i class="bi bi-fire"></i>Remover

                    </button>

                <?php }?>

            </div>

        </div>

    </form>

<?php

/** Prego a estrutura do arquivo */
$html = ob_get_contents();

/** Removo o arquivo incluido */
ob_clean();

/** Result **/
$result = array(

    'code' => 201,
    'title' => 'Chamados / Atividades / Seção /',
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

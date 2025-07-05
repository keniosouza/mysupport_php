<?php

/** Importação de classes */
use \vendor\controller\main\Main;
use \vendor\model\Modules;
use \vendor\controller\modules\ModulesValidate;

/** Instânciamento de classes */
$Main = new Main();
$Modules = new Modules();
$ModulesValidate = new ModulesValidate();

/** Operações */
$Main->SessionStart();

/** Tratamento dos dados de entrada */
$ModulesValidate->setModulesId(@(int)filter_input(INPUT_POST, 'MODULES_ID', FILTER_SANITIZE_SPECIAL_CHARS));

/** Verifico se existe registro */
if ($ModulesValidate->getModulesId() > 0) {

    /** Busca de registro */
    $resultModules = $Modules->get($ModulesValidate->getModulesId());
}

?>

<h5 class="card-title">

    Módulos / <b>Formulário</b> /

    <button type="button" class="btn btn-primary btn-sm" onclick="SendRequest('FOLDER=VIEW&TABLE=MODULES&ACTION=MODULES_DATAGRID', {target : null, block : {create : true, info : null, sec : null, target : null, data : 'Aguarde', color : 'blue', type : 'circle', size : 'sm', message : true}});">

        <i class="bi bi-arrow-left-short me-1"></i>Voltar

    </button>

</h5>

<div class="col-md-12">

    <div class="card shadow-sm">

        <form class="card-body" role="form" id="ModulesForm">

            <div class="row g-1">

                <div class="col-md-6">

                    <div class="form-group">

                        <label for="name">

                            Nome

                        </label>

                        <input id="name" type="text" class="form-control form-control-solid" name="name" value="<?php echo @(string)$resultModules->name ?>">

                    </div>

                </div>

                <div class="col-md-6">

                    <div class="form-group">

                        <label for="description">

                            Descrição

                        </label>

                        <input id="description" type="text" class="form-control form-control-solid" name="description" value="<?php echo @(string)$resultModules->description ?>">

                    </div>

                </div>

                <div class="col-md-12 text-end">

                    <button type="button" class="btn btn-primary" onclick="SendRequest('ModulesForm', {target : null, block : {create : true, info : null, sec : null, target : null, data : 'Aguarde', color : 'blue', type : 'circle', size : 'sm', message : true}});">

                        <i class="bi bi-check me-1"></i>Salvar

                    </button>

                </div>

            </div>

            <input type="hidden" name="FOLDER" value="ACTION" />
            <input type="hidden" name="TABLE" value="MODULES" />
            <input type="hidden" name="ACTION" value="MODULES_SAVE" />
            <input type="hidden" name="modules_id" value="<?php echo @(int)$resultModules->modules_id ?>" />

        </form>

    </div>

</div>
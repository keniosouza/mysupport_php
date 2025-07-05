<?php

/** Importação de classes */
use \vendor\model\ModulesAcls;
use \vendor\controller\modules_acls\ModulesAclsValidate;

/** Instânciamento de classes */
$ModulesAcls = new ModulesAcls();
$ModulesAclsValidate = new ModulesAclsValidate();

/** Tratamento dos dados de entrada */
$ModulesAclsValidate->setModulesId(@(int)filter_input(INPUT_POST, 'MODULES_ID', FILTER_SANITIZE_SPECIAL_CHARS));
$ModulesAclsValidate->setModulesAclsId(@(int)filter_input(INPUT_POST, 'MODULES_ACLS_ID', FILTER_SANITIZE_SPECIAL_CHARS));

/** Verifico se existe registro */
if ($ModulesAclsValidate->getModulesAclsId() > 0) {

    /** Busca de registro */
    $ModulesAclsGetResult = $ModulesAcls->get($ModulesAclsValidate->getModulesAclsId());
}

?>

<div class="card shadow-sm border animate slideIn">

    <form class="card-body" role="form" id="ModulesAclsForm">

        <button class="btn btn-primary btn-sm w-100 my-1" onclick="SendRequest('FOLDER=VIEW&TABLE=MODULES_ACLS&ACTION=MODULES_ACLS_DATAGRID&MODULES_ID=<?php echo @(int)$ModulesAclsValidate->getModulesId() ?>', {target : 'ModulesAclDatagridOrForm', block : {create : true, info : null, sec : null, target : 'ModulesAclDatagridOrForm', data : 'Aguarde', color : 'blue', type : 'circle', size : 'sm', message : true}});">

            <i class="bi bi-x"></i>Fechar

        </button>

        <div class="row row-dynamic-input g-1">

            <div class="col-md-12">

                <div class="form-group">

                    <label for="description">

                        Descrição

                    </label>

                    <input type="text" class="form-control form-control-solid" id="description" name="description" value="<?php echo @(string)$ModulesAclsGetResult->description ?>">

                </div>

            </div>

            <div class="col-md-12">

                <div class="alert alert-warning" role="alert">

                    <h4 class="alert-heading">

                        Atenção

                    </h4>

                    <p>

                        É necessário cadastrar as seguintes opções padrões

                    </p>

                    <ul>

                        <li>

                            criar

                        </li>

                        <li>

                            editar

                        </li>

                        <li>

                            remover

                        </li>

                        <li>

                            ler

                        </li>

                    </ul>

                </div>

            </div>

            <?php

            /** Pego o histórico existente */
            $preferences = json_decode($ModulesAclsGetResult->preferences, TRUE);

            /** Consulta os usuário cadastrados*/
            foreach ($preferences as $key => $result) { ?>

                <div class="col-md-3">

                    <div class="form-group">

                        <label for="permission<?php echo $key ?>">

                            Nome permissão

                        </label>

                        <input id="permission<?php echo $key ?>" type="text" class="form-control form-control-solid" name="permission[]" value="<?php echo $result ?>">

                    </div>

                </div>

            <?php } ?>

        </div>

        <div class="row mt-1">

            <div class="col-md-6 text-left">

                <button type="button" class="btn btn-primary" onclick="addInputModulesAclsForm()">

                    <i class="bi bi-plus-circle me-1"></i>Adicionar Campo

                </button>

            </div>

            <div class="col-md-6 text-end">

                <button type="button" class="btn btn-primary" onclick="SendRequest('ModulesAclsForm', {target : 'pills-modules', block : {create : true, info : null, sec : null, target : 'pills-modules', data : 'Aguarde', color : 'blue', type : 'circle', size : 'sm', message : true}});">

                    <i class="bi bi-check me-1"></i>Salvar

                </button>

            </div>

        </div>

        <input type="hidden" name="FOLDER" value="ACTION" />
        <input type="hidden" name="TABLE" value="modules_acls" />
        <input type="hidden" name="ACTION" value="modules_acls_save" />
        <input type="hidden" name="modules_id" value="<?php echo @(int)$ModulesAclsValidate->getModulesId() ?>" />
        <input type="hidden" name="modules_acls_id" value="<?php echo @(int)$ModulesAclsGetResult->modules_acls_id ?>" />

    </form>

</div>

<script type="text/javascript">

    function addInputModulesAclsForm() {

        /** Id aleatorio */
        let key = Math.random();

        /** Defino a estrutura HTML */
        let html = '<div class="col-md-3 animate slideIn">';
            html += '	<div class="form-group">';
            html += '		<label for="permission' + key + '">';
            html += '			Nome permissão';
            html += '		</label>';
            html += '		<input id="permission' + key + '" type="text" class="form-control form-control-solid" name="permission[]">';
            html += '	</div>';
            html += '</div>';

        /** Preencho o HTML dentro da DIV desejad **/
        $('.row-dynamic-input').append(html);

        /** Defino o foco */
        $('permission' + key).focus();

    }

</script>
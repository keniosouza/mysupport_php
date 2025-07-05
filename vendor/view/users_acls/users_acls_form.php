<?php

/** Importação de classes */
use \vendor\model\ModulesAcls;
use \vendor\controller\users\UsersValidate;

/** Instânciamento de classes */
$ModulesAcls = new ModulesAcls();
$UsersValidate = new UsersValidate();

/** Parametros de entrada */
$usersId = (int)filter_input(INPUT_POST, 'USERS_ID', FILTER_SANITIZE_SPECIAL_CHARS);

/** Validando os campos de entrada */
$UsersValidate->setUsersId($usersId);

/** Busca de registro */
$resultModulesAcls = $ModulesAcls->AllNoLimit(@(int)$_SESSION['USERSCOMPANYID']);

?>

<button class="btn btn-primary btn-sm w-100 my-2" onclick="SendRequest('FOLDER=VIEW&TABLE=USERS_ACLS&ACTION=USERS_ACLS_DATAGRID&USERS_ID=<?php echo $UsersValidate->getUsersId()?>', {target : 'pills-modules', block : {create : true, info : null, sec : null, target : 'pills-modules', data : 'Aguarde', color : 'blue', type : 'circle', size : 'sm', message : true}});">

    <i class="bi bi-x me-1"></i>Fechar

</button>

<form role="form" id="UsersAclsForm">

    <table class="table table-bordered table-borderless table-hover bg-white shadow-sm border animate slideIn">

        <thead id="search_table_head">

        <tr>

            <th>

                Módulo / Descrição

            </th>

        </tr>

        </thead>

        <tbody>

        <?php

        /** Consulta os usuário cadastrados*/
        foreach ($resultModulesAcls as $key => $result) {
            ?>

            <tr class="border-top">

                <td>

                    <div class="form-group">

                        <div class="custom-control custom-switch">

                            <input type="checkbox" class="custom-control-input" id="customSwitch<?php echo @(int)$key ?>" value="<?php echo @(int)$result->modules_acls_id ?>" name="modules_acls_id[]">

                            <label class="custom-control-label" for="customSwitch<?php echo @(int)$key ?>">

                                <?php echo @(string)$result->name ?> / <?php echo @(string)$result->description ?>

                            </label>

                        </div>

                    </div>

                </td>

            </tr>

        <?php } ?>

        </tbody>

    </table>

    <div id="UsersAclsFormMessages"></div>

    <button type="button" class="btn btn-primary w-100" onclick="SendRequest('UsersAclsForm', {target : 'UsersAclsFormMessages', block : {create : true, info : null, sec : null, target : 'UsersAclsFormMessages', data : 'Aguarde', color : 'blue', type : 'circle', size : 'sm', message : true}});">

        <i class="bi bi-check me-1"></i>Salvar

    </button>

    <input type="hidden" name="users_id" value="<?php echo @(string)$UsersValidate->getUsersId() ?>" />
    <input type="hidden" name="FOLDER" value="ACTION" />
    <input type="hidden" name="TABLE" value="USERS_ACLS" />
    <input type="hidden" name="ACTION" value="USERS_ACLS_SAVE" />

</form>
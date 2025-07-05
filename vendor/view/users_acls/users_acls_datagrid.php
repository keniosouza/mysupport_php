<?php

/** Importação de classes */
use vendor\model\Users;
use vendor\controller\users\UsersValidate;
use \vendor\model\UsersAcls;
use \vendor\controller\users_acls\UsersAclsValidate;

/** Instânciamento de classes  */
$Users = new Users();
$UsersValidate = new UsersValidate();
$UsersAcls = new UsersAcls();
$UsersAclsValidate = new UsersAclsValidate();

/** Parametros de entrada */
$usersId = (int)filter_input(INPUT_POST, 'USERS_ID', FILTER_SANITIZE_SPECIAL_CHARS);

/** Validando os campos de entrada */
$UsersValidate->setUsersId($usersId);
$UsersAclsValidate->setUsersId($usersId);

/** Verifico se existe registro */
if ($UsersAclsValidate->getUsersId() > 0) {

    /** Busca de registro */
    $resultUsersAcls = $UsersAcls->All($UsersValidate->getUsersId());

}

?>

<button class="btn btn-primary btn-sm w-100 my-1" onclick="SendRequest('FOLDER=VIEW&TABLE=USERS_ACLS&ACTION=USERS_ACLS_FORM&USERS_ID=<?php echo @(int)$UsersValidate->getUsersId() ?>', {target : 'pills-modules', block : {create : true, info : null, sec : null, target : 'pills-modules', data : 'Aguarde', color : 'blue', type : 'circle', size : 'sm', message : true}});">

    <i class="bi bi-plus me-1"></i>Permissões

</button>

<table class="table table-hover bg-white shadow-sm align-items-center border animate slideIn">

    <thead>

    <tr>

        <th class="text-center">

            Nº

        </th>

        <th>

            Modulo

        </th>

        <th>

            Permissão

        </th>

        <th class="text-center">

            Operações

        </th>

    </tr>

    </thead>

    <tbody>

    <?php

    /** Consulta os usuário cadastrados*/
    foreach ($resultUsersAcls as $keyResultUsersAcl => $result) {

        /** Crio o nome da função */
        $result->delete = 'delete_users_acls_' . @(int)$keyResultUsersAcl . '_' . $result->users_acls_id;

        ?>

        <tr class="border-top">

            <td class="text-center">

                <?php echo @(int)$result->users_acls_id; ?>

            </td>

            <td>

                <?php echo @(string)$result->name; ?>

            </td>

            <td>

                <?php echo @(string)$result->description; ?>

            </td>

            <td class="text-center" id="UsersPermissionsMessages<?php echo @(int)$result->users_acls_id?>">

                <div class="btn-group btn-group-sm w-100 text-break">

                    <button type="button" class="btn btn-primary" onclick="SendRequest('FOLDER=ACTION&TABLE=users_acls&ACTION=users_acls_delete&users_id=<?php echo @(int)$result->users_id?>&users_acls_id=<?php echo @(int)$result->users_acls_id?>', {target : 'UsersPermissionsMessages<?php echo @(int)$result->users_acls_id?>', block : {create : true, info : null, sec : null, target : 'UsersPermissionsMessages<?php echo @(int)$result->users_acls_id?>', data : 'Aguarde', color : 'blue', type : 'circle', size : 'sm', message : true}});">

                        <i class="bi bi-fire me-1"></i>Remover

                    </button>

                </div>

            </td>

        </tr>

    <?php } ?>

    </tbody>

</table>
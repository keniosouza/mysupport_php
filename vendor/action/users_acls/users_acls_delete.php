<?php

/** Importação de classes */
use vendor\model\UsersAcls;
use vendor\controller\users_acls\UsersAclsValidate;

/** Instânciamento de classes */
$UsersAcls = new UsersAcls();
$UsersAclsValidate = new UsersAclsValidate();

/** Parâmetros de entrada */
$UsersAclsValidate->setUsersAclsId(@(int)filter_input(INPUT_POST, 'users_acls_id', FILTER_SANITIZE_SPECIAL_CHARS));

/** Verifico a existência de erros */
if (!empty($UsersAclsValidate->getErrors())) {

    /** Retorno mensagem de erro */
    throw new InvalidArgumentException($UsersAclsValidate->getErrors(), 0);

} else {

    /** Verifico se o usuário foi localizado */
    if ($UsersAcls->delete($UsersAclsValidate->getUsersAclsId())) {

        /** Result **/
        $result = [

            'code' => 200,
            'title' => 'Sucesso',
            'data' => 'Permissão Removida',
            'target' => 'UsersPermissionsMessages' . $UsersAclsValidate->getUsersAclsId()

        ];

    } else {

        /** Retorno mensagem de erro */
        throw new InvalidArgumentException('Não foi possivel remover o registro', 0);

    }

}

/** Envio **/
echo json_encode($result);

/** Paro o procedimento **/
exit;
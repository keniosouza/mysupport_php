<?php

/** Importação de classes */
use vendor\model\ModulesAcls;
use vendor\controller\modules_acls\ModulesAclsValidate;

/** Instânciamento de classes */
$ModulesAcls = new ModulesAcls();
$ModulesAclsValidate = new ModulesAclsValidate();

/** Defino as novas permissõess */
$permission = array();

/** Listo todas as permissões informadas */
foreach ($_POST['permission'] as $key => $result) {

    /** Verifico se esta preenchido */
    if (!empty(trim($result))) {

        /** Tratamento da informação */
        $ModulesAclsValidate->setPermission($result);

        /** Guardo as permissões cadastradas dentro de uma array */
        array_push($permission, $ModulesAclsValidate->getPermission());

    }

}

/** Parâmetros de entrada */
$ModulesAclsValidate->setModulesAclsId(@(int)filter_input(INPUT_POST, 'modules_acls_id', FILTER_SANITIZE_SPECIAL_CHARS));
$ModulesAclsValidate->setCompanyId(@(int)$_SESSION['USERSCOMPANYID']);
$ModulesAclsValidate->setModulesId(@(int)filter_input(INPUT_POST, 'modules_id', FILTER_SANITIZE_SPECIAL_CHARS));
$ModulesAclsValidate->setDescription(@(string)filter_input(INPUT_POST, 'description', FILTER_SANITIZE_SPECIAL_CHARS));
$ModulesAclsValidate->setPreferences(json_encode($permission, JSON_PRETTY_PRINT));

/** Verifico a existência de erros */
if (!empty($ModulesAclsValidate->getErrors())) {

    /** Retorno mensagem de erro */
    throw new InvalidArgumentException($ModulesAclsValidate->getErrors(), 0);

} else {

    /** Verifico se o usuário foi localizado */
    if ($ModulesAcls->Save($ModulesAclsValidate->getModulesAclsId(), $ModulesAclsValidate->getModulesId(), $ModulesAclsValidate->getCompanyId(), $ModulesAclsValidate->getDescription(), $ModulesAclsValidate->getPreferences())) {

        /** Result **/
        $result = [

            'code' => 200,
            'title' => 'Sucesso',
            'data' => 'Permissão vinculada com sucesso',
            'redirect' => [
                [
                    'url' => 'FOLDER=VIEW&TABLE=MODULES_ACLS&ACTION=MODULES_ACLS_DATAGRID&MODULES_ID=' . $ModulesAclsValidate->getModulesId(),
                    'target' => 'ModulesAclDatagridOrForm',
                ]
            ],
            'toast' => true

        ];

    } else {

        /** Retorno mensagem de erro */
        throw new InvalidArgumentException('Não foi possivel salvar o registro', 0);

    }

}

/** Envio **/
echo json_encode($result);

/** Paro o procedimento **/
exit;
<?php

/** Importação de classes */
use vendor\model\ModulesAcls;
use vendor\controller\modules_acls\ModulesAclsValidate;

/** Instânciamento de classes */
$ModulesAcls = new ModulesAcls();
$ModulesAclsValidate = new ModulesAclsValidate();

/** Parâmetros de entrada */
$ModulesAclsValidate->setModulesId(@(int)filter_input(INPUT_POST, 'MODULES_ID', FILTER_SANITIZE_SPECIAL_CHARS));
$ModulesAclsValidate->setModulesAclsId(@(int)filter_input(INPUT_POST, 'MODULES_ACLS_ID', FILTER_SANITIZE_SPECIAL_CHARS));

/** Verifico a existência de erros */
if (!empty($ModulesAclsValidate->getErrors()))
{

    /** Retorno mensagem de erro */
    throw new InvalidArgumentException($ModulesAclsValidate->getErrors(), 0);

}
else
{

    /** Verifico se o usuário foi localizado */
    if ($ModulesAcls->delete($ModulesAclsValidate->getModulesAclsId()))
    {

        /** Result **/
        $result = [

            'code' => 200,
            'title' => 'Sucesso',
            'data' => 'Permissão removida',
            'redirect' => [
                [
                    'url' => 'FOLDER=VIEW&TABLE=MODULES_ACLS&ACTION=MODULES_ACLS_DATAGRID&MODULES_ID=' . $ModulesAclsValidate->getModulesId(),
                    'target' => 'ModulesAclDatagridOrForm',
                ]
            ],
            'toast' => true

        ];

    }
    else
    {

        /** Retorno mensagem de erro */
        throw new InvalidArgumentException('Não foi possivel remover o registro', 0);

    }

}

/** Envio **/
echo json_encode($result);

/** Paro o procedimento **/
exit;
<?php

/** Importação de classes */
use vendor\model\Modules;
use vendor\controller\modules\ModulesValidate;

/** Instânciamento de classes */
$Modules = new Modules();
$ModulesValidate = new ModulesValidate();

/** Parâmetros de entrada */
$ModulesValidate->setModulesId(@(int)filter_input(INPUT_POST, 'modules_id', FILTER_SANITIZE_SPECIAL_CHARS));
$ModulesValidate->setCompanyId(@(int)$_SESSION['USERSCOMPANYID']);
$ModulesValidate->setName(@(string)filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS));
$ModulesValidate->setDescription(@(string)filter_input(INPUT_POST, 'description', FILTER_SANITIZE_SPECIAL_CHARS));

/** Verifico a existência de erros */
if (!empty($ModulesValidate->getErrors())) {

    /** Retorno mensagem de erro */
    throw new InvalidArgumentException($ModulesValidate->getErrors(), 0);

} else {

    /** Verifico se o usuário foi localizado */
    if ($Modules->Save($ModulesValidate->getModulesId(), $ModulesValidate->getCompanyId(), $ModulesValidate->getName(), $ModulesValidate->getDescription())) {

        /** Result **/
        $result = [

            'code' => 200,
            'title' => 'Sucesso',
            'message' => $message,
            'redirect' => [
                [
                    'url' =>  'FOLDER=VIEW&TABLE=modules&ACTION=modules_datagrid'
                ]
            ]

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
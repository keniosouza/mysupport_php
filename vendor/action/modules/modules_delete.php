<?php

/** Importação de classes */
use vendor\model\Modules;
use vendor\controller\modules\ModulesValidate;

/** Instânciamento de classes */
$Modules = new Modules();
$ModulesValidate = new ModulesValidate();

/** Parâmetros de entrada */
$ModulesValidate->setModulesId(@(int)filter_input(INPUT_POST, 'MODULES_ID', FILTER_SANITIZE_SPECIAL_CHARS));

/** Verifico a existência de erros */
if (!empty($ModulesValidate->getErrors()))
{

    /** Retorno mensagem de erro */
    throw new InvalidArgumentException($ModulesValidate->getErrors(), 0);

}
else
{

    /** Verifico se o usuário foi localizado */
    if ($Modules->delete($ModulesValidate->getModulesId()))
    {

        /** Result **/
        $result = [

            'code' => 200,
            'title' => 'Sucesso',
            'message' => 'Registro removido com sucesso',
            'redirect' => [
                [
                    'url' => 'FOLDER=VIEW&TABLE=modules&ACTION=modules_datagrid'
                ]
            ]

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
<?php

error_reporting(E_ALL);
ini_set('display_errors','On');

/** Importação de classes */
use vendor\model\CallsActivitiesLevels;
use vendor\controller\calls_activities_levels\CallsActivitiesLevelsValidate;

/** Instânciamento de classes */
$CallsActivitiesLevels = new CallsActivitiesLevels();
$CallsActivitiesLevelsValidate = new CallsActivitiesLevelsValidate();

/** Parâmetros de entrada */
$CallsActivitiesLevelsValidate->setCallActivityLevelId(@(int)filter_input(INPUT_POST, 'call_activity_level_id', FILTER_SANITIZE_SPECIAL_CHARS));
$CallsActivitiesLevelsValidate->setCompanyId(@(int)$_SESSION['USERSCOMPANYID']);
$CallsActivitiesLevelsValidate->setDescription(@(string)filter_input(INPUT_POST, 'description', FILTER_SANITIZE_SPECIAL_CHARS));

/** Verifico a existência de erros */
if (!empty($CallsActivitiesLevelsValidate->getErrors()))
{

    /** Retorno mensagem de erro */
    throw new InvalidArgumentException($CallsActivitiesLevelsValidate->getErrors(), 0);

}
else
{

    /** Verifico se o usuário foi localizado */
    if ($CallsActivitiesLevels->Save($CallsActivitiesLevelsValidate->getCallActivityLevelId(), $CallsActivitiesLevelsValidate->getCompanyId(), $CallsActivitiesLevelsValidate->getDescription()))
    {

        /** Result **/
        $result = [

            'code' => 200,
            'title' => 'Sucesso',
            'data' => 'Nível salvo com sucesso!'

        ];

    }
    else
    {

        /** Retorno mensagem de erro */
        throw new InvalidArgumentException('Não foi possivel salvar o registro', 0);

    }

}

/** Envio **/
echo json_encode($result);

/** Paro o procedimento **/
exit;
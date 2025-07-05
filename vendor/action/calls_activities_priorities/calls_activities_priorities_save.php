<?php

error_reporting(E_ALL);
ini_set('display_errors','On');

/** Importação de classes */
use vendor\model\CallsActivitiesPriorities;
use vendor\controller\calls_activities_priorities\CallsActivitiesPrioritiesValidate;

/** Instânciamento de classes */
$CallsActivitiesPriorities = new CallsActivitiesPriorities();
$CallsActivitiesPrioritiesValidate = new CallsActivitiesPrioritiesValidate();

/** Parâmetros de entrada */
$CallsActivitiesPrioritiesValidate->setCallActivityPriorityId(@(int)filter_input(INPUT_POST, 'call_activity_priority_id', FILTER_SANITIZE_SPECIAL_CHARS));
$CallsActivitiesPrioritiesValidate->setCompanyId(@(int)$_SESSION['USERSCOMPANYID']);
$CallsActivitiesPrioritiesValidate->setDescription(@(string)filter_input(INPUT_POST, 'description', FILTER_SANITIZE_SPECIAL_CHARS));

/** Verifico a existência de erros */
if (!empty($CallsActivitiesPrioritiesValidate->getErrors()))
{

    /** Retorno mensagem de erro */
    throw new InvalidArgumentException($CallsActivitiesPrioritiesValidate->getErrors(), 0);

}
else
{

    /** Verifico se o usuário foi localizado */
    if ($CallsActivitiesPriorities->Save($CallsActivitiesPrioritiesValidate->getCallActivityPriorityId(), $CallsActivitiesPrioritiesValidate->getCompanyId(), $CallsActivitiesPrioritiesValidate->getDescription()))
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
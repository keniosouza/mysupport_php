<?php

/** Importação de classes */
use vendor\model\CallsActivitiesTypes;
use vendor\controller\calls_activities_types\CallsActivitiesTypesValidate;

/** Instânciamento de classes */
$CallsActivitiesTypes = new CallsActivitiesTypes();
$CallsActivitiesTypesValidate = new CallsActivitiesTypesValidate();

/** Parâmetros de entrada */
$CallsActivitiesTypesValidate->setCallsActivityTypesId(@(int)filter_input(INPUT_POST, 'call_activity_type_id', FILTER_SANITIZE_SPECIAL_CHARS));
$CallsActivitiesTypesValidate->setCompanyId(@(int)$_SESSION['USERSCOMPANYID']);
$CallsActivitiesTypesValidate->setDescription(@(string)filter_input(INPUT_POST, 'description', FILTER_SANITIZE_SPECIAL_CHARS));

/** Verifico a existência de erros */
if (!empty($CallsActivitiesTypesValidate->getErrors()))
{

    /** Retorno mensagem de erro */
    throw new InvalidArgumentException($CallsActivitiesTypesValidate->getErrors(), 0);

}
else
{

    /** Verifico se o usuário foi localizado */
    if ($CallsActivitiesTypes->Save($CallsActivitiesTypesValidate->getCallsActivityTypesId(), $CallsActivitiesTypesValidate->getCompanyId(), $CallsActivitiesTypesValidate->getDescription(), $CallsActivitiesTypesValidate->getHistory()))
    {

        /** Result **/
        $result = [

            'code' => 200,
            'title' => 'Sucesso',
            'data' => 'Categoria salva com sucesso'

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
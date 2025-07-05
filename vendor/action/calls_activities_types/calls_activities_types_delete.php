<?php

/** Importação de classes */
use vendor\model\CallsActivitiesTypes;
use vendor\controller\calls_activities_types\CallsActivitiesTypesValidate;

try {

    /** Instânciamento de classes */
    $CallsActivitiesTypes = new CallsActivitiesTypes();
    $CallsActivitiesTypesValidate = new CallsActivitiesTypesValidate();

    /** Parâmetros de entrada */
    $CallsActivitiesTypesValidate->setCallsActivityTypesId(@(int)filter_input(INPUT_POST, 'CALL_ACTIVITY_TYPE_ID', FILTER_SANITIZE_SPECIAL_CHARS));
    $CallsActivitiesTypesValidate->setCompanyId(@(int)$_SESSION['USERSCOMPANYID']);


    /** Verifico a existência de erros */
    if (!empty($CallsActivitiesTypesValidate->getErrors())) {

        /** Retorno mensagem de erro */
        throw new InvalidArgumentException($CallsActivitiesTypesValidate->getErrors(), 0);

    } else {

        if($CallsActivitiesTypes->allRelated($CallsActivitiesTypesValidate->getCompanyId() ,$CallsActivitiesTypesValidate->getCallsActivityTypesId())->quantity <= 0){


            /** Verifico se o usuário foi localizado */
            if ($CallsActivitiesTypes->delete($CallsActivitiesTypesValidate->getCallsActivityTypesId())) {

                /** Result **/
                $result = [

                    'code' => 200,
                    'title' => 'Sucesso',
                    'message' => 'Registro Removido com Sucesso',
                    'redirect' => [
                        [
                            'url' => 'FOLDER=VIEW&TABLE=CALLS_ACTIVITIES_TYPES&ACTION=CALLS_ACTIVITIES_TYPES_DATAGRID'
                        ]
                    ]

                ];

            } else {

                /** Retorno mensagem de erro */
                throw new InvalidArgumentException('Não foi possivel remover o registro', 0);

            }

        } else {

            /** Retorno mensagem de erro */
            throw new InvalidArgumentException('Registro vinculado a atividades, não foi possivel remover o registro!', 0);
        }

    }

    /** Envio **/
    echo json_encode($result);

    /** Paro o procedimento **/
    exit;

} catch (Exception $exception) {

    /** Preparo o formulario para retorno **/
    $result = [

        'code' => 0,
        'message' => '<div class="alert alert-danger" role="alert">' . $exception->getMessage() . '</div>',
        'title' => 'Atenção',
        'type' => 'exception',

    ];

    /** Envio **/
    echo json_encode($result);

    /** Paro o procedimento **/
    exit;

}
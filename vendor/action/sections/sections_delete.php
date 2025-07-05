<?php

/** Importação de classes */
use vendor\model\Sections;
use vendor\controller\sections\SectionsValidate;

/** Instânciamento de classes */
$Sections = new Sections();
$SectionsValidate = new SectionsValidate();

/** Parâmetros de entrada */
$SectionsValidate->setSectionId(@(int)filter_input(INPUT_POST, 'SECTION_ID', FILTER_SANITIZE_NUMBER_INT));
$SectionsValidate->setRegisterId(@(int)filter_input(INPUT_POST, 'REGISTER_ID', FILTER_SANITIZE_SPECIAL_CHARS));

/** Verifico a existência de erros */
if (!empty($SectionsValidate->getErrors())) {

    /** Retorno mensagem de erro */
    throw new InvalidArgumentException($SectionsValidate->getErrors(), 0);

} else {

    /** Busco o registro desejado */
    $SectionsGetResult = $Sections->get($SectionsValidate->getSectionId());

    /** Verifico se o usuário foi localizado */
    if ($Sections->delete($SectionsValidate->getSectionId())) {

        /** Result **/
        $result = [

            'code' => 200,
            'title' => 'Sucesso',
            'data' => 'Registro Salvo com Sucesso',
            'toast' => true,
            'redirect' => [
                [
                    'url' => 'FOLDER=VIEW&TABLE=CALLS_ACTIVITIES&ACTION=CALLS_ACTIVITIES_DATAGRID&CALL_ID=' . $SectionsValidate->getRegisterId(),
                    'target' => 'CallsDetailsWrapper',
                ]
            ]

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
<?php

/** Importação de classes */
use vendor\model\Sections;
use vendor\controller\sections\SectionsValidate;

/** Instânciamento de classes */
$Sections = new Sections();
$SectionsValidate = new SectionsValidate();

/** Parâmetros de entrada */
$SectionsValidate->setSectionId(@(int)filter_input(INPUT_POST, 'section_id', FILTER_SANITIZE_SPECIAL_CHARS));
$SectionsValidate->setRegisterId(@(int)filter_input(INPUT_POST, 'register_id', FILTER_SANITIZE_SPECIAL_CHARS));
$SectionsValidate->setTable('calls');
$SectionsValidate->setName(@(string)filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS));
$SectionsValidate->setPosition(@(int)filter_input(INPUT_POST, 'position', FILTER_SANITIZE_SPECIAL_CHARS));
$SectionsValidate->setPreferences(@(string)filter_input(INPUT_POST, 'preferences', FILTER_SANITIZE_SPECIAL_CHARS));

/** Verifico a existência de erros */
if (!empty($SectionsValidate->getErrors())) {

    /** Caso existam erro(s), retorna os mesmos **/
    throw new InvalidArgumentException($SectionsValidate->getErrors());

} else {

    /** Verifico se o usuário foi localizado */
    if ($Sections->Save($SectionsValidate->getSectionId(), $SectionsValidate->getRegisterId(), $SectionsValidate->getTable(), $SectionsValidate->getName(), $SectionsValidate->getPosition(), $SectionsValidate->getPreferences())) {

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
        throw new InvalidArgumentException('Não foi possivel salvar o registro', 0);

    }

}

/** Devolvo o json com as informações **/
echo json_encode($result);

/** Paro o procedimento **/
exit;
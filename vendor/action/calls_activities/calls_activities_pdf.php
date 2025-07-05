<?php

/** Importação de classes */
use vendor\controller\pdf\Pdf;
use vendor\model\CallsActivitiesUsers;
use vendor\model\CallsActivities;
use vendor\controller\calls_activities\CallsActivitiesValidate;

/** Instânciamento de classes */
$Pdf = new Pdf();
$CallsActivitiesUsers = new CallsActivitiesUsers();
$CallsActivities = new CallsActivities();
$CallsActivitiesValidate = new CallsActivitiesValidate();

/** Busco todos os chamados */
$CallsActivitiesResult = $CallsActivities->AllByCompanyId($_SESSION['USERSCOMPANYID']);

/** Verifico a existência de erros */
if (count($CallsActivitiesResult) === 0) {

    /** Retorno mensagem de erro */
    throw new InvalidArgumentException('Não foram localizados registros para impressão',  0);

} else {

    /** Inicio a coleta de dados */
    ob_start();

    /** Inclusão do arquivo desejado */
    @include_once 'vendor/view/calls_activities/calls_activities_pdf.php';

    /** Prego a estrutura do arquivo */
    $html = ob_get_contents();

    /** Removo o arquivo incluido */
    ob_clean();

    /** Nome de Pasta Aleatória */
    $path = 'temp/pdf_' . (date('d_m_Y_H_i_s'));

    /** Nome do arquivo a ser gerado */
    $name = 'ATIVIDADES_EM_ABERTO.pdf';

    /** Defino as preferências */
    $preferences = new stdClass;

    /** Definição da largura */
    $preferences->width = 29;

    /** Definição da altura */
    $preferences->height = 42;

    /** Definição do tamanho */
    $preferences->size = 'A4';

    /** Definição da orientação */
    $preferences->orientation = 'landscape';

    /** Crio o pdf */
    $Pdf->generate($html, $path, $name, $preferences);

    /** Result **/
    $result = [

        'code' => 203,
        'title' => 'Sucesso',
        'document' => $path . '/' . $name,
        'size' => 'xl'

    ];

}

/** Envio **/
echo json_encode($result);

/** Paro o procedimento **/
exit;
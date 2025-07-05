<?php

/** Importação de classes */
use \vendor\model\Calls;
use \vendor\controller\calls\CallsValidate;
use \vendor\model\CallsActivities;

/** Instânciamento de classes */
$Calls = new Calls();
$CallsValidate = new CallsValidate();
$CallsActivities = new CallsActivities();

/** Tratamento dos dados de entrada */
$CallsValidate->setCallId(@(int)filter_input(INPUT_POST, 'CALL_ID', FILTER_SANITIZE_SPECIAL_CHARS));
$CallsValidate->setCompanyId(@(int)$_SESSION['USERSCOMPANYID']);
$CallsActivitiesCountCallActivityPriorityIdResult = $CallsActivities->CountCallActivityPriorityId($CallsValidate->getCallId());

/** Verifico se existe registro */
if ($CallsValidate->getCallId() > 0) {

    /** Busca de registro */
    $resultCalls = $Calls->Get($CallsValidate->getCallId());

}

?>

    <div class="card mb-2 animate slideIn">

        <div class="card-body">

            <p class="card-text">

                <?php echo @(string)$resultCalls->description ?>

            </p>

            <?php

            /** Consulta os usuário cadastrados*/
            foreach ($CallsActivitiesCountCallActivityPriorityIdResult as $key => $result) {?>

                <img src="<?php echo $Main->SetIcon('image/default/status/' . $result->call_activity_priority_id . '.png', 'default/files/default.png'); ?>" alt="<?php echo $result->name ?>" width="25px">

                <span class="badge bg-<?php echo $Main->SetClass($result->call_activity_priority_id); ?>">

                <?php echo $result->description ?>: <?php echo $result->total_priorities ?>

            </span>

            <?php } ?>

        </div>

    </div>

<?php

/** Prego a estrutura do arquivo */
$html = ob_get_contents();

/** Removo o arquivo incluido */
ob_clean();

/** Result **/
$result = array(

    'code' => 201,
    'title' => 'Chamado / Calendário / Detalhes / ',
    'data' => $html,
    'size' => 'lg',
    'color_modal' => null,
    'color_border' => null,
    'type' => null,
    'procedure' => null,
    'time' => null

);

/** Envio **/
echo json_encode($result);

/** Paro o procedimento **/
exit;
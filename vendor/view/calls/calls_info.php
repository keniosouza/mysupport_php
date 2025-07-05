<?php

/** Importação de classes */
use \vendor\controller\calls\CallsValidate;
use \vendor\model\CallsMessages;
use \vendor\model\CallsActivities;
use \vendor\model\CallsActivitiesUsers;

/** Instânciamento de classes */
$CallsValidate = new CallsValidate();
$CallsMessages = new CallsMessages();
$CallsActivities = new CallsActivities();
$CallsActivitiesUsers = new CallsActivitiesUsers();

/** Tratamento dos dados de entrada */
$CallsValidate->setCallId(@(int)filter_input(INPUT_POST, 'CALL_ID', FILTER_SANITIZE_SPECIAL_CHARS));
$CallsValidate->setCompanyId(@(int)$_SESSION['USERSCOMPANYID']);

/** Verifico se existe registro */
if ($CallsValidate->getCallId() > 0) {

    /** Busca de registro */
    $CallsActivitiesCountClosedAndTotalResult = $CallsActivities->CountClosedAndTotal($CallsValidate->getCallId());
    $resultCallsActivitiesUsers = $CallsActivitiesUsers->AllUsersLinked($CallsValidate->getCallId(), $CallsValidate->getCompanyId());
    $resultCallsMessages = $CallsMessages->All(0, $CallsValidate->getCallId(), $CallsValidate->getCompanyId());

}

?>

<div class="row animate slideIn g-1">

    <div class="col-md-6 d-flex">

        <div class="card w-100">

            <div class="card-body text-center">

                <h6>

                    Atividades

                </h6>

                <h2>

                    <b>

                        <?php echo $CallsActivitiesCountClosedAndTotalResult->total_calls_activities_closed ?> / <?php echo $CallsActivitiesCountClosedAndTotalResult->total_calls_activities ?>

                    </b>

                </h2>

                <span class="badge bg-primary">

                    <?php echo (int)(($CallsActivitiesCountClosedAndTotalResult->total_calls_activities_closed / $CallsActivitiesCountClosedAndTotalResult->total_calls_activities) * 100)?>%
                    Concluído

                </span>

            </div>

        </div>

    </div>

    <div class="col-md-6 d-flex">

        <div class="card w-100">

            <div class="card-body text-center">

                <h6>

                    Operadores

                </h6>

                <h2>

                    <b>

                        <?php echo count($resultCallsActivitiesUsers) ?>

                    </b>

                </h2>

            </div>

        </div>

    </div>

    <div class="col-md-12  d-flex">

        <div class="card w-100">

            <div class="card-body text-center">

                <h2 class="mb-0">

                    <b>

                        <?php echo count($resultCallsMessages) ?>

                    </b>

                </h2>

                <h5>

                    Feedback's

                </h5>

            </div>

        </div>

    </div>

</div>
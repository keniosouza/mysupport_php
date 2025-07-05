<?php

/** Importação de classes */
use vendor\model\Sections;
use vendor\model\CallsActivities;
use vendor\controller\calls_activities\CallsActivitiesValidate;

/** Instânciamento de classes */
$Sections = new Sections();
$CallsActivities = new CallsActivities();
$CallsActivitiesValidate = new CallsActivitiesValidate();

/** Tratamento dos dados de entrada */
$CallsActivitiesValidate->setCallId(@(int)filter_input(INPUT_POST, 'CALL_ID', FILTER_SANITIZE_SPECIAL_CHARS));
$CallsActivitiesValidate->setSectionId(@(int)filter_input(INPUT_POST, 'SECTION_ID', FILTER_SANITIZE_SPECIAL_CHARS)); ?>

<form role="form" id="CallActivityForm<?php echo (int)$CallsActivitiesValidate->getSectionId() ?>">

    <div class="card mb-1 animate slideIn">

        <div class="card-body">

            <div class="row g-3">

                <div class="col-md-12">

                    <div class="form-group">

                        <input type="text" class="form-control form-control-solid" name="name" id="name" data-mysupport-target="CallActivityName" data-mysupport-form="CallActivityForm<?php echo (int)$CallsActivitiesValidate->getSectionId() ?>">

                    </div>

                </div>

            </div>

        </div>

    </div>

    <input type="hidden" name="FOLDER" value="ACTION"/>
    <input type="hidden" name="TABLE" value="CALLS_ACTIVITIES"/>
    <input type="hidden" name="ACTION" value="CALLS_ACTIVITIES_SAVE_NAME"/>
    <input type="hidden" name="call_id" value="<?php echo (int)$CallsActivitiesValidate->getCallId() ?>"/>
    <input type="hidden" name="section_id" value="<?php echo (int)$CallsActivitiesValidate->getSectionId() ?>"/>

</form>

<script type="text/javascript">

    /** Crio evento personalizado para cada campo de acordo com o atributo */
    new CustomEventListener('{"event" : "blur", "target" : "CallActivityName"}');

</script>
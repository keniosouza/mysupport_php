<?php

/** Importação de classes */
use vendor\model\CallsActivities;
use vendor\controller\calls_activities\CallsActivitiesValidate;

/** Instânciamento de classes */
$CallsActivities = new CallsActivities();
$CallsActivitiesValidate = new CallsActivitiesValidate();

/** Tratamento dos dados de entrada */
$CallsActivitiesValidate->setCallActivityId(@(int)filter_input(INPUT_POST, 'CALL_ACTIVITY_ID', FILTER_SANITIZE_SPECIAL_CHARS));

/** Busco o Registro desejado */
$CallsActivitiesLoadResult = $CallsActivities->Get($CallsActivitiesValidate->getCallActivityId());?>

<form class="card" id="CallsActivitiesFormDescription">

    <div class="card-body custom-scrollbar editor" id="description" contenteditable="true" style="max-height: 300px">

        <?php echo $CallsActivitiesLoadResult->description ?>

    </div>

    <div class="card-footer bg-transparent px-0 py-1 border-top">

        <nav class="navbar navbar-expand-lg bg-transparent rounded py-2">

            <div class="container-fluid">

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCallasdasd" aria-controls="navbarCallasdasd" aria-expanded="false" aria-label="Toggle navigation">

                    <span class="navbar-toggler-icon"></span>

                </button>

                <div class="collapse navbar-collapse" id="navbarCallActivityasdasd">

                    <ul class="navbar-nav me-auto mb-lg-0">

                        <li class="nav-item" onclick="applyCommand('justifyLeft')">

                            <button type="button" class="nav-link cursor-pointer">

                                <i class="bi bi-text-left"></i>

                            </button>

                        </li>

                        <li class="nav-item" onclick="applyCommand('justifyCenter')">

                            <button type="button" class="nav-link cursor-pointer">

                                <i class="bi bi-text-center"></i>

                            </button>

                        </li>

                        <li class="nav-item" onclick="applyCommand('justifyRight')">

                            <button type="button" class="nav-link cursor-pointer">

                                <i class="bi bi-text-right"></i>

                            </button>

                        </li>

                        <li class="nav-item" onclick="applyCommand('justifyFull')">

                            <button type="button" class="nav-link cursor-pointer">

                                <i class="bi bi-justify"></i>

                            </button>

                        </li>

                        <li class="nav-item" onclick="applyCommand('bold')">

                            <button type="button" class="nav-link cursor-pointer">

                                <i class="bi bi-type-bold"></i>

                            </button>

                        </li>

                        <li class="nav-item" onclick="applyCommand('italic')">

                            <button type="button" class="nav-link cursor-pointer">

                                <i class="bi bi-type-italic"></i>

                            </button>

                        </li>

                        <li class="nav-item" onclick="applyCommand('strikeThrough')">

                            <button type="button" class="nav-link cursor-pointer">

                                <i class="bi bi-type-strikethrough"></i>

                            </button>

                        </li>

                        <li class="nav-item" onclick="applyCommand('underline')">

                            <button type="button" class="nav-link cursor-pointer">

                                <i class="bi bi-type-underline"></i>

                            </button>

                        </li>

                        <li class="nav-item" onclick="applyCommand('outdent')">

                            <button type="button" class="nav-link cursor-pointer">

                                <i class="bi bi-text-indent-right"></i>

                            </button>

                        </li>

                        <li class="nav-item" onclick="applyCommand('indent')">

                            <button type="button" class="nav-link cursor-pointer">

                                <i class="bi bi-text-indent-left"></i>

                            </button>

                        </li>

                    </ul>

                </div>

            </div>

        </nav>

    </div>

    <input type="hidden" name="FOLDER" value="ACTION"/>
    <input type="hidden" name="TABLE" value="CALLS_ACTIVITIES"/>
    <input type="hidden" name="ACTION" value="CALLS_ACTIVITIES_SAVE_DESCRIPTION"/>
    <input type="hidden" name="call_activity_id" value="<?php echo $CallsActivitiesLoadResult->call_activity_id?>"/>

</form>

<button type="button" id="CallsActivitiesDescriptionSaveButton" class="btn btn-primary w-100 mt-2" onclick="SendRequest('CallsActivitiesFormDescription', {target : null, loader : {create: true, type: 3, target : 'CallsActivitiesDescriptionSaveButton', data : 'Aguarde...'}});">

    <i class="bi bi-check me-1"></i>Salvar

</button>
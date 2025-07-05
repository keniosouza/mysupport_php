<?php

/** Importação de classes */
use \vendor\model\Users;
use \vendor\model\Calls;
use \vendor\model\CallsActivities;

/** Instânciamento de classes */
$Users = new Users();
$Calls = new Calls();
$CallsActivities = new CallsActivities();

/** Parâmetros de entrada */
$situation = @(int)filter_input(INPUT_POST, 'SITUATION', FILTER_SANITIZE_SPECIAL_CHARS);

/** Verifico o tipo de busca que devo realizar */
switch ($situation)
{

    /** Busco os registros em aberto */
    case 1:

        /** Busco todos os registros */
        $resultCalls = $Calls->AllOpened(@(int)$_SESSION['USERSCOMPANYID']);
        break;

    /** Busco os registros encerrados */
    case 2:

        /** Busco todos os registros */
        $resultCalls = $Calls->AllClosed(@(int)$_SESSION['USERSCOMPANYID']);
        break;

}?>

<?php

/** Verifico se existem registros */
if (count($resultCalls) > 0) { ?>

    <table class="table table-hover bg-white shadow-sm align-items-center border mt-2">

        <thead class="thead-light small text-muted">

            <tr>

                <th scope="col" class="text-center">

                    Nº

                </th>

                <th scope="col" class="text-center">

                    Prioridades

                </th>

                <th scope="col">

                    Nome

                </th>

                <th scope="col" class="text-center">

                    Operações

                </th>

            </tr>

        </thead>

        <tbody>

        <?php

        /** Consulta os usuário cadastrados*/
        foreach ($resultCalls as $keyResultCalls => $result) {

            /** Crio o nome da função */
            $function = 'function_delete_calls_' . $keyResultCalls . '_' . rand(1, 1000);

            /** Decodifico as preferencias */
            $result->preferences = (object)json_decode($result->preferences);

            ?>

            <tr class="border-top">

                <td class="text-center align-middle bg-light-subtle">

                    <b>

                        <?php echo utf8_encode(@(int)$result->call_id); ?>

                    </b>

                </td>

                <td class="text-center align-middle">

                    <?php

                    /** Consulta os usuário cadastrados*/
                    foreach ($CallsActivities->CountCallActivityPriorityId(@(int)$result->call_id) as $CallsActivitiesCountCallActivityPriorityIdKey => $CallsActivitiesCountCallActivityPriorityIdResult) {?>

                        <?php

                        /** Verifico se tem icone para exibir */
                        if(is_file('image/default/status/' . $CallsActivitiesCountCallActivityPriorityIdResult->call_activity_priority_id . '.png')) {?>

                            <img src="<?php echo 'image/default/status/' . $CallsActivitiesCountCallActivityPriorityIdResult->call_activity_priority_id . '.png' ?>" width="25px">

                        <?php } ?>

                    <?php } ?>

                </td>

                <td class="text-wrap align-middle">

                    <?php

                    /** Verifico se tem icone para exibir */
                    if(!empty($result->preferences->image)) {?>

                        <img src="<?php echo $result->preferences->image?>" class="img-fluid me-1" width="20px">

                    <?php } ?>

                    <?php echo @(string)$result->name; ?>

                </td>

                <td class="text-center align-middle">

                    <div class="btn-group btn-group-sm w-100 text-break">

                        <button type="button" class="btn btn-primary" onclick="SendRequest('FOLDER=VIEW&TABLE=CALLS&ACTION=CALLS_DETAILS&CALL_ID=<?php echo utf8_encode(@(int)$result->call_id) ?>', {target : null, loader : {create: true, padding: '0px', type: 2, target : 'wrapper', data : 'Aguarde...'}});">

                            <i class="bi bi-eye"></i>

                        </button>

                        <?php

                        /** Verifico se a permissão */
                        if (@(bool)$resultUserAcl->chamado->encerrar_chamado) { ?>

                            <?php

                            /** Verifico o status do registro */
                            if (empty(@(string)$result->date_close)) { ?>

                                <button class="btn btn-primary" type="button" onclick="SendRequest('FOLDER=ACTION&TABLE=CALLS&ACTION=CALLS_CLOSE&call_id=<?php echo @(int)$result->call_id?>', {target : null, block : {create : true, info : null, sec : null, target : null, data : 'Aguarde', color : 'blue', type : 'circle', size : 'sm', message : true}});">

                                    <i class="bi bi-lock-fill"></i>

                                </button>

                            <?php }?>

                        <?php } ?>

                        <?php

                        /** Verifico se a permissão */
                        if (@(string)$resultUserAcl->chamado->reativar_chamado === 'true') { ?>

                            <?php

                            /** Verifico o status do registro */
                            if (!empty(@(string)$result->date_close)) { ?>

                                <button class="btn btn-primary" type="button" onclick="SendRequest('FOLDER=ACTION&TABLE=CALLS&ACTION=CALLS_CLOSE_OR_OPEN&call_id=<?php echo @(int)$result->call_id?>', {target : null, block : {create : true, info : null, sec : null, target : null, data : 'Aguarde', color : 'blue', type : 'circle', size : 'sm', message : true}});">

                                    <i class="bi bi-unlock"></i>

                                </button>

                            <?php } ?>

                        <?php } ?>

                        <?php

                        /** Verifico se a permissão */
                        if (@(string)$resultUserAcl->chamado->editar === 'true') { ?>

                            <?php

                            /** Verifico o status do registro */
                            if (empty(@(string)$resultCalls->date_close)) { ?>

                                <button type="button" class="btn btn-primary" onclick="SendRequest('FOLDER=VIEW&TABLE=CALLS&ACTION=CALLS_FORM&CALL_ID=<?php echo utf8_encode(@(int)$result->call_id) ?>', {target : null, block : {create : true, info : null, sec : null, target : null, data : 'Aguarde', color : 'blue', type : 'circle', size : 'sm', message : true}});">

                                    <i class="bi bi-pencil"></i>

                                </button>

                            <?php } ?>

                        <?php } ?>

                        <?php

                        /** Verifico se a permissão */
                        if (@(string)$resultUserAcl->chamado->remover === 'true') { ?>

                            <?php

                            /** Verifico o status do registro */
                            if (empty(@(string)$resultCalls->date_close)) { ?>

                                <button type="button" class="btn btn-primary" onclick="modalConstruct(true, 'Deseja remover o chamado?', '', 'md', null, null, 'question', <?php echo @(string)$function ?>, null, null)">

                                    <i class="bi bi-fire"></i>

                                    <script type="text/javascript">

                                        /** Carrega a função de logout */
                                        var <?php echo utf8_encode(@(string)$function)?> = "SendRequest('FOLDER=ACTION&TABLE=CALLS&ACTION=CALLS_DELETE&CALL_ID=<?php echo utf8_encode(@(int)$result->call_id)?>', {target : null, block : {create : true, info : null, sec : null, target : null, data : 'Aguarde', color : 'blue', type : 'circle', size : 'sm', message : true}});";

                                    </script>

                                </button>

                            <?php } ?>

                        <?php } ?>

                    </div>

                </td>

            </tr>

        <?php } ?>

        </tbody>

    </table>

    <?php

} else { ?>

    <div class="col-md-12 animate slideIn">

        <div class="card shadow-sm ">

            <div class="card-body text-center">

                <h1 class="card-title text-center">

                <span class="badge rounded-pill text-bg-primary">

                    C-1

                </span>

                </h1>

                <h4 class="card-subtitle text-center text-muted">

                    Ainda não foram cadastrados chamados.

                </h4>

            </div>

        </div>

    </div>

<?php } ?>
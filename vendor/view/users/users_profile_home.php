<?php

/** Importação de classes */
use \vendor\model\Files;
use \vendor\model\Users;
use \vendor\controller\users\UsersValidate;

/** Instânciamento de classes */
$Files = new Files();
$Users = new Users();
$UsersValidate = new UsersValidate();

/** Verifico o ID que devo buscar */
$usersId = (int)$_POST['USER_ID'];
$administrative = (bool)$_POST['ADMINISTRATIVE'];

/** Parâmetros de entrada */
$UsersValidate->setUsersId((int)$_POST['USER_ID'] > 0 ? (int)$_POST['USER_ID'] : (int)$_SESSION['USERSID']);

/** Busco a constribuição das atividades por usuário */
$FilesAllResult = $Files->Last($UsersValidate->getUsersId(), 'users');
$UsersGetResult = $Users->Get($UsersValidate->getUsersId());

/** Defino o caminho da foto */
$UsersGetResult->photo = $FilesAllResult->path . '/profile/' . $FilesAllResult->name;

/** Verifico se a imagem existe */
$UsersGetResult->photo = file_exists($UsersGetResult->photo) ? $UsersGetResult->photo : 'image/default/user.png';

/** Verifico o status do usuário */
$UsersGetResult->phrase = $UsersGetResult->active === 'S' ? 'Ativo' : 'Inativo';
$UsersGetResult->class = $UsersGetResult->active === 'S' ? 'primary' : 'danger';

/** Verifico se é acesso do administrador */
if ($administrative)
{

    /** Monto a requisição */
    $UsersGetResult->request = "SendRequest('FOLDER=VIEW&TABLE=USERS&ACTION=USERS_FORM&USER_ID={$UsersGetResult->users_id}', {target : null, loader : {create: true, type: 3, target : 'UsersProfileFormButton', data : 'Aguarde...'}})";

}
else
{

    /** Monto a requisição */
    $UsersGetResult->request = "SendRequest('FOLDER=VIEW&TABLE=USERS&ACTION=USERS_PROFILE_FORM', {target : null, loader : {create: true, type: 3, target : 'UsersProfileFormButton', data : 'Aguarde...'}});";

}

?>

<div class="card mb-2">

    <div class="card-body pb-0">

        <div class="d-flex align-items-center">

            <div class="flex-shrink-0 cursor-pointer" onclick="SendRequest('FOLDER=VIEW&TABLE=USERS&ACTION=USERS_PROFILE_FORM_PHOTO&USERS_ID=<?php echo $UsersGetResult->users_id?>', {target : null, block : {create : true, info : null, sec : null, target : null, data : 'Aguarde', color : 'blue', type : 'circle', size : 'sm', message : true}});">

                <img src="<?php echo $UsersGetResult->photo?>" class="img-fluid rounded border" width="60px">

            </div>

            <div class="flex-grow-1 ms-3">

                <h4 class="card-title cursor-pointer" id="UsersProfileFormButton" onclick="<?php echo $UsersGetResult->request?>">

                    <i class="bi bi-pencil fs-5 me-1"></i><?php echo $Main->decryptData($UsersGetResult->name_first)?> <?php echo $Main->decryptData($UsersGetResult->name_last)?>

                </h4>

                <h5 class="card-subtitle">

                    <?php echo $UsersGetResult->email?>

                </h5>

            </div>

        </div>

    </div>

    <div class="card-footer bg-transparent p-0 border-0">

        <nav class="navbar navbar-expand-lg bg-transparent rounded py-2">

            <div class="container-fluid">

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCall191" aria-controls="navbarCall191" aria-expanded="false" aria-label="Toggle navigation">

                    <span class="navbar-toggler-icon"></span>

                </button>

                <div class="collapse navbar-collapse" id="navbarCall191">

                    <ul class="navbar-nav me-auto mb-lg-0">

                        <li class="nav-item">

                            <a class="nav-link" onclick="SendRequest('FOLDER=VIEW&TABLE=NOTIFICATIONS&ACTION=NOTIFICATIONS_DETAILS&USER_ID=<?php echo $UsersGetResult->users_id; ?>', {target : 'UsersProfileWrapper', loader : {create: true, type: 2, target : 'UsersProfileWrapper', data : 'Aguarde...'}});">

                                <i class="bi bi-bell-fill me-1"></i>Caixa de Entrada

                            </a>

                        </li>

                        <li class="nav-item">

                            <a class="nav-link cursor-pointer" onclick="SendRequest('FOLDER=VIEW&TABLE=CALLS_ACTIVITIES_USERS&ACTION=CALLS_ACTIVITIES_USERS_PROFILE_DATAGRID&USER_ID=<?php echo $usersId?>', {target : 'UsersProfileWrapper', loader : {create: true, type: 2, target : 'UsersProfileWrapper', data : 'Aguarde...'}});">

                                <i class="bi bi-kanban me-1"></i>Quadro

                            </a>

                        </li>

                        <li class="nav-item">

                            <a class="nav-link cursor-pointer" onclick="SendRequest('FOLDER=VIEW&TABLE=PRODUCTS_VERSIONS_RELEASES_FILES&ACTION=PRODUCTS_VERSIONS_RELEASES_FILES_DOWNLOADABLE', {target : 'UsersProfileWrapper', loader : {create: true, type: 2, target : 'UsersProfileWrapper', data : 'Aguarde...'}});">

                                <i class="bi bi-git me-1"></i>Versões

                            </a>

                        </li>

                        <li class="nav-item">

                            <a class="nav-link" onclick="SendRequest('FOLDER=VIEW&TABLE=CALLS_ACTIVITIES_USERS&ACTION=CALLS_ACTIVITIES_USERS_CALENDAR&USER_ID=<?php echo $usersId?>', {target : 'UsersProfileWrapper', loader : {create: true, type: 2, target : 'UsersProfileWrapper', data : 'Aguarde...'}});">

                                <i class="bi bi-calendar-check me-1"></i>Calendário

                            </a>

                        </li>

                    </ul>

                    <?php

                    /** Verifico quais botões devem ser exibidos */
                    if (!$administrative){?>

                        <ul class="navbar-nav ms-auto mb-lg-0">

                            <li class="nav-item">

                                <a class="nav-link" onclick="SendRequest('FOLDER=ACTION&TABLE=USERS&ACTION=USERS_LOGOUT', {target : null, loader : {create: true, padding: '0px', type: 2, target : null, data : 'Aguarde...'}});">

                                    <i class="bi bi-box-arrow-left me-1"></i>Sair

                                </a>

                            </li>

                        </ul>

                    <?php } ?>

                </div>

            </div>

        </nav>

    </div>

</div>

<script type="text/javascript">

    /** Envio de requisição */
    SendRequest('FOLDER=VIEW&TABLE=NOTIFICATIONS&ACTION=NOTIFICATIONS_DETAILS&USER_ID=<?php echo $UsersGetResult->users_id; ?>', {target : 'UsersProfileWrapper', loader : {create: true, padding: '0px', type: 2, target : 'UsersProfileWrapper', data : 'Aguarde...'}});

</script>

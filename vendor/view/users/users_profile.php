<?php

/** Importação de classes */
use \vendor\model\Files;
use \vendor\model\Users;

/** Instânciamento de classes */
$Files = new Files();
$Users = new Users();

/** Verifico o ID que devo buscar */
$usersId = (int)$_POST['USER_ID'] > 0 ? $_POST['USER_ID'] : (int)$_SESSION['USERSID'];
$administrative = (int)$_POST['USER_ID'] > 0 ? true : false;

/** Busco a constribuição das atividades por usuário */
$FilesAllResult = $Files->All($usersId, 'users');
$UsersGetResult = $Users->Get($usersId);

/** Guardo a ultima imagem publicada */
foreach ($FilesAllResult as $key => $result)
{

    /** Defino o caminho da foto */
    $UsersGetResult->photo = $result->path . '/' . $result->name;

    /** Verifico se a imagem existe */
    $UsersGetResult->photo = file_exists($UsersGetResult->photo) ? $UsersGetResult->photo : 'image/default/files/default.png';

}

?>

<?php

/** Verifico se devo exibir o menu superior */
if ((int)$_POST['USER_ID'] > 0){?>

    <div class="col-md-10">

        <h5 class="card-title">

            Usuários / <b> Detalhes </b> /

            <button type="button" class="btn btn-primary btn-sm mb-0" onclick="SendRequest('FOLDER=VIEW&TABLE=USERS&ACTION=USERS_DATAGRID', {target : null, loader : {create: true, padding: '0px', type: 2, target : null, data : 'Aguarde...'}});">

                <i class="bi bi-arrow-left-short me-1"></i>Voltar

            </button>

        </h5>

    </div>

    <div class="col-md-2 text-end">

        <button type="button" class="btn btn-primary btn-sm mb-0" onclick="SendRequest('FOLDER=VIEW&TABLE=USERS&ACTION=USERS_PROFILE&USER_ID=<?php echo $UsersGetResult->users_id ?>', {target : null, loader : {create: true, padding: '0px', type: 2, target : null, data : 'Aguarde...'}});">

            <i class="bi bi-arrow-clockwise me-1"></i>Atualizar

        </button>

    </div>

<?php }?>

<div class="col-md-12" id="UsersProfileHome">

    <script type="text/javascript">

        /** Envio de Requisição */
        SendRequest('FOLDER=VIEW&TABLE=USERS&ACTION=USERS_PROFILE_HOME&USER_ID=<?php echo $UsersGetResult->users_id?>&ADMINISTRATIVE=<?php echo $administrative?>', {target : 'UsersProfileHome', loader : {create: true, padding: '0px', type: 2, target : 'UsersProfileHome', data : 'Aguarde...'}});

    </script>

</div>

<div class="col-md-12" id="UsersProfileWrapper"></div>
<?php

/** Importação de classes */
use \vendor\model\Users;
use \vendor\controller\users\UsersValidate;

/** Instânciamento de classes */
$Users = new Users();
$UsersValidate = new UsersValidate();

/** Parâmetros de entrada */
$UsersValidate->setUsersId((int)$_POST['USER_ID'] > 0 ? (int)$_POST['USER_ID'] : (int)$_SESSION['USERSID']);?>

<div class="alert alert-warning alert-dismissible fade show" role="alert">

    Atividades sinalizadas com <img src="image/default/status/1.gif" width="25px" alt="">, aguardam o seu <b>feedback</b>!
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>

</div>

<div class="rounded border shadow-sm bg-white animate slideIn p-0 bg-light">

    <div class="row g-0">

        <div class="col-md border-end custom-scrollbar" id="NotificationsDetailsList" style="min-height: 600px; max-height: 600px">

            <script type="text/javascript">

                /** Envio de Requisição */
                SendRequest('FOLDER=VIEW&TABLE=NOTIFICATIONS&ACTION=NOTIFICATIONS_DETAILS_COL_1&USER_ID=<?php echo $UsersValidate->getUsersId()?>', {target : 'NotificationsDetailsList', loader : {create: true, padding: '5px', type: 2, target : 'NotificationsDetailsList', data : 'Aguarde...'}});

            </script>

        </div>

        <div class="col-md-9 border-end custom-scrollbar p-3 bg-light" id="NotificationsDetailsItem" style="min-height: 600px; max-height: 600px"></div>

    </div>

</div>
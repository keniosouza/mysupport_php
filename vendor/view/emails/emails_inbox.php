<?php

/** Importação de classes */
use \vendor\model\Users;
use \vendor\controller\users\UsersValidate;

/** Instânciamento de classes */
$Users = new Users();
$UsersValidate = new UsersValidate();

/** Parâmetros de entrada */
$UsersValidate->setUsersId((int)$_POST['USER_ID'] > 0 ? (int)$_POST['USER_ID'] : (int)$_SESSION['USERSID']);?>

<div class="rounded border shadow-sm bg-white animate slideIn p-0">

    <div class="row g-0">

        <div class="col-md border-end custom-scrollbar" id="NotificationsDetailsList" style="min-height: 600px; max-height: 600px">

            <script type="text/javascript">

                /** Envio de Requisição */
                SendRequest('FOLDER=VIEW&TABLE=EMAILS&ACTION=EMAILS_INBOX_COL_1&USER_ID=<?php echo $UsersValidate->getUsersId()?>', {target : 'NotificationsDetailsList', block : {create : true, info : null, sec : null, target : 'NotificationsDetailsList', data : 'Aguarde', color : 'blue', type : 'circle', size : 'sm', message : true}});

            </script>

        </div>

        <div class="col-md-9 border-end custom-scrollbar p-3 bg-light" id="NotificationsDetailsItem" style="min-height: 600px; max-height: 600px"></div>

    </div>

</div>
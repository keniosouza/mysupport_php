<?php

/** Importação de classes */
use \vendor\model\Users;
use \vendor\controller\users\UsersValidate;

/** Instânciamento de classes */
$Users = new Users();
$UsersValidate = new UsersValidate();

/** Tratamento dos dados de entrada */
$UsersValidate->setUsersId(@(int)filter_input(INPUT_POST, 'USER_ID', FILTER_SANITIZE_SPECIAL_CHARS));

/** Busca de registro */
$UserGet = $Users->Get($UsersValidate->getUsersId());

?>

<div class="col-md-12 text-center animate slideIn">

    <img src="image/logo.png" width="50px"> | <img src="image/favicon.png" width="50px">

    <div class="my-3">

        <h4 class="">

            Redefinição de

            <b>

                Senha

            </b>

        </h4>

    </div>

</div>

<div class="col-md-5 mx-auto animate slideIn">

    <div class="card shadow-sm">

        <div class="card-body">

            <h5 class="card-title">

                Olá! <?php echo $Main->decryptData($UserGet->name_first)?> <?php echo $Main->decryptData($UserGet->name_last)?>

            </h5>

            <form class="row g-2" role="form" id="UsersRegisterNewPassword">

                <div class="col-md-12">

                    <div class="form-group">

                        <label for="email">

                            Email <span class="text-danger">*</span>

                        </label>

                        <input type="text" class="form-control form-control-solid" value="<?php echo $UserGet->email?>" id="email" name="email" disabled>

                    </div>

                </div>

                <div class="col-md-12">

                    <div class="form-group">

                        <label for="password">

                            Nova Senha <span class="text-danger">*</span>

                        </label>

                        <input type="password" class="form-control form-control-solid" name="password" id="password">

                    </div>

                </div>

                <div class="col-md-12">

                    <div class="form-group">

                        <label for="password_confirm">

                            Confirmar Nova Senha <span class="text-danger">*</span>

                        </label>

                        <input type="password" class="form-control form-control-solid" name="password_confirm" id="password_confirm">

                    </div>

                </div>

                <div class="col-md-12" id="UsersRegisterNewPasswordMessages"></div>

                <div class="col-md-12">

                    <button type="button" class="btn btn-primary w-100" onclick="beforeSendRequest('UsersRegisterNewPassword');">

                        <i class="bi bi-send-fill me-1"></i>Enviar

                    </button>

                </div>

                <input type="hidden" name="FOLDER" value="ACTION" />
                <input type="hidden" name="TABLE" value="USERS" />
                <input type="hidden" name="USER_ID" value="<?php echo $UserGet->users_id?>" />
                <input type="hidden" name="ACTION" value="USERS_REGISTER_NEW_PASSWORD" />

            </form>

        </div>

    </div>

    <button type="button" class="btn btn-outline-primary w-100 mt-3" onclick="SendRequest('FOLDER=VIEW&TABLE=USERS&ACTION=USERS_LOGIN', {target : null, block : {create : true, info : null, sec : null, target : null, data : 'Aguarde', color : 'blue', type : 'circle', size : 'sm', message : true}});">

        Já possui cadastro? <b>Realize o login</b>

    </button>

</div>

<script type="text/javascript">

    /** Operações realizadas antes do envio da requisição */
    function beforeSendRequest(target) {

        /** ParÂmetros de entrada */
        var password = document.getElementById('password').value;
        var passwordConfirm = document.getElementById('password_confirm').value;

        /** Verifico se as senhas são iguais */
        if (password === passwordConfirm)
        {

            /** Envio de requisição */
            SendRequest(target, {target : 'UsersRegisterNewPasswordMessages', 'block' : {create : true, info : null, sec : null, target : 'UsersRegisterNewPasswordMessages', data : 'Aguarde', color : 'blue', type : 'circle', size : 'sm', message : true}});

        }
        else{

            /** Carrego o conteúdo **/
            $('#UsersRegisterNewPasswordMessages').html('As senhas informadas não são iguais');

        }

    }

</script>
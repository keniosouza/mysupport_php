<?php

/** Importação de classes */
use \vendor\controller\main\Main;
use \vendor\model\Users;
use \vendor\controller\users\UsersValidate;

/** Instânciamento de classes */
$Main = new Main();
$Users = new Users();
$UsersValidate = new UsersValidate();

/** Operações */
$Main->SessionStart();

/** Tratamento dos dados de entrada */
$UsersValidate->setUsersId(@(int)$_SESSION['USERSID']);
$UsersValidate->setCompanyId(@(int)$_SESSION['USERSCOMPANYID']);

/** Verifico se existe registro */
if ($UsersValidate->getUsersId() > 0) {

    /** Busco o usuário desejado */
    $resultUsers = $Users->Get($UsersValidate->getUsersId());

}

?>

<ul class="nav nav-pills nav-fill animate slideIn" id="pills-tab">

    <li class="nav-item rounded border me-1">

        <a class="nav-link active" id="pills-general-tab" data-bs-toggle="pill" href="#pills-general">

            <i class="bi bi-folder2-open me-1"></i>Geral

        </a>

    </li>

    <li class="nav-item rounded border me-1">

        <a class="nav-link" id="pills-password-tab" data-bs-toggle="pill" href="#pills-password">

            <i class="bi bi-folder2 me-1"></i>Senha

        </a>

    </li>

</ul>

<div class="tab-content pt-1" id="pills-tabContent">

    <div class="tab-pane fade active show" id="pills-general">

        <div class="card">

            <div class="card-body">

                <form id="UsersProfileForm">

                    <div class="row g-2">

                        <div class="col-md-3">

                            <div class="form-group">

                                <label for="name_first">

                                    Nome

                                </label>

                                <input type="text" class="form-control form-control-solid" id="name_first" name="name_first" value="<?php echo $Main->decryptData($resultUsers->name_first) ?>">

                            </div>

                        </div>

                        <div class="col-md-3">

                            <div class="form-group">

                                <label for="name_last">

                                    Sobre Nome

                                </label>

                                <input type="text" class="form-control form-control-solid" id="name_last" name="name_last" value="<?php echo $Main->decryptData($resultUsers->name_last) ?>">

                            </div>

                        </div>

                        <div class="col-md-3">

                            <div class="form-group">

                                <label for="birth_date">

                                    Nascimento

                                </label>

                                <input type="date" class="form-control form-control-solid" name="birth_date" id="birth_date" value="<?php echo !empty(@(string)$resultUsers->birth_date) ? date('Y-m-d', strtotime(@(string)$resultUsers->birth_date)) : null; ?>"/>

                            </div>

                        </div>

                        <div class="col-md-3">

                            <div class="form-group">

                                <label for="genre">

                                    Sexo:

                                </label>

                                <select class="form-control form-control-solid form-control form-select form-control-solid" id="genre" name="genre">

                                    <option value="" selected>

                                        Selecione

                                    </option>

                                    <option value="M" <?php echo $resultUsers->genre === 'M' ? 'selected' : ''; ?>>

                                        Masculino

                                    </option>

                                    <option value="F" <?php echo $resultUsers->genre === 'F' ? 'selected' : ''; ?>>

                                        Feminino

                                    </option>

                                </select>

                            </div>

                        </div>

                        <div class="col-md-12" id="UsersProfileFormMessage"></div>

                        <div class="col-md-12 text-end">

                            <div class="form-group mb-0">

                                <button type="button" class="btn btn-primary w-100 mt-3" onclick="SendRequest('UsersProfileForm', {target : 'UsersProfileFormMessage', block : {create : true, info : null, sec : null, target : 'UsersProfileFormMessage', data : 'Aguarde...', color : 'blue', type : 'circle', size : 'sm', message : true}});">

                                    <i class="bi bi-check me-1"></i>Salvar

                                </button>

                            </div>

                        </div>

                    </div>

                    <input type="hidden" name="TABLE" value="users"/>
                    <input type="hidden" name="ACTION" value="users_profile_save"/>
                    <input type="hidden" name="FOLDER" value="action"/>
                    <input type="hidden" name="users_id" value="<?php echo $UsersValidate->getUsersId(); ?>"/>
                    <input type="hidden" name="company_id" value="<?php echo $UsersValidate->getCompanyId(); ?>"/>

                </form>

            </div>

        </div>

    </div>

    <div class="tab-pane fade" id="pills-password">

        <div class="card">

            <div class="card-body">

                <form id="UsersProfileFormPassword">

                    <div class="row g-2">

                        <div class="col-md-6">

                            <div class="form-group">

                                <label for="password">

                                    Senha

                                </label>

                                <input type="password" class="form-control form-control-solid" id="password" name="password">

                            </div>

                        </div>

                        <div class="col-md-6">

                            <div class="form-group">

                                <label for="password_confirm">

                                    Confirmar Senha

                                </label>

                                <input type="password" class="form-control form-control-solid" id="password_confirm" name="password_confirm">

                            </div>

                        </div>

                        <div class="col-md-12" id="UsersProfileFormPasswordMessage"></div>

                        <div class="col-md-12 text-end">

                            <div class="form-group mb-0">

                                <button type="button" class="btn btn-primary w-100 mt-3" onclick="beforeSendRequest();">

                                    <i class="bi bi-check me-1"></i>Salvar

                                </button>

                            </div>

                        </div>

                    </div>

                    <input type="hidden" name="FOLDER" value="ACTION" />
                    <input type="hidden" name="TABLE" value="USERS" />
                    <input type="hidden" name="USER_ID" value="<?php echo $resultUsers->users_id?>" />
                    <input type="hidden" name="ACTION" value="USERS_REGISTER_NEW_PASSWORD" />

                </form>

            </div>

        </div>

    </div>

</div>

<script type="text/javascript">

    /** Operações realizadas antes do envio da requisição */
    function beforeSendRequest() {

        /** ParÂmetros de entrada */
        var password = document.getElementById('password').value;
        var passwordConfirm = document.getElementById('password_confirm').value;

        /** Verifico se as senhas são iguais */
        if (password === passwordConfirm)
        {

            /** Envio de requisição */
            SendRequest('UsersProfileFormPassword', {target : 'UsersProfileFormPasswordMessage', 'block' : {create : true, info : null, sec : null, target : 'UsersProfileFormPasswordMessage', data : 'Aguarde', color : 'blue', type : 'circle', size : 'sm', message : true}});

        }
        else{

            /** Carrego o conteúdo **/
            $('#UsersProfileFormPasswordMessage').html('As senhas informadas não são iguais');

        }

    }

</script>

<?php

/** Prego a estrutura do arquivo */
$html = ob_get_contents();

/** Removo o arquivo incluido */
ob_clean();

/** Result **/
$result = array(

    'code' => 201,
    'title' => 'Chamados / Perfil / Edição /',
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

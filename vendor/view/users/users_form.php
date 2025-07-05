<?php

/** Importação de classes */
use vendor\model\Users;
use vendor\controller\users\UsersValidate;
use \vendor\model\UsersAcls;
use \vendor\controller\users_acls\UsersAclsValidate;

/** Instânciamento de classes  */
$Users = new Users();
$UsersValidate = new UsersValidate();
$UsersAcls = new UsersAcls();
$UsersAclsValidate = new UsersAclsValidate();

/** Parametros de entrada */
$usersId = isset($_POST['USER_ID']) ? (int)filter_input(INPUT_POST, 'USER_ID', FILTER_SANITIZE_SPECIAL_CHARS)   : 0;

/** Validando os campos de entrada */
$UsersValidate->setUsersId($usersId);
$UsersAclsValidate->setUsersId($usersId);

/** Verifico se existe registro */
if ($UsersAclsValidate->getUsersId() > 0) {

    /** Busca de registro */
    $resultUsersAcls = $UsersAcls->All($UsersValidate->getUsersId());

}

/** Verifica se o ID do usuário foi informado */
if ($UsersValidate->getUsersId() > 0) {

    /** Consulta os dados do usuário */
    $UsersResult = $Users->Get($UsersValidate->getUsersId());

} ?>

<ul class="nav nav-pills nav-fill animate slideIn" id="pills-tab">

    <li class="nav-item rounded border me-1">

        <a class="nav-link active" id="pills-general-tab" data-bs-toggle="pill" href="#pills-general">

            <i class="bi bi-eye me-1"></i>Geral

        </a>

    </li>

    <li class="nav-item rounded border me-1">

        <a class="nav-link" id="pills-password-tab" data-bs-toggle="pill" href="#pills-password">

            <i class="bi bi-key me-1"></i>Senha

        </a>

    </li>

    <li class="nav-item rounded border me-1">

        <a class="nav-link" id="pills-modules-tab" data-bs-toggle="pill" href="#pills-modules">

            <i class="bi bi-slash-circle me-1"></i>Permissões

        </a>

    </li>

</ul>

<div class="tab-content pt-1" id="pills-tabContent">

    <div class="tab-pane fade active show" id="pills-general">

        <div class="card shadow-sm animate slideIn">

            <div class="card-body">

                <form id="UsersFormGeneral">

                    <div class="row g-1">

                        <div class="col-md-6">

                            <div class="form-group">

                                <label for="name_first">

                                    Nome

                                </label>

                                <input type="text" class="form-control form-control-solid" id="name_first" name="name_first" value="<?php echo !empty($UsersResult->name_first) ? $Main->decryptData($UsersResult->name_first) : ''; ?>">

                            </div>

                        </div>

                        <div class="col-md-6">

                            <div class="form-group">

                                <label for="name_last">

                                    Sobrenome

                                </label>

                                <input type="text" class="form-control form-control-solid" id="name_last" name="name_last" value="<?php echo !empty($UsersResult->name_last) ? $Main->decryptData($UsersResult->name_last) : ''; ?>">

                            </div>

                        </div>

                        <div class="col-md-12">

                            <div class="form-group">

                                <label for="email">

                                    E-mail

                                </label>

                                <input type="text" class="form-control form-control-solid" id="email" name="email" value="<?php echo $UsersResult->email; ?>">

                            </div>

                        </div>

                        <div class="col-md-3">

                            <div class="form-group">

                                <label for="birth_date">

                                    Data de nascimento:

                                </label>

                                <input type="date" class="form-control form-control-solid" id="birth_date" name="birth_date" value="<?php echo !empty($UsersResult->birth_date) ? date('Y-m-d', strtotime($UsersResult->birth_date)) : ''; ?>">

                            </div>

                        </div>

                        <div class="col-md-3">

                            <div class="form-group">

                                <label for="genre">

                                    Sexo

                                </label>

                                <select class="form-control form-control-solid" id="genre" name="genre">

                                    <option value="" selected>Selecione</option>
                                    <option value="M" <?php echo $UsersResult->genre === 'M' ? 'selected' : ''; ?>>Masculino</option>
                                    <option value="F" <?php echo $UsersResult->genre === 'F' ? 'selected' : ''; ?>>Feminino</option>

                                </select>

                            </div>

                        </div>

                        <div class="col-md-3">

                            <div class="form-group">

                                <label for="active">

                                    Ativo

                                </label>

                                <select class="form-control form-control-solid" id="active" name="active">

                                    <option value="" selected>Selecione</option>
                                    <option value="S" <?php echo $UsersResult->active === 'S' ? 'selected' : ''; ?>>Sim</option>
                                    <option value="N" <?php echo $UsersResult->active === 'N' ? 'selected' : ''; ?>>Não</option>

                                </select>

                            </div>

                        </div>

                        <div class="col-md-3">

                            <div class="form-group">

                                <label for="administrator">

                                    Administrador

                                </label>

                                <select class="form-control form-control-solid" id="administrator" name="administrator">
                                    <option value="" selected>Selecione</option>
                                    <option value="S" <?php echo $UsersResult->administrator === 'S' ? 'selected' : ''; ?>>Sim</option>
                                    <option value="N" <?php echo $UsersResult->administrator === 'N' ? 'selected' : ''; ?>>Não</option>
                                </select>

                            </div>

                        </div>

                        <div class="col-md-12" id="UsersFormGeneralMessage"></div>

                        <div class="col-md-12 text-end">

                            <div class="form-group mb-0">

                                <button type="button" class="btn btn-primary w-100 mt-3" onclick="SendRequest('UsersFormGeneral', {target : 'UsersFormGeneralMessage', block : {create : true, info : null, sec : null, target : 'UsersFormGeneralMessage', data : 'Aguarde...', color : 'blue', type : 'circle', size : 'sm', message : true}});">

                                    <i class="bi bi-check me-1"></i>Salvar

                                </button>

                            </div>

                        </div>

                    </div>

                    <input type="hidden" name="TABLE" value="users"/>
                    <input type="hidden" name="ACTION" value="users_save"/>
                    <input type="hidden" name="FOLDER" value="action"/>
                    <input type="hidden" name="users_id" value="<?php echo $UsersValidate->getUsersId(); ?>"/>

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
                    <input type="hidden" name="USER_ID" value="<?php echo $UsersResult->users_id?>" />
                    <input type="hidden" name="ACTION" value="USERS_REGISTER_NEW_PASSWORD" />

                </form>

            </div>

        </div>

    </div>

    <div class="tab-pane fade" id="pills-modules" role="tabpanel" aria-labelledby="pills-modules-tab">

        <script type="text/javascript">

            /** Envio de Requisição */
            SendRequest('FOLDER=VIEW&TABLE=USERS_ACLS&ACTION=USERS_ACLS_DATAGRID&USERS_ID=<?php echo $UsersResult->users_id?>', {target : 'pills-modules', block : {create : true, info : null, sec : null, target : 'pills-modules', data : 'Aguarde', color : 'blue', type : 'circle', size : 'sm', message : true}});

        </script>

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
    'title' => 'Usuários / Detalhes / Formulário /',
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

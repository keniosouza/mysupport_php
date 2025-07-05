<div class="col-md-12 text-center animate slideIn">

    <img src="image/logo.png" width="50px"> | <img src="image/favicon.png" width="50px">

    <div class="my-3">

        <h4 class="">

            Realize o seu cadastro no

            <b>

                MySupport

            </b>

        </h4>

    </div>

</div>

<div class="col-md-5 mx-auto animate slideIn">

    <div class="card shadow-sm">

        <div class="card-body">

            <form class="row" role="form" id="UsersRegister">

                <div class="col-md-6 mb-3">

                    <div class="form-group">

                        <label for="name_first">

                            Nome: <span class="text-danger">*</span>

                        </label>

                        <input type="text" class="form-control form-control-solid" name="name_first" id="name_first">

                    </div>

                </div>

                <div class="col-md-6 mb-3">

                    <div class="form-group">

                        <label for="name_last">

                            Sobrenome: <span class="text-danger">*</span>

                        </label>

                        <input type="text" class="form-control form-control-solid" name="name_last" id="name_last">

                    </div>

                </div>

                <div class="col-md-12 mb-3">

                    <div class="form-group">

                        <label for="email">

                            Email: <span class="text-danger">*</span>

                        </label>

                        <input type="text" class="form-control form-control-solid" name="email" id="email">

                    </div>

                </div>

                <div class="col-md-6 mb-3">

                    <div class="form-group">

                        <label for="password">

                            Senha: <span class="text-danger">*</span>

                        </label>

                        <input type="password" class="form-control form-control-solid" name="password" id="password">

                    </div>

                </div>

                <div class="col-md-6 mb-3">

                    <div class="form-group">

                        <label for="password_confirm">

                            Confirmação de Senha: <span class="text-danger">*</span>

                        </label>

                        <input type="password" class="form-control form-control-solid" name="password_confirm" id="password_confirm">

                    </div>

                </div>

                <div class="col-md-12">

                    <button type="button" class="btn btn-primary w-100" onclick="beforeSendRequest()">

                        <i class="bi bi-send-fill me-1"></i>Enviar

                    </button>

                </div>

                <input type="hidden" name="FOLDER" value="ACTION" />
                <input type="hidden" name="TABLE" value="USERS" />
                <input type="hidden" name="ACTION" value="USERS_REGISTER" />

            </form>

        </div>

    </div>

    <button type="button" class="btn btn-outline-primary w-100 mt-3" onclick="SendRequest('FOLDER=VIEW&TABLE=USERS&ACTION=USERS_LOGIN', {target : null, block : {create : true, info : null, sec : null, target : null, data : 'Aguarde', color : 'blue', type : 'circle', size : 'sm', message : true}});">

        Já possui cadastro? <b>Realize o login</b>

    </button>

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
            SendRequest('UsersRegister', {target : null, block : {create : true, info : null, sec : null, target : null, data : 'Aguarde', color : 'blue', type : 'circle', size : 'sm', message : true}});

        }
        else{

            /** Carrego o conteúdo **/
            modalConstruct(true, 'Atenção', 'As senhas informadas não são iguais', 'md', null, null, 'alert', null, null);

        }

    } 

</script>
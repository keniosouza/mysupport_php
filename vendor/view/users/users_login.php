<div class="col-md-12 text-center animate slideIn mt-3">

    <img src="image/logo.png" width="50px"> | <img src="image/favicon.png" width="50px">

    <div class="my-3">

        <h4 class="">

            Faça login no

            <b>

                MySupport

            </b>

        </h4>

    </div>

</div>

<div class="col-md-5 mx-auto animate slideIn">

    <div class="card shadow-sm">

        <div class="card-body">

            <form class="row" role="form" id="UsersLoginForm">

                <div class="col-md-12 mb-3">

                    <div class="form-group">

                        <label for="email">

                            Email <span class="text-danger">*</span>

                        </label>

                        <input type="text" class="form-control form-control-solid" name="email" id="email">

                    </div>

                </div>

                <div class="col-md-12 mb-3">

                    <div class="form-group">

                        <label for="password">

                            Senha <span class="text-danger">*</span>

                        </label>

                        <input type="password" class="form-control form-control-solid" name="password" id="password">

                    </div>

                </div>

                <div class="col-md-12">

                    <button type="button" id="UsersLoginButton" class="btn btn-primary w-100" onclick="SendRequest('UsersLoginForm', {target : null, loader : {create: true, type: 3, target : 'UsersLoginButton', data : 'Aguarde...'}});">

                        <i class="bi bi-send-fill me-1"></i>Acessar

                    </button>

                </div>

                <div class="col-md-12 text-end">

                    <a href="#" onclick="SendRequest('FOLDER=VIEW&TABLE=USERS&ACTION=USERS_REQUEST_NEW_PASSWORD', {target : null, block : {create : true, info : null, sec : null, target : null, data : 'Aguarde', color : 'blue', type : 'circle', size : 'sm', message : true}});">

                        Esqueci a <b>senha</b>

                    </a>

                </div>

                <input type="hidden" name="FOLDER" value="ACTION" />
                <input type="hidden" name="TABLE" value="USERS" />
                <input type="hidden" name="ACTION" value="USERS_ACCESS" />

            </form>

        </div>

    </div>

    <button type="button" class="btn btn-outline-primary w-100 mt-3" onclick="SendRequest('FOLDER=VIEW&TABLE=USERS&ACTION=USERS_REGISTER', {target : null, block : {create : true, info : null, sec : null, target : null, data : 'Aguarde', color : 'blue', type : 'circle', size : 'sm', message : true}});">

        Novo no MySupport? <b>Crie uma conta</b>

    </button>

</div>
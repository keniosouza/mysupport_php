<div class="col-md-12 text-center animate slideIn">

    <img src="image/logo.png" width="50px"> | <img src="image/favicon.png" width="50px">

    <div class="my-3">

        <h4 class="">

            Recuperação de

            <b>

                Senha

            </b>

        </h4>

    </div>

</div>

<div class="col-md-5 mx-auto animate slideIn">

    <div class="card shadow-sm">

        <div class="card-body">

            <form class="row" role="form" id="UsersRequestNewPasswordForm">

                <div class="col-md-12 mb-3">

                    <div class="form-group">

                        <label for="email">

                            Email <span class="text-danger">*</span>

                        </label>

                        <input type="text" class="form-control form-control-solid" name="email" id="email">

                    </div>

                </div>

                <div class="col-md-12">

                    <button type="button" class="btn btn-primary w-100" onclick="SendRequest('UsersRequestNewPasswordForm', {target : null, block : {create : true, info : null, sec : null, target : null, data : 'Aguarde', color : 'blue', type : 'circle', size : 'sm', message : true}});">

                        <i class="bi bi-send-fill me-1"></i>Solicitar

                    </button>

                </div>

                <input type="hidden" name="FOLDER" value="ACTION" />
                <input type="hidden" name="TABLE" value="USERS" />
                <input type="hidden" name="ACTION" value="USERS_REQUEST_NEW_PASSWORD" />

            </form>

        </div>

    </div>

    <button type="button" class="btn btn-outline-primary w-100 mt-3" onclick="SendRequest('FOLDER=VIEW&TABLE=USERS&ACTION=USERS_LOGIN', {target : null, block : {create : true, info : null, sec : null, target : null, data : 'Aguarde', color : 'blue', type : 'circle', size : 'sm', message : true}});">

        Já possui cadastro? <b>Realize o login</b>

    </button>

</div>
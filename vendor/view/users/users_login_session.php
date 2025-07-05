<div class="card shadow-sm">

    <div class="card-body">

        <form class="row" role="form" id="UsersLoginForm">

            <div class="col-md-12 mb-3">

                <div class="form-group">

                    <label for="email">

                        Nome de Usuário <span class="text-danger">*</span>

                    </label>

                    <input type="text" class="form-control form-control-solid" name="email" id="email">

                </div>

            </div>

            <div class="col-md-12 mb-3">

                <div class="form-group">

                    <label for="password">

                        Senha para acesso <span class="text-danger">*</span>

                    </label>

                    <input type="password" class="form-control form-control-solid" name="password" id="password">

                </div>

            </div>

            <div class="col-md-12">

                <button type="button" class="btn btn-primary w-100" onclick="SendRequest('UsersLoginForm', {target : null, block : {create : true, info : null, sec : null, target : null, data : 'Aguarde', color : 'blue', type : 'circle', size : 'sm', message : true}});">

                    <i class="bi bi-send-fill me-1"></i>Acessar

                </button>

            </div>

            <input type="hidden" name="FOLDER" value="ACTION" />
            <input type="hidden" name="TABLE" value="USERS" />
            <input type="hidden" name="ACTION" value="USERS_ACCESS" />
            <input type="hidden" name="SESSION" value="true" />

        </form>

    </div>

</div>

<?php

/** Prego a estrutura do arquivo */
$html = ob_get_contents();

/** Removo o arquivo incluido */
ob_clean();

/** Result **/
$result = array(

    'code' => 201,
    'title' => 'Usuário / Login',
    'data' => $html,
    'size' => 'md',
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

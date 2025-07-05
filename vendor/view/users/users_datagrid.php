<?php

/** Importação de classes */
use vendor\model\Users;

/** Instânciamento de classes */
$Users = new Users();

/** Consulta os usuário cadastrados*/
$UsersAllResult = $Users->All($_SESSION['USERSCOMPANYID']);

?>

<h5 class="card-title">

    Usuários /

</h5>

<?php

/** Verifico a quantidade de registros localizados */
if (count($UsersAllResult) > 0) {

    /** Listo todos os registros de produtos */
    foreach ($UsersAllResult as $Key => $Result) {

        /** Crio o nome da função */
        $Result->delete = 'users_delete_' . $Key . '_' . rand(1, 1000);

        /** Verifico o status do usuário */
        $Result->phrase = $Result->active === 'S' ? 'Ativo' : 'Inativo';
        $Result->class = $Result->active === 'S' ? 'primary' : 'danger';

        ?>

        <div class="card mb-1 animate slideIn">

            <div class="card-body">

                <div class="row">

                    <div class="col-md my-auto">

                        <h5>

                            #<?php echo @(string)$Result->users_id ?>

                            -

                            <span class="badge rounded-pill bg-<?php echo @(string)$Result->class; ?> mt-2">

                                <?php echo @(string)$Result->phrase; ?>

                            </span>

                            -

                            <?php echo $Main->decryptData(@(string)$Result->name_first); ?> <?php echo $Main->decryptData(@(string)$Result->name_last); ?>

                        </h5>

                    </div>

                    <div class="col-md my-auto">

                        <div class="btn-group w-100 text-break">

                            <button type="button" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Tooltip on top" onclick="SendRequest('FOLDER=view&TABLE=USERS&ACTION=USERS_PROFILE&USER_ID=<?php echo (@(int)$Result->users_id) ?>', {target : null, block : {create : true, info : null, sec : null, target : null, data : 'Aguarde', color : 'blue', type : 'circle', size : 'sm', message : true}});">

                                <i class="bi bi-eye me-1"></i>Detalhes

                            </button>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    <?php } ?>

    <?php

} else { ?>

    <div class="card shadow-sm animate slideIn">

        <div class="card-body text-center">

            <h1 class="card-title text-center">

                <span class="badge rounded-pill text-bg-primary">

                    U-1

                </span>

            </h1>

            <h4 class="card-subtitle text-center text-muted">

                Ainda não forma cadastrados usuários.

            </h4>

        </div>

    </div>

<?php } ?>
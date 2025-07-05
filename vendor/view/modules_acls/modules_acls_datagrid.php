<?php

/** Importação de classes */
use \vendor\model\ModulesAcls;
use \vendor\controller\modules_acls\ModulesAclsValidate;

/** Instânciamento de classes */
$ModulesAcls = new ModulesAcls();
$ModulesAclsValidate = new ModulesAclsValidate();

/** Parâmetros de entrada */
$ModulesAclsValidate->setModulesId((int)filter_input(INPUT_POST, 'MODULES_ID', FILTER_SANITIZE_SPECIAL_CHARS));

/** Busco todos os registros */
$ModulesAclsAllResult = $ModulesAcls->All($ModulesAclsValidate->getModulesId());

?>

<?php

/** Verifico se existem registros */
if (count($ModulesAclsAllResult) > 0) { ?>

    <div class="card animate slideIn">

        <div class="card-body">

            <button class="btn btn-primary btn-sm w-100" onclick="SendRequest('FOLDER=VIEW&TABLE=MODULES_ACLS&ACTION=MODULES_ACLS_FORM&MODULES_ID=<?php echo $ModulesAclsValidate->getModulesId() ?>', {target : 'ModulesAclDatagridOrForm', block : {create : true, info : null, sec : null, target : 'ModulesAclDatagridOrForm', data : 'Aguarde', color : 'blue', type : 'circle', size : 'sm', message : true}});">

                <i class="bi bi-plus me-1"></i>Níveis de Acesso

            </button>

            <div class="row g-1 mt-2">

                <?php

                /** Consulta os usuário cadastrados*/
                foreach ($ModulesAclsAllResult as $key => $result) {?>

                    <div class="col-md-3 d-flex">

                        <div class="card w-100">

                            <div class="card-body">

                                <h6 class="card-title">

                                    <?php echo $result->description?>

                                </h6>

                               <ul>

                                   <?php

                                   /** Consulta os usuário cadastrados*/
                                   foreach (json_decode($result->preferences) as $keyPreferences => $resultPreferences) {?>

                                       <li>

                                           <?php echo $resultPreferences?>

                                       </li>

                                   <?php }?>

                               </ul>

                            </div>

                            <div class="card-footer border-0 bg-transparent">

                                <div class="btn-group btn-group-sm w-100 text-break">

                                    <button class="btn btn-primary" onclick="SendRequest('FOLDER=VIEW&TABLE=MODULES_ACLS&ACTION=MODULES_ACLS_FORM&MODULES_ID=<?php echo $ModulesAclsValidate->getModulesId() ?>&MODULES_ACLS_ID=<?php echo @(int)$result->modules_acls_id?>', {target : 'ModulesAclDatagridOrForm', block : {create : true, info : null, sec : null, target : 'ModulesAclDatagridOrForm', data : 'Aguarde', color : 'blue', type : 'circle', size : 'sm', message : true}});">

                                        <i class="bi bi-pencil me-1"></i>Editar

                                    </button>

                                    <button class="btn btn-primary" onclick="SendRequest('FOLDER=ACTION&TABLE=MODULES_ACLS&ACTION=MODULES_ACLS_DELETE&MODULES_ID=<?php echo @(int)$result->modules_id?>&MODULES_ACLS_ID=<?php echo @(int)$result->modules_acls_id?>', {target : null, block : {create : true, info : null, sec : null, target : null, data : 'Aguarde', color : 'blue', type : 'circle', size : 'sm', message : true}});">

                                        <i class="bi bi-fire me-1"></i>Remover

                                    </button>

                                </div>

                            </div>

                        </div>

                    </div>

                <?php }?>

            </div>

        </div>

    </div>

    <?php

} else { ?>

    <div class="col-md-12 animate slideIn">

        <div class="card shadow-sm ">

            <div class="card-body text-center">

                <button class="btn btn-primary btn-sm w-100" onclick="SendRequest('FOLDER=VIEW&TABLE=MODULES_ACLS&ACTION=MODULES_ACLS_FORM&MODULES_ID=<?php echo $ModulesAclsValidate->getModulesId() ?>', {target : 'ModulesAclDatagridOrForm', block : {create : true, info : null, sec : null, target : 'ModulesAclDatagridOrForm', data : 'Aguarde', color : 'blue', type : 'circle', size : 'sm', message : true}});">

                    <i class="bi bi-plus me-1"></i>Níveis de Acesso

                </button>

                <h1 class="card-title text-center">

                    <span class="badge rounded-pill text-bg-primary">

                        M-1

                    </span>

                </h1>

                <h4 class="card-subtitle text-center text-muted">

                    Ainda não foram cadastrado módulos.

                </h4>

            </div>

        </div>

    </div>

<?php } ?>
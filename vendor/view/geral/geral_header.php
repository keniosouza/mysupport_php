<div class="p-2 sticky-top">

    <nav class="navbar navbar-expand-lg border shadow-sm bg-glass rounded">

        <div class="container">

            <a class="navbar-brand" href="<?php echo $Config->app->url_aplication ?>">

                <img src="image/logo.png" alt="MySupport | Gestor Empresarial" width="35" class="me-1">|<img src="image/favicon.png" alt="MySupport | Gestor Empresarial" width="40" class="me-1">

                MySupport

            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">

                <span class="navbar-toggler-icon"></span>

            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">

                <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                    <li class="nav-item">

                        <a class="nav-link" href="#" onclick="SendRequest('FOLDER=VIEW&TABLE=CALLS&ACTION=CALLS_DATAGRID', {target : null, loader : {create: true, padding: '0px', type: 2, target : 'wrapper', data : 'Aguarde...'}});">

                            <i class="bi bi-ticket-fill me-1"></i>Chamados

                        </a>

                    </li>

                    <?php

                    /** Verifico se a permissão */
                    if (@(string)$resultUserAcl->produtos->ler === 'true') { ?>

                        <li class="nav-item">

                            <a class="nav-link" href="#" onclick="SendRequest('FOLDER=VIEW&TABLE=PRODUCTS&ACTION=PRODUCTS_DATAGRID', {target : null, loader : {create: true, padding: '0px', type: 2, target : 'wrapper', data : 'Aguarde...'}});">

                                <i class="bi bi-archive-fill me-1"></i>Produtos

                            </a>

                        </li>

                    <?php } ?>

                    <?php

                    /** Verifico se a permissão */
                    if (@(string)$resultUserAcl->administrativo->ler === 'true') { ?>

                        <li class="nav-item">

                            <a class="nav-link" href="#" onclick="SendRequest('FOLDER=VIEW&TABLE=USERS&ACTION=USERS_DATAGRID', {target : null, loader : {create: true, padding: '0px', type: 2, target : 'wrapper', data : 'Aguarde...'}});">

                                <i class="bi bi-person-fill me-1"></i>Usuários

                            </a>

                        </li>

                    <?php } ?>

                    <?php

                    /** Verifico se a permissão */
                    if (@(string)$resultUserAcl->clientes->ler === 'true') { ?>

                        <li class="nav-item">

                            <a class="nav-link" href="#" onclick="SendRequest('FOLDER=VIEW&TABLE=CLIENTS&ACTION=CLIENTS_DATAGRID', {target : null, loader : {create: true, padding: '0px', type: 2, target : 'wrapper', data : 'Aguarde...'}});">

                                <i class="bi bi-building me-1"></i>Clientes

                            </a>

                        </li>

                    <?php } ?>

                    <?php

                    /** Verifico se a permissão */
                    if (@(string)$resultUserAcl->administrativo->ler === 'true') { ?>

                        <li class="nav-item">

                            <a class="nav-link" href="#" onclick="SendRequest('FOLDER=VIEW&TABLE=MODULES&ACTION=MODULES_DATAGRID', {target : null, loader : {create: true, padding: '0px', type: 2, target : 'wrapper', data : 'Aguarde...'}});">

                                <i class="bi bi-ui-checks-grid me-1"></i>Modulos

                            </a>

                        </li>

                    <?php } ?>

                    <li class="nav-item">

                        <a class="nav-link" href="#" onclick="SendRequest('FOLDER=VIEW&TABLE=GERAL&ACTION=GERAL_OVERVIEW', {target : null, loader : {create: true, padding: '0px', type: 2, target : 'wrapper', data : 'Aguarde...'}});">

                            <i class="bi bi-list-task me-1"></i>Atividades

                        </a>

                    </li>

                    <?php

                    /** Verifico se a permissão */
                    if (@(string)$resultUserAcl->desenvolvimento->ler === 'true') { ?>

                        <li class="nav-item">

                            <a class="nav-link" href="#" onclick="SendRequest('FOLDER=VIEW&TABLE=FILES&ACTION=FILES_OVERVIEW', {target : null, loader : {create: true, padding: '0px', type: 2, target : 'wrapper', data : 'Aguarde...'}});">

                                <i class="bi bi-folder-fill me-1"></i>Arquivos

                            </a>

                        </li>

                    <?php } ?>

                    <?php

                    /** Verifico se a permissão */
                    if (@(string)$resultUserAcl->desenvolvimento->ler === 'true') { ?>

                        <li class="nav-item">

                            <a class="nav-link" href="#" onclick="SendRequest('FOLDER=VIEW&TABLE=EMAILS&ACTION=EMAILS_INBOX', {target : null, loader : {create: true, padding: '0px', type: 2, target : 'wrapper', data : 'Aguarde...'}});">

                                <i class="bi bi-envelope-at me-1"></i>Emails

                            </a>

                        </li>

                    <?php } ?>

                    <?php

                    /** Verifico se a permissão */
                    if (@(string)$resultUserAcl->desenvolvimento->ler === 'true') { ?>

                        <li class="nav-item">

                            <a class="nav-link" href="#" onclick="SendRequest('FOLDER=VIEW&TABLE=CLIENTS_LOGS&ACTION=CLIENTS_LOGS_DASHBOARD', {target : null, loader : {create: true, padding: '0px', type: 2, target : 'wrapper', data : 'Aguarde...'}});">

                                <i class="bi bi-speedometer me-1"></i>Analytics

                            </a>

                        </li>

                    <?php } ?>

                    <?php

                    /** Verifico se a permissão */
                    if (@(string)$resultUserAcl->desenvolvimento->ler === 'true') { ?>

                        <li class="nav-item">

                            <a class="nav-link" href="#" onclick="SendRequest('FOLDER=VIEW&TABLE=CLIENTS_LOGS&ACTION=CLIENTS_LOGS_PANEL', {target : null, loader : {create: true, padding: '0px', type: 2, target : 'wrapper', data : 'Aguarde...'}});">

                                <i class="bi bi-display me-1"></i>Painel

                            </a>

                        </li>

                    <?php } ?>

                </ul>

                <ul class="navbar-nav ms-auto">

                    <li class="nav-item">

                        <a class="nav-link" href="#" onclick="SendRequest('FOLDER=VIEW&TABLE=USERS&ACTION=USERS_PROFILE', {target : null, loader : {create: true, padding: '0px', type: 2, target : 'wrapper', data : 'Aguarde...'}});">

                            <i class="bi bi-person-circle me-1"></i><?php echo (string)$_SESSION['USERSNAMEFIRST']?>

                        </a>

                    </li>

                </ul>

            </div>

        </div>

    </nav>

</div>
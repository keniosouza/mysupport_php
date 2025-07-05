<h5 class="card-title">

    Chamados /

</h5>

<ul class="nav nav-pills nav-fill" id="pills-tab">

    <?php

    /** Verifico se a permissão */
    if (@(string)$resultUserAcl->chamado->criar === 'true') { ?>

        <li class="nav-item rounded border me-1">

            <button class="nav-link" id="CallsFormButton" onclick="SendRequest('FOLDER=VIEW&TABLE=CALLS&ACTION=CALLS_FORM', {target : null, loader : {create: false, padding: '0px', type: 3, target : 'CallsFormButton', data : 'Aguarde...'}});">

                <i class="bi bi-plus me-1"></i>Chamado

            </button>

        </li>

    <?php } ?>

    <li class="nav-item rounded border me-1" onclick="SendRequest('FOLDER=VIEW&TABLE=CALLS&ACTION=CALLS_DATAGRID_SITUATION&SITUATION=1', {target : 'pills-opened', loader : {create: true, padding: '0px', type: 2, target : 'pills-opened', data : 'Aguarde...'}});">

        <a class="nav-link active" id="pills-opened-tab" data-bs-toggle="pill" href="#pills-opened">

            <i class="bi bi-folder2-open me-1"></i>Abertos

        </a>

    </li>

    <li class="nav-item rounded border me-1" onclick="SendRequest('FOLDER=VIEW&TABLE=CALLS&ACTION=CALLS_DATAGRID_SITUATION&SITUATION=2', {target : 'pills-closed', loader : {create: true, padding: '0px', type: 2, target : 'pills-closed', data : 'Aguarde...'}});">

        <a class="nav-link" id="pills-closed-tab" data-bs-toggle="pill" href="#pills-closed">

            <i class="bi bi-folder2 me-1"></i>Encerrados

        </a>

    </li>

    <li class="nav-item rounded border" >

        <a class="nav-link" id="pills-calendar-tab" data-bs-toggle="pill" href="#pills-calendar" onclick="SendRequest('FOLDER=VIEW&TABLE=CALLS&ACTION=CALLS_CALENDAR', {target : 'pills-calendar', loader : {create: true, padding: '0px', type: 2, target : 'pills-calendar', data : 'Aguarde...'}});">

            <i class="bi bi-calendar-week me-1"></i>Calendario

        </a>

    </li>

</ul>

<div class="tab-content" id="pills-tabContent">

    <div class="tab-pane active show" id="pills-opened">

        <script type="text/javascript">

            /** Envio de Requisição */
            SendRequest('FOLDER=VIEW&TABLE=CALLS&ACTION=CALLS_DATAGRID_SITUATION&SITUATION=1', {target : 'pills-opened', block : {create : true, info : null, sec : null, target : 'pills-opened', data : 'Aguarde', color : 'blue', type : 'circle', size : 'sm', message : true}});

        </script>

    </div>

    <!-- Chamados Encerrados -->
    <div class="tab-pane" id="pills-closed"></div>

    <!-- Calendário de Chamados -->
    <div class="tab-pane" id="pills-calendar"></div>

</div>
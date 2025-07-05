<div class="col-md-10">

    <h5 class="card-title">

        Visão Geral /

    </h5>

</div>

<div class="col-md-2 text-end">

    <button type="button" class="btn btn-primary btn-sm mb-0" onclick="SendRequest('FOLDER=VIEW&TABLE=GERAL&ACTION=GERAL_OVERVIEW', {target : null, block : {create : true, info : null, sec : null, target : null, data : 'Aguarde', color : 'blue', type : 'circle', size : 'sm', message : true}});">

        <i class="bi bi-arrow-clockwise me-1"></i>Atualizar

    </button>

</div>

<nav class="navbar navbar-expand-lg shadow-sm border rounded bg-white">

    <div class="container-fluid">

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">

            <span class="navbar-toggler-icon"></span>

        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">

            <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                <li class="nav-item" onclick="SendRequest('FOLDER=VIEW&TABLE=GERAL&ACTION=GERAL_OVERVIEW_CALLS_ACTIVITIES_LIST', {target : 'GeralOverviewCallsActivitiesWrapper', block : {create : true, info : null, sec : null, target : 'GeralOverviewCallsActivitiesWrapper', data : 'Aguarde', color : 'blue', type : 'circle', size : 'sm', message : true}});">

                    <a class="nav-link active">

                        <i class="bi bi-list-ol me-1"></i>Lista

                    </a>

                </li>

                <li class="nav-item" onclick="SendRequest('FOLDER=VIEW&TABLE=GERAL&ACTION=GERAL_OVERVIEW_CALLS_ACTIVITIES_DATAGRID', {target : 'GeralOverviewCallsActivitiesWrapper', block : {create : true, info : null, sec : null, target : 'GeralOverviewCallsActivitiesWrapper', data : 'Aguarde', color : 'blue', type : 'circle', size : 'sm', message : true}});">

                    <a class="nav-link">

                        <i class="bi bi-kanban me-1"></i>Quadro

                    </a>

                </li>

                <li class="nav-item" onclick="SendRequest('FOLDER=VIEW&TABLE=CALLS&ACTION=CALLS_CALENDAR', {target : 'GeralOverviewCallsActivitiesWrapper', block : {create : true, info : null, sec : null, target : 'GeralOverviewCallsActivitiesWrapper', data : 'Aguarde', color : 'blue', type : 'circle', size : 'sm', message : true}});">

                    <a class="nav-link" href="#">

                        <i class="bi bi-calendar-event me-1"></i>Calendário

                    </a>

                </li>

            </ul>

            <form id="CallsActivitiesFormSearch" class="d-flex" role="search">

                <input class="form-control me-2" type="search" placeholder="Livro, Protocolo, Depósito" name="text">
                <button class="btn btn-primary" type="button" onclick="SendRequest('CallsActivitiesFormSearch', {target : 'GeralOverviewCallsActivitiesWrapper', block : {create : true, info : null, sec : null, 'GeralOverviewCallsActivitiesWrapper' : null, data : 'Aguarde...', color : 'blue', type : 'circle', size : 'sm', message : true}});">

                    <i class="bi bi-search"></i>

                </button>

                <input type="hidden" name="FOLDER" value="VIEW" />
                <input type="hidden" name="TABLE" value="CALLS_ACTIVITIES" />
                <input type="hidden" name="ACTION" value="CALLS_ACTIVITIES_SEARCH_DATAGRID" />

            </form>

        </div>

    </div>

</nav>

<!-- Espaço resevardo para listagem de registros -->
<div id="GeralOverviewCallsActivitiesWrapper">

    <script type="text/javascript">

        SendRequest('FOLDER=VIEW&TABLE=GERAL&ACTION=GERAL_OVERVIEW_CALLS_ACTIVITIES_LIST', {target : 'GeralOverviewCallsActivitiesWrapper', block : {create : true, info : null, sec : null, target : 'GeralOverviewCallsActivitiesWrapper', data : 'Aguarde', color : 'blue', type : 'circle', size : 'sm', message : true}});

    </script>

</div>
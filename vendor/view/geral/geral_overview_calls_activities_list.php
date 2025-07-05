<ul class="nav nav-tabs" id="myTab" role="tablist">

    <li class="nav-item" role="presentation">

        <button class="nav-link active" id="tab-1" data-bs-toggle="tab" data-bs-target="#tab-1-pane" type="button" role="tab" aria-controls="tab-1-pane" aria-selected="true">

            Aguardando Conclusão -
            <span class="btn btn-primary btn-sm" onclick="SendRequest('FOLDER=ACTION&TABLE=CALLS_ACTIVITIES&ACTION=CALLS_ACTIVITIES_PDF', {target : null, block : {create : true, info : null, sec : null, target : null, data : 'Aguarde', color : 'blue', type : 'circle', size : 'sm', message : true}});">

                <i class="bi bi-printer"></i>

            </span>

        </button>

    </li>

</ul>

<div class="tab-content" id="myTabContent">

    <div class="tab-pane fade show active" id="tab-1-pane" role="tabpanel" aria-labelledby="tab-1" tabindex="0">

        <script type="text/javascript">

            SendRequest('FOLDER=VIEW&TABLE=GERAL&ACTION=GERAL_OVERVIEW_CALLS_ACTIVITIES_LIST_SITUATION&SITUATION=1', {target : 'tab-1-pane', block : {create : true, info : null, sec : null, target : 'tab-1-pane', data : 'Aguarde', color : 'blue', type : 'circle', size : 'sm', message : true}});

        </script>

    </div>

</div>
<div class="border shadow-sm bg-white animate slideIn p-0">

    <div class="row g-0">

        <div class="col-md border-end custom-scrollbar" id="CallsActivitiesChatList" style="min-height: 600px; max-height: 600px">

            <script type="text/javascript">

                /** Envio de Requisição */
                SendRequest('FOLDER=VIEW&TABLE=CALLS_ACTIVITIES&ACTION=CALLS_ACTIVITIES_CHAT_COL_1', {target : 'CallsActivitiesChatList', block : {create : true, info : null, sec : null, target : 'CallsActivitiesChatList', data : 'Aguarde', color : 'blue', type : 'circle', size : 'sm', message : true}});

            </script>

        </div>

        <div class="col-md-6 border-end custom-scrollbar" id="CallsActivitiesChatMessages" style="min-height: 600px; max-height: 600px">

            <script type="text/javascript">

                /** Envio de Requisição */
                SendRequest('FOLDER=VIEW&TABLE=CALLS_ACTIVITIES&ACTION=CALLS_ACTIVITIES_CHAT_COL_2', {target : 'CallsActivitiesChatMessages', block : {create : true, info : null, sec : null, target : 'CallsActivitiesChatMessages', data : 'Aguarde', color : 'blue', type : 'circle', size : 'sm', message : true}});

            </script>

        </div>

        <div class="col-md-3 custom-scrollbar" id="CallsActivitiesChatDetails" style="min-height: 600px; max-height: 600px"></div>

    </div>

</div>
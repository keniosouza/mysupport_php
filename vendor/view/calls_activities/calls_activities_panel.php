<?php

/** Crio um Id para o painel que sera atualizado constantemente */
$NotificationSend = md5(rand(1, 1000) . date('H:i:s'));

?>

<script type="text/javascript">

    /** Função que será executada a cada minuto */
    function Request<?php echo $NotificationSend?>() {

        /** Obtenho o elemento desejado */
        var element = document.getElementById('CallsActivitiesPanel<?php echo $NotificationSend?>');

        /** Verifico se o elemento existe */
        if (element)
        {

            /** Envio de requisição */
            SendRequest('FOLDER=VIEW&TABLE=CALLS_ACTIVITIES&ACTION=CALLS_ACTIVITIES_PANEL_DATAGRID', {target : 'CallsActivitiesPanel<?php echo $NotificationSend?>', block : {create : true, info : null, sec : null, target : 'CallsActivitiesPanel<?php echo $NotificationSend?>', data : 'Aguarde', color : 'blue', type : 'circle', size : 'sm', message : true}});

        }

    }

    /** Envio de requisição */
    SendRequest('FOLDER=VIEW&TABLE=CALLS_ACTIVITIES&ACTION=CALLS_ACTIVITIES_PANEL_DATAGRID', {target : 'CallsActivitiesPanel<?php echo $NotificationSend?>', block : {create : true, info : null, sec : null, target : 'CallsActivitiesPanel<?php echo $NotificationSend?>', data : 'Aguarde', color : 'blue', type : 'circle', size : 'sm', message : true}});

    /** Execute a função a cada minuto 60000 milissegundos = 60 segundos*/
    setInterval(Request<?php echo $NotificationSend?>, 60000);

</script>

<!-- Local onde sera montado o painel de atividades -->
<div id="CallsActivitiesPanel<?php echo $NotificationSend?>"></div>
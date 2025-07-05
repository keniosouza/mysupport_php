<?php

/** Crio um Id para o painel que sera atualizado constantemente */
$NotificationSend = md5(rand(1, 1000) . date('H:i:s'));?>

<script type="text/javascript">

    /** Função que será executada a cada minuto */
    function Request<?php echo $NotificationSend?>() {

        /** Obtenho o elemento desejado */
        var element = document.getElementById('NotificationSendUser<?php echo $NotificationSend?>');

        /** Verifico se o elemento existe */
        if (element)
        {

            /** Envio de requisição por intervalo*/
            SendRequest('FOLDER=VIEW&TABLE=NOTIFICATIONS&ACTION=NOTIFICATIONS_SEND_USER', {target : 'NotificationSendUser<?php echo $NotificationSend?>'});

        }

    }

    /** Envio de requisição imediata */
    SendRequest('FOLDER=VIEW&TABLE=NOTIFICATIONS&ACTION=NOTIFICATIONS_SEND_USER', {target : 'NotificationSendUser<?php echo $NotificationSend?>'});

    /** Execute a função a cada minuto 60000 milissegundos = 60 segundos*/
    setInterval(Request<?php echo $NotificationSend?>, 60000);

</script>

<!-- Espaço reservado para realização da notificação -->
<div id="NotificationSendUser<?php echo $NotificationSend?>" class="display-none"></div>
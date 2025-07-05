<?php

/** Importação de classes */
use \vendor\model\Notifications;

/** Instânciamento de classes */
$Notifications = new Notifications();

/** Busco os Registros Desejado */
$NotificationsAllResult = $Notifications->AllByStatus(1);

/** Defino o nome da variavel */
$NotificationData = md5(microtime());

/** Verifico se existe novas notificações para serem enviadas */
if (count($NotificationsAllResult) > 0){ ?>

    <script type="text/javascript">

        /** Verifica se o navegador suporta notificações */
        if (!("Notification" in window)) {

            /** Notificação via toast */
            ToastConstruct({ create: true, background: 'danger', text: 'Este navegador não suporta notificações.' });

        } else if (Notification.permission !== 'denied') {

            /** Se as notificações não estão negadas, pede permissão para o usuário */
            Notification.requestPermission().then(function (permission) {

                /** Verifico se o navegador possui permissão */
                if (permission === "denied") {

                    /** Se a permissão for concedida, cria uma nova notificação */
                    new Notification("Permissão negada!");

                }

            });

        }

        <?php

        /** Percorro todos os itens da lista */
        foreach ($NotificationsAllResult as $key => $result){

            /** Verifico se devo notificar o usuário */
            if ((int)$result->destiny_user_id === (int)$_SESSION['USERSID'])
            {

            /** decodifico os dados da mensagem*/
            $result->data = json_decode($result->data);?>

                /** Envio de notificação */
                new Notification(

                    '<?php echo $result->data->TITLE ?>', {

                        icon : '<?php echo $result->data->ICON ?>',
                        body: '<?php echo $Main->decryptData($result->name_first) ?>: <?php echo trim(strip_tags($result->data->MESSAGE)) ?>'

                    });

                /** Atualizo o Status da Notificação */
                SendRequest('FOLDER=ACTION&TABLE=NOTIFICATIONS&ACTION=NOTIFICATIONS_SAVE_STATUS&NOTIFICATION_ID=<?php echo $result->notification_id ?>&DESTINY_USER_ID=<?php echo $result->destiny_user_id ?>&STATUS=2', {target : null});

            <?php }?>

        <?php }?>

    </script>

<?php }?>
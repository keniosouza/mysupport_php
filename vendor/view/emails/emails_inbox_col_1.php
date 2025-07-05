<?php

use vendor\controller\mail\MailProcedures;

$MailProcedures = new MailProcedures;

/** Ativo a exibição de erros */
error_reporting(E_ALL);
ini_set('display_errors', 'On');

// Credenciais de conexão
// Configurações da conta de e-mail
$hostname = '{mail.softwiki.com.br:993/imap/ssl}INBOX';
$username = 'keven@softwiki.com.br';
$password = '123456';

// Tentativa de conexão
$inbox = imap_open($hostname, $username, $password) or die('Não foi possível conectar ao servidor de email: ' . imap_last_error());

// Total de mensagens na caixa de entrada
$total_emails = imap_num_msg($inbox);

// Calcula onde começar a pegar os e-mails (últimos 10)
$start = $total_emails - 100;

// Obter emails
//$emails = imap_search($inbox, 'ALL');

// Obtém os 10 últimos e-mails
$emails = imap_fetch_overview($inbox, "$start:$total_emails", 0);

// Colocar os emails mais recentes no topo
//rsort($emails);

$emails = array_reverse($emails);

?>

<div class="p-3 shadow-sm border-bottom bg-glass sticky-top">

    <div class="btn-group btn-sm w-100" role="group" aria-label="Basic example">

        <button type="button" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Todas" onclick="filtrarDivs(0);">

            <i class="bi bi-filter me-1"></i>

        </button>

        <button type="button" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Nâo Lidas" onclick="filtrarDivs(2);">

            <i class="bi bi-filter-circle-fill me-1"></i>

        </button>

        <button type="button" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Lidas" onclick="filtrarDivs(3);">

            <i class="bi bi-filter-circle me-1"></i>

        </button>

    </div>

</div>

<?php

/** Consulta os usuário cadastrados*/
foreach ($emails as $key => $email) {?>

    <div id="NotificationId<?php echo $key?>" class="px-2 py-3 chat-item" onclick="BeforeSendRequest<?php echo $key?>()">

        <h6 class="text-truncate text-black-50 mb-0">

            <?php echo $MailProcedures->TextDecode($email->from); ?>

        </h6>

        <h5 class="mb-1 text-truncate d-flex align-items-center">

            <?php echo $MailProcedures->TextDecode($email->subject); ?>

        </h5>

        <small>

            <?php echo date('d/m/Y H:i:s', strtotime($Main->antiInjection($email->date)))?>

        </small>

    </div>

    <script type="text/javascript">

        /** Procedimentos para serem realizados antes da requisição */
        function BeforeSendRequest<?php echo $key?>()
        {

            /** Executo a função quando a página for carregada */
            RemoveAndAddClass('NotificationId<?php echo $key?>');

            function RemoveAndAddClass(target) {

                /** Obtenho a div que possui os itens */
                var wrapper = document.getElementById("NotificationsDetailsList");

                /** Busco os itens existentes dentro do objeto encapsulador */
                var itens = wrapper.getElementsByClassName("chat-item-active");

                /** Percorro todos o itens localizados */
                for (var i = 0; i < itens.length; i++) {

                    /** Removo a classe desejada */
                    itens[i].classList.remove("chat-item-active");

                }

                /** Obtenho o item desejado */
                var item = document.getElementById(target);

                /** Adiciono a classe desejada */
                item.classList.toggle("chat-item-active");

            }

            /** Envio de requisição */
            SendRequest('FOLDER=VIEW&TABLE=EMAILS&ACTION=EMAILS_INBOX_COL_2&UID=<?php echo $email->uid?>', {target : 'NotificationsDetailsItem', block : {create : true, info : null, sec : null, target : 'NotificationsDetailsItem', data : 'Aguarde', color : 'blue', type : 'circle', size : 'sm', message : true}})

        }

    </script>

    <?php

}

// Fechar conexão
imap_close($inbox);

?>

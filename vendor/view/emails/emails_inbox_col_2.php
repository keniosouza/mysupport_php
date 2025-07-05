<?php

/** Ativo a exibição de erros */
error_reporting(E_ALL);
ini_set('display_errors', 'On');

use vendor\controller\mail\MailProcedures;

$MailProcedures = new MailProcedures();

// Credenciais de conexão
// Configurações da conta de e-mail
$hostname = '{mail.softwiki.com.br:993/imap/ssl}INBOX';
$username = 'keven@softwiki.com.br';
$password = '123456';

// Abrindo a conexão IMAP
$inbox = imap_open($hostname, $username, $password) or die('Cannot connect to IMAP: ' . imap_last_error());

// Especificar o UID do email que você deseja recuperar
$uid = $_POST['UID']; // Suponha que este é o UID do email que você quer ler

// Recuperar o email por UID
$email_number = imap_msgno($inbox, $uid); // Converte UID para número de mensagem sequencial

$email = new stdClass();
$email->overview = imap_fetch_overview($inbox, $email_number, 0);
$email->body_0 = imap_fetchbody($inbox, $email_number, '0');
$email->body_1 = imap_fetchbody($inbox, $email_number, '1');
$email->body_2 = imap_fetchbody($inbox, $email_number, '2');

// Fechar a conexão
imap_close($inbox);
?>

<div class="card shadow-sm">

    <div class="card-body">

        <h5 class="card-title fw-normal">

            De: <?php echo $MailProcedures->TextDecode($email->overview[0]->from); ?>

        </h5>

        <h5 class="card-title fw-normal">

            Para: <?php echo $MailProcedures->TextDecode($email->overview[0]->to); ?>

        </h5>

        <h3 class="card-subtitle">

            <?php echo $MailProcedures->TextDecode($email->overview[0]->subject); ?>

        </h3>

        <?php


            $Main->FileGenerate('temp/', 'email1.html', $MailProcedures->BodyDecode($email->body_2));


            $Main->FileGenerate('temp/', 'email2.html', $MailProcedures->BodyDecode($email->body_1));

        ?>

        <iframe src="temp/email1.html" class="w-100 rounded border p-1 mt-3" style="height: 300px" frameborder="0"></iframe>
        <iframe src="temp/email2.html" class="w-100 rounded border p-1 mt-3" style="height: 300px" frameborder="0"></iframe>

    </div>

</div>
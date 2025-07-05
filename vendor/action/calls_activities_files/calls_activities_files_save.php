<?php

/** Importação de classes  */
use vendor\model\Notifications;
use vendor\controller\notifications\NotificationsValidate;
use vendor\model\Messages;
use vendor\controller\messages\MessagesValidate;
use vendor\model\CallsActivitiesUsers;
use vendor\model\CallsActivities;
use vendor\controller\calls_activities\CallsActivitiesValidate;
use vendor\model\Files;
use vendor\controller\files\FilesValidate;
use vendor\controller\files\FilesProcedures;

/** Instânciamento de classes  */
$Notifications = new Notifications();
$NotificationsValidate = new NotificationsValidate();
$Messages = new Messages();
$MessagesValidate = new MessagesValidate();
$CallsActivitiesUsers = new CallsActivitiesUsers();
$CallsActivities = new CallsActivities();
$CallsActivitiesValidate = new CallsActivitiesValidate();
$Files = new Files();
$FilesValidate = new FilesValidate();
$FilesProcedures = new FilesProcedures();

/** Parametros de entrada dos PRODUTOS  */
$callActivityId = (int)filter_input(INPUT_POST, 'call_activity_id', FILTER_SANITIZE_SPECIAL_CHARS);

/** Parametros de entrada dos ARQUIVOS */
$fileId = (int)filter_input(INPUT_POST, 'file_id', FILTER_SANITIZE_SPECIAL_CHARS);
$registerId = (int)filter_input(INPUT_POST, 'call_activity_id', FILTER_SANITIZE_SPECIAL_CHARS);
$table = 'calls_activities';

/** Parâmetros de entrada dos ARQUIVOS */
$name = (string)filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
$hash = $_POST['hash'];

/** Validando os campos de entrada */
$CallsActivitiesValidate->setCallActivityId($callActivityId);

/** Define o local do arquivo e realiza validações */
$FilesValidate->setFileId($fileId);
$FilesValidate->setRegisterId($registerId);
$FilesValidate->setTable($table);
$FilesValidate->setGenerateHistory();
$FilesValidate->setPath('temp/' . $hash);
$FilesValidate->setName($name);

/** Verifica a existência de erros durante a validação */
if (!empty($FilesValidate->getErrors())) {

    /** Caso ocorra algum erro, lança uma exceção com a mensagem de erro. */
    throw new InvalidArgumentException($FilesValidate->getErrors(), 0);

} else {

    /** Busco a RELEASE DO PRODUTO desejado */
    $CallsActivitiesLoadResult = $CallsActivities->Load($CallsActivitiesValidate->getCallActivityId());

    /** Defino o local do arquivo */
    $FilesValidate->setPath('document/calls/' . $CallsActivitiesLoadResult->call_id . '_call/' . $CallsActivitiesLoadResult->call_activity_id . '_call_activity/');

    /** Realizo a junção das partes do arquivo */
    $FilesProcedures->merge('temp/' . $hash, $FilesValidate->getName(), $FilesValidate->getPath());

    /** Busco o registro desejado */
    $CallsActivitiesGetResult = $CallsActivities->Get($CallsActivitiesValidate->getCallActivityId());

    /** Efetua um novo cadastro ou salva os novos dados */
    if ($Files->Save($FilesValidate->getFileId(), $FilesValidate->getRegisterId(), $FilesValidate->getTable(), $FilesValidate->getName(), $FilesValidate->getPath(), $FilesValidate->getGenerateHistory())) {

        /** Busco os colaboradores para serem notificados */
        $CallsActivitiesUsersAllByActivityIdResult = $CallsActivitiesUsers->AllByActivityId($CallsActivitiesGetResult->call_activity_id);

        /** Verificos se devo realizar a notificação dos colaboradores */
        if (count($CallsActivitiesUsersAllByActivityIdResult) > 0)
        {

            /** perocorro a lista dos colaboradores localizados */
            foreach ($CallsActivitiesUsersAllByActivityIdResult as $key => $result)
            {

                /** Parâmetros de entrada */
                $NotificationsValidate->setNotificationId(0);
                $NotificationsValidate->setCompanyId((int)$_SESSION['USERSCOMPANYID']);
                $NotificationsValidate->setUserId((int)$_SESSION['USERSID']);
                $NotificationsValidate->setDestinyUserId((int)$result->user_id);
                $NotificationsValidate->setTable('calls_activities');
                $NotificationsValidate->setRegisterId((int)$result->call_activity_id);
                $NotificationsValidate->setStatus(1);
                $NotificationsValidate->setData(json_encode(['TITLE' => 'Arquivo!', 'MESSAGE' => 'Novo arquivo postado na atividade "'. '#' . $result->call_activity_id . ' - ' . $result->activity_name . '"!', 'CLASS' => 'success', 'ICON' => 'image/default/checked.svg'], JSON_PRETTY_PRINT));
                $NotificationsValidate->setDateRegister(date('Y/m/d H:i:s'));

                /** Notificação de Operação */
                $Notifications->Save($NotificationsValidate->getNotificationId(), $NotificationsValidate->getCompanyId(), $NotificationsValidate->getUserId(), $NotificationsValidate->getDestinyUserId(), $NotificationsValidate->getTable(), $NotificationsValidate->getRegisterId(), $NotificationsValidate->getStatus(), $NotificationsValidate->getData(), $NotificationsValidate->getDateRegister());

            }

        }

        /** Busco o arquivo postado */
        $FilesLastResult = $Files->Last($NotificationsValidate->getRegisterId(), $NotificationsValidate->getTable());

        /** Defino o texto que será postado */
        $MessagesValidate->setUserId((int)$_SESSION['USERSID']);
        $MessagesValidate->setTable('calls_activities');
        $MessagesValidate->setRegisterId((int)$CallsActivitiesGetResult->call_activity_id);
        $MessagesValidate->setReceived(0);
        $MessagesValidate->setViewed(0);
        $MessagesValidate->setData('Postando arquivo <b><a href="' . $FilesLastResult->path . $FilesLastResult->name . '" download>' . $FilesValidate->getName() . '</a></b>');
        $MessagesValidate->setDateRegister(date('Y/m/d H:i:s'));

        /** Publico uma mensagem */
        $Messages->Save(0, $MessagesValidate->getUserId(), $MessagesValidate->getTable(), $MessagesValidate->getRegisterId(), $MessagesValidate->getData(), $MessagesValidate->getDateRegister());

        /** Salvo o Log do Procedimento Realizado */
        $Logs->Save($LogsValidate->getLogId(), 4, $LogsValidate->getCompanyId(), $LogsValidate->getUserId(), 'calls_activities', $CallsActivitiesGetResult->call_activity_id, md5('calls' . $CallsActivitiesGetResult->call_id), $LogsHandling->getDefaultData('Arquivo!', 'Arquivo postado na atividade <b>"' . $CallsActivitiesGetResult->name . '"</b>!', 'success'), $LogsValidate->getDateRegister());

        /** Result **/
        $result = [

            'code' => 200,
            'title' => 'Sucesso',
            'data' => 'Registro Salvo Com Sucesso',
            'redirect' => 'FOLDER=VIEW&TABLE=CALLS_ACTIVITIES_FILES&ACTION=CALLS_ACTIVITIES_FILES_DATAGRID&CALL_ACTIVITY_ID=' . $FilesValidate->getRegisterId() . '&MODAL=1',
            'target' => 'pills-files-datagrid',
            'end' => true,

        ];

    } else {

        /** Caso ocorra algum erro, informo */
        throw new InvalidArgumentException('Não foi possível atualizar o cadastro', 0);

    }

}

/** Envio do resultado em formato JSON */
echo json_encode($result);

/** Encerra o procedimento */
exit;

<?php

/** Importação de classes */
use vendor\model\Notifications;
use vendor\controller\notifications\NotificationsValidate;
use vendor\model\CallsActivities;
use vendor\controller\calls_activities\CallsActivitiesValidate;
use vendor\model\CallsActivitiesUsers;
use vendor\model\Messages;
use vendor\controller\messages\MessagesValidate;

/** Instânciamento de classes */
$Notifications = new Notifications();
$NotificationsValidate = new NotificationsValidate();
$CallsActivities = new CallsActivities();
$CallsActivitiesValidate = new CallsActivitiesValidate();
$CallsActivitiesUsers = new CallsActivitiesUsers();
$Messages = new Messages();
$MessagesValidate = new MessagesValidate();

/** Parâmetros de entrada */
$CallsActivitiesValidate->setCallId((int)filter_input(INPUT_POST, 'call_id', FILTER_SANITIZE_NUMBER_INT));
$CallsActivitiesValidate->setCallActivityId((int)filter_input(INPUT_POST, 'call_activity_id', FILTER_SANITIZE_NUMBER_INT));
$CallsActivitiesValidate->setSectionId((string)filter_input(INPUT_POST, 'section_id', FILTER_SANITIZE_SPECIAL_CHARS));
$CallsActivitiesValidate->setCompanyId($_SESSION['USERSCOMPANYID']);
$CallsActivitiesValidate->setName((string)filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS));

/** Verifico a existência de erros */
if (!empty($CallsActivitiesValidate->getErrors())) {

    /** Caso exista algum erro de preenchimento eu removo o formulário da tela **/
    $result = [

        'code' => 200,
        'procedure' => [
            [
                'name' => 'RemoveHtml',
                'options' => [
                    'target' => 'CallActivityForm' . $CallsActivitiesValidate->getSectionId()
                ]
            ]
        ]

    ];

} else {

    /** Busco o registro desejado */
    $CallsActivitiesGetResult = $CallsActivities->Get($CallsActivitiesValidate->getCallActivityId());

    /** Verifico se o registro foi localizado */
    if ($CallsActivities->SaveName($CallsActivitiesValidate->getCallId(), $CallsActivitiesValidate->getCallActivityId(), $CallsActivitiesValidate->getSectionId(), $CallsActivitiesValidate->getCompanyId(), $CallsActivitiesValidate->getName())) {

        /** Busco os colaboradores para serem notificados */
        $CallsActivitiesUsersAllByActivityIdResult = $CallsActivitiesUsers->AllByActivityId($CallsActivitiesValidate->getCallActivityId());

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
                $NotificationsValidate->setData(json_encode(['TITLE' => 'Alterado!', 'MESSAGE' => 'Nome da Atividade "'. '#' . $result->call_activity_id . ' - ' . $result->activity_name . '" Alterada para : ' . $CallsActivitiesValidate->getName() . '!', 'CLASS' => 'success', 'ICON' => 'image/default/checked.svg'], JSON_PRETTY_PRINT));
                $NotificationsValidate->setDateRegister(date('Y/m/d H:i:s'));

                /** Notificação de Operação */
                $Notifications->Save($NotificationsValidate->getNotificationId(), $NotificationsValidate->getCompanyId(), $NotificationsValidate->getUserId(), $NotificationsValidate->getDestinyUserId(), $NotificationsValidate->getTable(), $NotificationsValidate->getRegisterId(), $NotificationsValidate->getStatus(), $NotificationsValidate->getData(), $NotificationsValidate->getDateRegister());

            }

        }

        /** Defino o texto que será postado */
        $MessagesValidate->setUserId((int)$_SESSION['USERSID']);
        $MessagesValidate->setTable('calls_activities');
        $MessagesValidate->setRegisterId((int)$CallsActivitiesGetResult->call_activity_id);
        $MessagesValidate->setReceived(0);
        $MessagesValidate->setViewed(0);
        $MessagesValidate->setData('Alterando nome para: ' . $CallsActivitiesValidate->getName());
        $MessagesValidate->setDateRegister(date('Y/m/d H:i:s'));

        /** Publico uma mensagem */
        $Messages->Save(0, $MessagesValidate->getUserId(), $MessagesValidate->getTable(), $MessagesValidate->getRegisterId(), $MessagesValidate->getData(), $MessagesValidate->getDateRegister());

        /** Log de requisições */
        $Logs->Save($LogsValidate->getLogId(), 4, $LogsValidate->getCompanyId(), $LogsValidate->getUserId(), 'calls_activities', $CallsActivitiesValidate->getCallActivityId(), md5('calls' . $CallsActivitiesGetResult->call_id), $LogsHandling->getDefaultData('Descrição!', 'Nome da atividade foi alterado!', 'warning'), $LogsValidate->getDateRegister());

        /** Inicio a coleta de dados */
        ob_start();

        /** Inclusão do arquivo desejado */
        @include_once 'vendor/view/calls_activities/calls_activities_card.php';

        /** Prego a estrutura do arquivo */
        $html = ob_get_contents();

        /** Removo o arquivo incluido */
        ob_clean();

        /** Verifico o tipo de resposta que devo retornar */
        if ($CallsActivitiesValidate->getCallActivityId() > 0)
        {

            /** Result **/
            $result = [

                'code' => 200

            ];

        }
        else
        {

            /** Result **/
            $result = [

                'code' => 200,
                'procedure' => [
                    [
                        'name' => 'RemoveHtml',
                        'options' => [
                            'target' => 'CallActivityForm' . $CallsActivitiesValidate->getSectionId(),
                            'data' => $html
                        ]
                    ],
                    [
                        'name' => 'PrependHtml',
                        'options' => [
                            'target' => 'Section' . $CallsActivitiesValidate->getSectionId(),
                            'data' => $html
                        ]
                    ]
                ]

            ];

        }

    } else {

        /** Result **/
        $result = [

            'code' => 0,
            'toast' => [
                'create' => true,
                'background' => 'danger',
                'data' => 'Não foi possível salvar a atividade!'
            ]

        ];

    }

}

/** Envio **/
echo json_encode($result);

/** Paro o procedimento **/
exit;
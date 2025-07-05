<?php

/** Importação de classes  */
use vendor\model\Company;
use vendor\controller\company\CompanyValidate;

try{

    /** Verifica se o token de acesso é válido */
    if($Main->verifyToken()){       

        /** Instânciamento de classes  */
        $Company = new Company();
        $CompanyValidate = new CompanyValidate();

        /** Parametros de entrada  */
        $companyId                   = isset($_POST['company_id'])                     ? (int)filter_input(INPUT_POST,'company_id', FILTER_SANITIZE_SPECIAL_CHARS)                        : 0;
        $nameFiles                   = isset($_POST['name_files'])                     ? (string)filter_input(INPUT_POST,'name_files', FILTER_SANITIZE_SPECIAL_CHARS)                     : '';
        $mailUsername                = isset($_POST['mail_username'])                  ? (string)filter_input(INPUT_POST,'mail_username', FILTER_SANITIZE_SPECIAL_CHARS)                  : '';
        $mailPassword                = isset($_POST['mail_password'])                  ? (string)filter_input(INPUT_POST,'mail_password', FILTER_SANITIZE_SPECIAL_CHARS)                  : '';
        $mailInboundServer           = isset($_POST['mail_inbound_server'])            ? (string)filter_input(INPUT_POST,'mail_inbound_server', FILTER_SANITIZE_SPECIAL_CHARS)            : '';
        $mailInboundServerPort       = isset($_POST['mail_inbound_server_port'])       ? (string)filter_input(INPUT_POST,'mail_inbound_server_port', FILTER_SANITIZE_SPECIAL_CHARS)       : '';
        $mailOutgoingServer          = isset($_POST['mail_outgoing_server'])           ? (string)filter_input(INPUT_POST,'mail_outgoing_server', FILTER_SANITIZE_SPECIAL_CHARS)           : '';
        $mailOutgoingServerPort      = isset($_POST['mail_outgoing_server_port'])      ? (string)filter_input(INPUT_POST,'mail_outgoing_server_port', FILTER_SANITIZE_SPECIAL_CHARS)      : '';
        $mailWelcomeMessage          = isset($_POST['mail_welcome_message'])           ? (string)filter_input(INPUT_POST,'mail_welcome_message', FILTER_SANITIZE_SPECIAL_CHARS)           : '';
        $mailPasswordRecoveryMessage = isset($_POST['mail_password_recovery_message']) ? (string)filter_input(INPUT_POST,'mail_password_recovery_message', FILTER_SANITIZE_SPECIAL_CHARS) : '';

        /** Preferências */
        $preferences = [];

        /** Validando os campos de entrada */
        $CompanyValidate->setCompanyId($companyId);
        $CompanyValidate->setMailUsername($mailUsername);        
        $CompanyValidate->setMailPassword($mailPassword); 
        $CompanyValidate->setMailInboundServer($mailInboundServer); 
        $CompanyValidate->setMailInboundServerPort($mailInboundServerPort);
        $CompanyValidate->setMailOutgoingServer($mailOutgoingServer);
        $CompanyValidate->setMailOutgoingServerPort($mailOutgoingServerPort);
        $CompanyValidate->setMailWelcomeMessage($mailWelcomeMessage);
        $CompanyValidate->setMailPasswordRecoveryMessage($mailPasswordRecoveryMessage);

        /** Verifica se não existem erros a serem informados */
        if (!empty($CompanyValidate->getErrors())) {

            /** Informo */
            throw new InvalidArgumentException($CompanyValidate->getErrors(), 0);        

        } else {

            /** Verifica se existe uma empresa informada */
            if($CompanyValidate->getCompanyId() > 0){

                /** Verifica se o arquivo da logomarca da empresa foi informado */
                if($nameFiles){

                    /** Envia o arquivo para a pasta correspondente a empresa */
                    $CompanyValidate->moveFile($CompanyValidate->getCompanyId(), $nameFiles, $_SESSION['USERSID']);

                    /** Verifica se não existem erros a serem informados */
                    if (!empty($CompanyValidate->getErrors())) {  
                        
                        /** Informo */
                        throw new InvalidArgumentException($CompanyValidate->getErrors(), 0); 
                    }
                }


                /** Consulta os dados da empresa */
                $CompanyResult = $Company->Get($CompanyValidate->getCompanyId());

                /** Carrega as preferências */
                $preferences = json_decode($CompanyResult->preferences);                 

                /** Prepara o arquivo de preferência */
                $preferences = ["mail" => ["username" => $CompanyValidate->getMailUsername(),
                                           "password" => $CompanyValidate->getMailPassword(),
                                           "inbound_server" => $CompanyValidate->getMailInboundServer(),
                                           "inbound_server_port" => $CompanyValidate->getMailInboundServerPort(),
                                           "outgoing_server" => $CompanyValidate->getMailOutgoingServer(),
                                           "outgoing_server_port" => $CompanyValidate->getMailOutgoingServerPort(),
                                           "from" => ["email" => $CompanyValidate->getMailUsername(),
                                                      "name" => $CompanyResult->fantasy_name
                                            ],
                                            "messages" => ["new_password" => base64_encode(html_entity_decode($CompanyValidate->getMailPasswordRecoveryMessage())),
                                                           "welcome_message" => base64_encode(html_entity_decode($CompanyValidate->getMailWelcomeMessage()))
                                            ]
                                        ],
     
                                "images" => ["logo" => !empty($CompanyValidate->getArchive()) ? $CompanyValidate->getArchive() : $preferences->{'images'}->{'logo'} ]
                                ];

                /** Salva as informações de preferências da empresa */
                if($Company->SavePreference($companyId, json_encode($preferences))){

                    /** Informa o resultado positivo **/
                    $result = [

                        'code' => 200,
                        'title' => 'Atenção',
                        'message' => '<div class="alert alert-success" role="alert">Preferências da empresa atualizada com sucesso!</div>',

                    ];

                    /** Envio **/
                    echo json_encode($result);

                    /** Paro o procedimento **/
                    exit;                     

                }else{//Caso ocorra algum erro, informo

                    throw new InvalidArgumentException('Não foi possível atualizar as preferências da empresa', 0);	
                }

            }else{ # Caso a empresa não tenha sido informada

                throw new InvalidArgumentException('Nenhuma empresa informada para esta solicitação', 0);
            }

        }


    /** Caso o token de acesso seja inválido, informo */
    }else{
		
        /** Informa que o usuário precisa efetuar autenticação junto ao sistema */
        $authenticate = true;		

        /** Informo */
        throw new InvalidArgumentException('Sua sessão expirou é necessário efetuar nova autenticação junto ao sistema', 0);        
    } 


}catch(Exception $exception){

    /** Preparo o formulario para retorno **/
    $result = [

        'code' => 0,
        'message' => '<div class="alert alert-danger" role="alert">' . $exception->getMessage() . '</div>',
        'title' => 'Atenção',
        'type' => 'exception',
		'authenticate' => $authenticate

    ];

    /** Envio **/
    echo json_encode($result);

    /** Paro o procedimento **/
    exit;
}
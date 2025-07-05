<?php

/** Importação de classes  */
use vendor\model\Clients;
use vendor\controller\clients\ClientsValidate;

try{

    /** Verifica se o token de acesso é válido */
    if($Main->verifyToken()){     

        /** Instânciamento de classes  */
        $Clients = new Clients();
        $ClientsValidate = new ClientsValidate();

        /** Parametros de entrada  */
        $clientsId     = isset($_POST['clients_id'])     ? (int)filter_input(INPUT_POST, 'clients_id', FILTER_SANITIZE_SPECIAL_CHARS)        : 0;
        $situationId   = isset($_POST['situation_id'])   ? (int)filter_input(INPUT_POST, 'situation_id', FILTER_SANITIZE_SPECIAL_CHARS)      : 0;
        $clientName    = isset($_POST['client_name'])    ? (string)filter_input(INPUT_POST, 'client_name', FILTER_SANITIZE_SPECIAL_CHARS)    : '';
        $fantasyName   = isset($_POST['fantasy_name'])   ? (string)filter_input(INPUT_POST, 'fantasy_name', FILTER_SANITIZE_SPECIAL_CHARS)   : '';
        $document      = isset($_POST['document'])       ? (string)filter_input(INPUT_POST, 'document', FILTER_SANITIZE_SPECIAL_CHARS)       : '';
        $cns           = isset($_POST['cns'])            ? (int)filter_input(INPUT_POST, 'cns', FILTER_SANITIZE_SPECIAL_CHARS)               : 0;
        $zipCode       = isset($_POST['zip_code'])       ? (string)filter_input(INPUT_POST, 'zip_code', FILTER_SANITIZE_SPECIAL_CHARS)       : '';
        $adress        = isset($_POST['adress'])         ? (string)filter_input(INPUT_POST, 'adress', FILTER_SANITIZE_SPECIAL_CHARS)         : '';
        $number        = isset($_POST['number'])         ? (string)filter_input(INPUT_POST, 'number', FILTER_SANITIZE_SPECIAL_CHARS)         : '';
        $complement    = isset($_POST['complement'])     ? (string)filter_input(INPUT_POST, 'complement', FILTER_SANITIZE_SPECIAL_CHARS)     : '';
        $district      = isset($_POST['district'])       ? (string)filter_input(INPUT_POST, 'district', FILTER_SANITIZE_SPECIAL_CHARS)       : '';
        $city          = isset($_POST['city'])           ? (string)filter_input(INPUT_POST, 'city', FILTER_SANITIZE_SPECIAL_CHARS)           : '';
        $stateInitials = isset($_POST['state_initials']) ? (string)filter_input(INPUT_POST, 'state_initials', FILTER_SANITIZE_SPECIAL_CHARS) : '';
        $type          = isset($_POST['type'])           ? (string)filter_input(INPUT_POST, 'type', FILTER_SANITIZE_SPECIAL_CHARS)           : '';

        /** Validando os campos de entrada */
        $ClientsValidate->setType($type);
        $ClientsValidate->setClientsId($clientsId);
        $ClientsValidate->setSituationId($situationId);
        $ClientsValidate->setClientName($clientName);
        $ClientsValidate->setFantasyName($fantasyName);
        $ClientsValidate->setDocument($document);
        $ClientsValidate->setCns($cns);
        $ClientsValidate->setZipCode($zipCode);
        $ClientsValidate->setAdress($adress);
        $ClientsValidate->setNumber($number);
        $ClientsValidate->setComplement($complement);
        $ClientsValidate->setDistrict($district);
        $ClientsValidate->setCity($city);
        $ClientsValidate->setStateInitials($stateInitials);

        
        /** Verifica se não existem erros a serem informados, 
         * caso não haja erro(s) salvo os dados do cliente ou 
         * efetua o cadastro de um novo*/
        /** Verifico a existência de erros */
        if (!empty($ClientsValidate->getErrors())) {

            /** Informo */
            throw new InvalidArgumentException($ClientsValidate->getErrors(), 0);        

        } else {


            /** Salva as alterações ou cadastra um novo usuário */
            if($Clients->Save($ClientsValidate->getClientsId(), $ClientsValidate->getSituationId(), $ClientsValidate->getClientName(), $ClientsValidate->getFantasyName(), $ClientsValidate->getDocument(), $ClientsValidate->getCns(), $ClientsValidate->getZipCode(), $ClientsValidate->getAdress(), $ClientsValidate->getNumber(), $ClientsValidate->getComplement(), $ClientsValidate->getDistrict(), $ClientsValidate->getCity(), $ClientsValidate->getStateInitials(), $ClientsValidate->getType())){

                /** Informa o resultado positivo **/
                $result = [

                    'code' => 200,
                    'title' => 'Atenção',
                    'message' => '<div class="alert alert-success" role="alert">' . ($clientsId > 0 ? 'Cliente atualizada com sucesso!' : 'Cliente cadastrada com sucesso!') .'</div>',
                    'redirect' => [
                        [
                            'url' => 'FOLDER=VIEW&TABLE=CLIENTS&ACTION=CLIENTS_DATAGRID'
                        ]
                    ]

                ];

                /** Envio **/
                echo json_encode($result);

                /** Paro o procedimento **/
                exit;            

            }else{//Caso ocorra algum erro, informo

                throw new InvalidArgumentException(($clientsId > 0 ? 'Não foi possível atualizar o cadastro da empresa' : 'Não foi possível cadastrar a nova empresa'), 0);	
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
        'message' => '<div class="alert alert-danger" role="alert">'.$exception->getMessage().'</div>',
        'title' => 'Atenção',
        'type' => 'exception',
		'authenticate' => $authenticate

    ];

    /** Envio **/
    echo json_encode($result);

    /** Paro o procedimento **/
    exit;
}
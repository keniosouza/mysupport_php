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
        $companyId     = isset($_POST['company_id'])     ? (int)filter_input(INPUT_POST,'company_id', FILTER_SANITIZE_SPECIAL_CHARS)        : 0;
        $companyName   = isset($_POST['company_name'])   ? (string)filter_input(INPUT_POST,'company_name', FILTER_SANITIZE_SPECIAL_CHARS)   : '';
        $fantasyName   = isset($_POST['fantasy_name'])   ? (string)filter_input(INPUT_POST,'fantasy_name', FILTER_SANITIZE_SPECIAL_CHARS)   : '';
        $document      = isset($_POST['document'])       ? (string)filter_input(INPUT_POST,'document', FILTER_SANITIZE_SPECIAL_CHARS)       : '';
        $zipCode       = isset($_POST['zip_code'])       ? (string)filter_input(INPUT_POST,'zip_code', FILTER_SANITIZE_SPECIAL_CHARS)       : '';
        $adress        = isset($_POST['adress'])         ? (string)filter_input(INPUT_POST,'adress', FILTER_SANITIZE_SPECIAL_CHARS)         : '';
        $number        = isset($_POST['number'])         ? (string)filter_input(INPUT_POST,'number', FILTER_SANITIZE_SPECIAL_CHARS)         : '';
        $complement    = isset($_POST['complement'])     ? (string)filter_input(INPUT_POST,'complement', FILTER_SANITIZE_SPECIAL_CHARS)     : '';
        $district      = isset($_POST['district'])       ? (string)filter_input(INPUT_POST,'district', FILTER_SANITIZE_SPECIAL_CHARS)       : '';
        $city          = isset($_POST['city_'])          ? (string)filter_input(INPUT_POST,'city_', FILTER_SANITIZE_SPECIAL_CHARS)          : '';
        $stateInitials = isset($_POST['state_initials']) ? (string)filter_input(INPUT_POST,'state_initials', FILTER_SANITIZE_SPECIAL_CHARS) : '';
        $active        = isset($_POST['active'])         ? (string)filter_input(INPUT_POST,'active', FILTER_SANITIZE_SPECIAL_CHARS)         : '';

        /** Validando os campos de entrada */
        $CompanyValidate->setCompanyId($companyId);
        $CompanyValidate->setCompanyName($companyName);
        $CompanyValidate->setFantasyName($fantasyName);
        $CompanyValidate->setDocument($document);
        $CompanyValidate->setZipCode($zipCode);
        $CompanyValidate->setAdress($adress);
        $CompanyValidate->setNumber($number);
        $CompanyValidate->setComplement($complement);
        $CompanyValidate->setDistrict($district);
        $CompanyValidate->setCity($city);
        $CompanyValidate->setStateInitials($stateInitials);
        $CompanyValidate->setActive($active);


        /** Verifica se não existem erros a serem informados */
        if (!empty($CompanyValidate->getErrors())) {

            /** Informo */
            throw new InvalidArgumentException($CompanyValidate->getErrors(), 0);        

        } else {
            

            /** Salva as alterações ou cadastra uma nova empresa */
            if($Company->Save($CompanyValidate->getCompanyId(), $CompanyValidate->getCompanyName(), $CompanyValidate->getFantasyName(), $CompanyValidate->getDocument(), $CompanyValidate->getZipCode(), $CompanyValidate->getAdress(), $CompanyValidate->getNumber(), $CompanyValidate->getComplement(), $CompanyValidate->getDistrict(), $CompanyValidate->getCity(), $CompanyValidate->getStateInitials(), $CompanyValidate->getActive())){           

                /** Informa o resultado positivo **/
                $result = [

                    'code' => 200,
                    'title' => 'Atenção',
                    'message' => ($companyId > 0 ? 'Empresa atualizada com sucesso!' : 'Empresa cadastrada com sucesso!'),

                ];

                /** Envio **/
                echo json_encode($result);

                /** Paro o procedimento **/
                exit;            

            }else{//Caso ocorra algum erro, informo

                throw new InvalidArgumentException(($companyId > 0 ? 'Não foi possível atualizar o cadastro da empresa' : 'Não foi possível cadastrar a nova empresa'), 0);	
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
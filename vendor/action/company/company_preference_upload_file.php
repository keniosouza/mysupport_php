<?php

/** Importação de classes  */
use vendor\controller\company\CompanyValidate;

try{

    /** Verifica se o token de acesso é válido */
    if($Main->verifyToken()){         

        /** Instânciamento de classes  */
        $CompanyValidate = new CompanyValidate();

        /** Parametros de entrada  */
        $companyId = isset($_POST['company_id']) ? filter_input(INPUT_POST,'company_id', FILTER_SANITIZE_SPECIAL_CHARS) : '';
        $file      = isset($_POST['file'])       ? filter_input(INPUT_POST,'file', FILTER_SANITIZE_SPECIAL_CHARS)       : '';
        $name      = isset($_POST['name'])       ? filter_input(INPUT_POST,'name', FILTER_SANITIZE_SPECIAL_CHARS)       : '';

        /** Validando os campos de entrada */
        $CompanyValidate->setCompanyId($companyId);
        $CompanyValidate->setName($name);
        $CompanyValidate->setFile($file, $_SESSION['USERSID']);  


        /** Verifica se não existem erros a serem informados */
        if (!empty($CompanyValidate->getErrors())) {

            /** Informo */
            throw new InvalidArgumentException($CompanyValidate->getErrors(), 0);        

        } else {

        
            /** Informa o resultado positivo **/
            $result = [

                'code' => 200,
                'company_id' => $CompanyValidate->getCompanyId(),
                'nameFile' => $CompanyValidate->getName(),
                'path' => $CompanyValidate->getDirTemp().'/'.$CompanyValidate->getDirUser().'/'.$CompanyValidate->getName()

            ];

            /** Envio **/
            echo json_encode($result);       

            /** Paro o procedimento **/
            exit;  
        
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
        'message' => $exception->getMessage(),
        'title' => 'Atenção',
        'type' => 'exception',
        'nameFile' => $CompanyValidate->getName(),
		'authenticate' => $authenticate

    ];

    /** Envio **/
    echo json_encode($result);

    /** Paro o procedimento **/
    exit;
}
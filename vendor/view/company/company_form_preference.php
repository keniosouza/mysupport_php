<?php

/** Importação de classes  */
use vendor\model\Company;

try{

    /** Verifica se o token de acesso é válido */
    if($Main->verifyToken()){       

        /** Instânciamento de classes  */
        $Company = new Company();

        /** Parametros de entrada */
        $companyId = isset($_POST['company_id']) ? $Main->antiInjection($_POST['company_id']) : 0;

        /** Verifica se o ID do projeto foi informado */
        if($companyId > 0){

            /** Consulta os dados da empresa */
            $CompanyResult = $Company->Get($companyId);

        }else{/** Caso o ID da empresa não tenha sido informado, carrego os campos como null */

            /** Carrega os campos da tabela */
            $CompanyResult = $Company->Describe();

        }

        /** Controles  */
        $err = 0;
        $msg = "";

    ?>
        
    <form class="user" id="frmCompanyPreference" autocomplete="off">
        
        <div class="form-group row">
            
            <div class="col-sm-6 mb-2">

                <label for="company_name">Razão Social:</label>
                <input type="text" class="form-control form-control-solid form-control form-control-solid" maxlength="255" id="company_name" name="company_name" value="<?php echo $CompanyResult->company_name;?>" placeholder="Informe a razão social da empresa">
            </div>

            <div class="col-sm-6 mb-2">

                <label for="fantasy_name">Nome Fantasia:</label>
                <input type="text" class="form-control form-control-solid form-control form-control-solid" maxlength="120" id="fantasy_name" name="fantasy_name" value="<?php echo $CompanyResult->fantasy_name;?>" placeholder="Informe o nome fantasia da empresa">
            </div>                        
                                                        
        </div>                    
        
        <input type="hidden" name="TABLE" value="company" />
        <input type="hidden" name="ACTION" value="company_preference_save" />
        <input type="hidden" name="FOLDER" value="action" />
        <input type="hidden" name="company_id" value="<?php echo $companyId;?>" />

        <div class="col-sm-12">
                
            <label for="btn-save"></label>
            <a href="#" class="btn btn-primary btn-user w-100" id="btn-save" onclick="sendForm('#frmCompanyPreference', '', true, '', 0, '', '<?php echo $companyId > 0 ? 'Atualizando cadastro' : 'Cadastrando nova empresa';?>', 'random', 'circle', 'sm', true)"><i class="far fa-save"></i> <?php echo ((int)$companyId > 0 ? 'Salvar alterações da empresa' : 'Cadastrar nova empresa') ?></a>
        </div>                     

    </form>

    <?php


        /** Pego a estrutura do arquivo */
        $div = ob_get_contents();

        /** Removo o arquivo incluido */
        ob_clean();

        /** Result **/
        $result = array(

            'code' => 200,
            'data' => $div,
            'title' => 'Preferências',
            'func' => 'sendForm(\'#frmFinancialBalanceAdjustment\', \'\', true, \'Ajustando saldo...\', 0, \'#messageSend\', \'Enviando solicitação de ajuste de saldo...\', \'random\', \'circle\', \'sm\', true)'

        );


        sleep(1);

        /** Envio **/
        echo json_encode($result);

        /** Paro o procedimento **/
        exit; 

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
        'authenticate' => $authenticate		

    ];

    /** Envio **/
    echo json_encode($result);

    /** Paro o procedimento **/
    exit;
}
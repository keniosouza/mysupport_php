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

        /** Parametros de entrada */
        $companyId = isset($_POST['company_id']) ? (int)filter_input(INPUT_POST, 'company_id', FILTER_SANITIZE_SPECIAL_CHARS) : 0;

        /** Mensagens de e-mails para visualização */
        $mailWelcomePassword = '';
        $mailNewPassword     = '';         

        /** Validando os campos de entrada */
        $CompanyValidate->setCompanyId($companyId);

        /** Verifico a existência de erros */
        if (!empty($CompanyValidate->getErrors())) {

            /** Preparo o formulario para retorno **/
            $result = [

                'code' => 0,
                'title' => 'Atenção',
                'message' => '<div class="alert alert-danger" role="alert">'.$UsersValidate->getErrors().'</div>',

            ];

        } else {        

            /** Verifica se o ID do projeto foi informado */
            if($CompanyValidate->getCompanyId() > 0){

                /** Consulta os dados da empresa */
                $CompanyResult = $Company->Get($CompanyValidate->getCompanyId());

                /** Carrega as preferências */
                $preferences = json_decode($CompanyResult->preferences);

                /** Prepara as mensagens de e-mails para visualização */
                $mailWelcomePassword = isset($preferences->{'mail'}->{'messages'}->{'welcome_message'}) ? base64_decode($preferences->{'mail'}->{'messages'}->{'welcome_message'}) : '';
                $mailNewPassword     = isset($preferences->{'mail'}->{'messages'}->{'new_password'})    ? base64_decode($preferences->{'mail'}->{'messages'}->{'new_password'})    : '';

            }else{/** Caso o ID da empresa não tenha sido informado, carrego os campos como null */

                /** Carrega os campos da tabela */
                $CompanyResult = $Company->Describe();

                /** Carrega as preferências */
                $preferences = json_decode($CompanyResult->preferences); 
                               
            }

            /** Controles  */
            $err = 0;
            $msg = "";

        }

    ?>

    <div class="col-lg-12">

        <div class="card shadow mb-12">
                
            <div class="card-header">

                <div class="row">
                    
                    <div class="col-md-4">
                        
                        <h5 class="card-title"><?php echo $CompanyValidate->getCompanyId() > 0 ? 'Editando dados da empresa' : 'Cadastrar nova empresa';?></h5>
                    
                    </div>

                    <div class="col-md-8 text-end">

                        <button type="button" class="btn btn-success btn-sm" onclick="request('FOLDER=view&TABLE=company&ACTION=company_form', '#loadContent', true, '', '', '', 'Preparando formulário', 'blue', 'circle', 'sm', true)" data-toggle="tooltip" data-placement="left" data-bs-title="Cadastrar nova empresa">

                            <i class="bi bi-plus-circle me-1"></i>Novo

                        </button>


                        <button type="button" class="btn btn-info btn-sm" onclick="request('FOLDER=view&TABLE=company&ACTION=company_datagrid', '#loadContent', true, '', '', '', 'Carregando empresas cadastradas', 'blue', 'circle', 'sm', true)" data-toggle="tooltip" data-placement="left" data-bs-title="Carregar empresas cadastradas">

                            <i class="bi bi-plus-circle me-1"></i>Empresas Cadastradas

                        </button>                        

                    </div>
                
                </div>            

            </div>


            <div class="card-body">

                <ul class="nav nav-pills nav-fill" id="pills-tab">

                    <li class="nav-item mx-1 mb-2">
                        <a class="nav-link active" id="pills-1-tab" data-bs-toggle="pill" href="#pills-1" aria-controls="pills-1">
                            <i class="fas fa-edit me-1"></i>Cadastro
                        </a>                            
                    </li>
                    <li class="nav-item mx-1 mb-2">
                        <a class="nav-link" id="pills-2-tab" data-bs-toggle="pill" href="#pills-2" aria-controls="pills-2" aria-selected="false">
                            <i class='fas fa-sliders-h me-1'></i> Preferências
                        </a>
                    </li>

                </ul>

                <div class="tab-content" id="pills-tabContent">

                    <div class="tab-pane fade active show" id="pills-1" aria-labelledby="pills-1-tab">

                        <form class="user" id="frmCompany" autocomplete="off">
                            
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

                            <div class="form-group row">
                                
                                <div class="col-sm-3 mb-2">

                                    <label for="document">CPF / CNPJ:</label>
                                    <input type="text" class="form-control form-control-solid form-control form-control-solid number" maxlength="14" id="document" name="document" value="<?php echo $Main->formatarCPF_CNPJ($CompanyResult->document);?>" placeholder="Informe CPF/CNPJ">
                                </div> 

                                <div class="col-sm-3 mb-2">

                                    <label for="zip_code">CEP:</label>
                                    <input type="text" class="form-control form-control-solid form-control form-control-solid postal_code" maxlength="9" id="zip_code" name="zip_code" value="<?php echo $CompanyResult->zip_code;?>" placeholder="Informe o CEP">
                                </div> 
                                
                                <div class="col-sm-4 mb-2">

                                    <label for="adress">Endereço:</label>
                                    <input type="text" class="form-control form-control-solid form-control form-control-solid" maxlength="255" id="adress" name="adress" value="<?php echo $CompanyResult->adress;?>" placeholder="Informe o endereço">
                                </div> 
                                
                                <div class="col-sm-2 mb-2">

                                    <label for="number">Número:</label>
                                    <input type="text" class="form-control form-control-solid form-control form-control-solid" maxlength="10" id="number" name="number" value="<?php echo $CompanyResult->number;?>" placeholder="Informe o número">
                                </div>
                                
                            </div>
                            <div class="form-group row">
                                
                                <div class="col-sm-3 mb-2">

                                    <label for="complement ">Complemento:</label>
                                    <input type="text" class="form-control form-control-solid form-control form-control-solid" maxlength="120" id="complement" name="complement" value="<?php echo $CompanyResult->complement;?>" placeholder="Informe o complemento">
                                </div>   
                                
                                <div class="col-sm-3 mb-2">

                                    <label for="district">Bairro:</label>
                                    <input type="text" class="form-control form-control-solid form-control form-control-solid" maxlength="120" id="district" name="district" value="<?php echo $CompanyResult->district;?>" placeholder="Informe o bairro">
                                </div> 
                                
                                <div class="col-sm-3 mb-2">

                                    <label for="city ">Cidade:</label>
                                    <input type="text" class="form-control form-control-solid form-control form-control-solid" maxlength="120" id="city " name="city " value="<?php echo $CompanyResult->city ;?>" placeholder="Informe a cidade">
                                </div> 
                                
                                <div class="col-sm">

                                    <label for="state_initials">Estado:</label>

                                    <select class="form-control form-control-solid form-control form-control-solid" id="state_initials " name="state_initials">
                                            <option value="" selected>Selecione</option>
                                            <option value="AC" <?php echo $CompanyResult->state_initials === 'AC' ? 'selected' : '';?>>AC</option>
                                            <option value="AL" <?php echo $CompanyResult->state_initials === 'AL' ? 'selected' : '';?>>AL</option>
                                            <option value="AP" <?php echo $CompanyResult->state_initials === 'AP' ? 'selected' : '';?>>AP</option>
                                            <option value="AM" <?php echo $CompanyResult->state_initials === 'AM' ? 'selected' : '';?>>AM</option>
                                            <option value="BA" <?php echo $CompanyResult->state_initials === 'BA' ? 'selected' : '';?>>BA</option>
                                            <option value="CE" <?php echo $CompanyResult->state_initials === 'CE' ? 'selected' : '';?>>CE</option>
                                            <option value="DF" <?php echo $CompanyResult->state_initials === 'DF' ? 'selected' : '';?>>DF</option>
                                            <option value="ES" <?php echo $CompanyResult->state_initials === 'ES' ? 'selected' : '';?>>ES</option>
                                            <option value="GO" <?php echo $CompanyResult->state_initials === 'GO' ? 'selected' : '';?>>GO</option>
                                            <option value="MA" <?php echo $CompanyResult->state_initials === 'MA' ? 'selected' : '';?>>MA</option>
                                            <option value="MT" <?php echo $CompanyResult->state_initials === 'MT' ? 'selected' : '';?>>MT</option>
                                            <option value="MS" <?php echo $CompanyResult->state_initials === 'MS' ? 'selected' : '';?>>MS</option>
                                            <option value="MG" <?php echo $CompanyResult->state_initials === 'MG' ? 'selected' : '';?>>MG</option>
                                            <option value="PA" <?php echo $CompanyResult->state_initials === 'PA' ? 'selected' : '';?>>PA</option>
                                            <option value="PB" <?php echo $CompanyResult->state_initials === 'PB' ? 'selected' : '';?>>PB</option>
                                            <option value="PR" <?php echo $CompanyResult->state_initials === 'PR' ? 'selected' : '';?>>PR</option>
                                            <option value="PE" <?php echo $CompanyResult->state_initials === 'PE' ? 'selected' : '';?>>PE</option>
                                            <option value="PI" <?php echo $CompanyResult->state_initials === 'PI' ? 'selected' : '';?>>PI</option>
                                            <option value="RJ" <?php echo $CompanyResult->state_initials === 'RJ' ? 'selected' : '';?>>RJ</option>
                                            <option value="RN" <?php echo $CompanyResult->state_initials === 'RN' ? 'selected' : '';?>>RN</option>
                                            <option value="RS" <?php echo $CompanyResult->state_initials === 'RS' ? 'selected' : '';?>>RS</option>
                                            <option value="RO" <?php echo $CompanyResult->state_initials === 'RO' ? 'selected' : '';?>>RO</option>
                                            <option value="RR" <?php echo $CompanyResult->state_initials === 'RR' ? 'selected' : '';?>>RR</option>
                                            <option value="SC" <?php echo $CompanyResult->state_initials === 'SC' ? 'selected' : '';?>>SC</option>
                                            <option value="SP" <?php echo $CompanyResult->state_initials === 'SP' ? 'selected' : '';?>>SP</option>
                                            <option value="SE" <?php echo $CompanyResult->state_initials === 'SE' ? 'selected' : '';?>>SE</option>
                                            <option value="TO" <?php echo $CompanyResult->state_initials === 'TO' ? 'selected' : '';?>>TO</option>
                                    </select>                        

                                </div>  
                                
                                <div class="col-sm">

                                    <label for="active">Ativo:</label>

                                    <select class="form-control form-control-solid form-control form-control-solid" id="active" name="active">
                                            <option value="S" <?php echo $CompanyResult->active  === 'S' ? 'selected' : '';?>>Sim</option>
                                            <option value="N" <?php echo $CompanyResult->active  != 'S' ? 'selected' : '';?>>Não</option>
                                    </select>                        

                                </div>                          

                            </div>                    
                            
                            <input type="hidden" name="TABLE" value="company" />
                            <input type="hidden" name="ACTION" value="company_save" />
                            <input type="hidden" name="FOLDER" value="action" />
                            <input type="hidden" name="company_id" value="<?php echo $CompanyValidate->getCompanyId();?>" />

                            <div class="col-sm-12">
                                    
                                <label for="btn-save"></label>
                                <a href="#" class="btn btn-primary btn-user w-100" id="btn-save" onclick="sendForm('#frmCompany', '', true, '', 0, '', '<?php echo $CompanyValidate->getCompanyId() > 0 ? 'Atualizando cadastro' : 'Cadastrando nova empresa';?>', 'random', 'circle', 'sm', true)"><i class="far fa-save"></i> <?php echo ($CompanyValidate->getCompanyId() > 0 ? 'Salvar alterações da empresa' : 'Cadastrar nova empresa') ?></a>
                            </div>                     

                        </form>

                    </div>
                    <div class="tab-pane fade " id="pills-2" aria-labelledby="pills-2-tab">
                        
                        <form class="user" id="frmCompanyPreference" autocomplete="off">

                            
                            <div class="form-group row p-4">

                                <div class="col-sm-12 mb-2">
                                    <b>Envie a logomarca da empresa no formato especificado, somente são permitidos arquivos do tipo jpg, jpeg, png:</b>
                                </div>                            

                                <div class="col-sm-2">

                                    <img src="<?php echo isset($preferences->{'images'}->{'logo'}) ? $preferences->{'images'}->{'logo'} : 'img/logo-company.png';?>" class="border img-fluid" />
                                </div>

                                <div class="col-sm-2">

                                    <label for="selectFiles"><span class="text-danger">* Tamanho máximo do arquivo 5mb</span></label>
                                    <input type="file" id="selectFiles" class="upload filestyle" accept="image/png, image/jpg, image/jpeg" />
                                    <div id="preview"></div>

                                </div>

                                <div class="col-sm-8">
                                    <label>&nbsp;&nbsp;</label>
                                    <div id="results" class="row"></div>
                                </div>

                            </div>

                            <div class="form-group row p-4">

                                <div class="col-sm-12 mb-2">
                                    <b>Configurações manuais do cliente de email:</b>
                                </div>
                                
                                <div class="col-sm-2 mb-2">

                                    <label for="mail_username">Usuário:</label>
                                    <input type="text" class="form-control form-control-solid form-control form-control-solid" maxlength="160" id="mail_username" name="mail_username" value="<?php echo isset($preferences->{'mail'}->{'username'}) ? $preferences->{'mail'}->{'username'} : '';?>" placeholder="exemplo@exemplo.com.br">
                                </div>

                                <div class="col-sm-2 mb-2">

                                    <label for="mail_password">Senha:</label>
                                    <input type="text" class="form-control form-control-solid form-control form-control-solid" maxlength="10" id="mail_password" name="mail_password" value="<?php echo isset($preferences->{'mail'}->{'password'}) ? $preferences->{'mail'}->{'password'} : '';?>" placeholder="* * * * * *">
                                </div>
                                
                                <div class="col-sm-2 mb-2">

                                    <label for="mail_inbound_server">Servidor de entrada:</label>
                                    <input type="text" class="form-control form-control-solid form-control form-control-solid" maxlength="160" id="mail_inbound_server" name="mail_inbound_server" value="<?php echo isset($preferences->{'mail'}->{'inbound_server'}) ? $preferences->{'mail'}->{'inbound_server'} : '';?>" placeholder="mail.exemplo.com.br">
                                </div>
                                
                                <div class="col-sm-2 mb-2">

                                    <label for="mail_inbound_server_port">Servidor de entrada/Porta:</label>
                                    <input type="text" class="form-control form-control-solid form-control form-control-solid" maxlength="160" id="mail_inbound_server_port" name="mail_inbound_server_port" value="<?php echo isset($preferences->{'mail'}->{'inbound_server_port'}) ? $preferences->{'mail'}->{'inbound_server_port'} : '';?>" placeholder="995">
                                </div>                                    
                                
                                <div class="col-sm-2 mb-2">

                                    <label for="mail_outgoing_server">Servidor de saída:</label>
                                    <input type="text" class="form-control form-control-solid form-control form-control-solid" maxlength="160" id="mail_outgoing_server" name="mail_outgoing_server" value="<?php echo isset($preferences->{'mail'}->{'outgoing_server'}) ? $preferences->{'mail'}->{'outgoing_server'} : '';?>" placeholder="mail.exemplo.com.br">
                                </div>  
                                
                                <div class="col-sm-2 mb-2">

                                    <label for="mail_outgoing_server_port">Servidor de saída/Porta:</label>
                                    <input type="text" class="form-control form-control-solid form-control form-control-solid" maxlength="160" id="mail_outgoing_server_port" name="mail_outgoing_server_port" value="<?php echo isset($preferences->{'mail'}->{'outgoing_server_port'}) ? $preferences->{'mail'}->{'outgoing_server_port'} : '';?>" placeholder="465">
                                </div>                                     
                                                                            
                            </div>
                            
                            <!-- Mensagem de boas vindas -->
                            <div class="form-group row p-2">

                                <div class="col-sm-12 mb-2">

                                    <div class="col-sm-12 mb-2">
                                        <b>Mensagem de boas vindas: </b><br/>                                        
                                        <div class="alert alert-warning" role="alert">Marcações:<br/>                                        
                                            <ul>                                        
                                                <li><i><[{USERFIRSTNAME}]></i> Carrega o nome do usuário</li>
                                                <li><i><[{URL}]></i> Carrega o link de recuperação de senha</li>
                                                <li><i><[{COMPANYNAME}]></i> Carrega o nome da empresa</li>
                                            </ul>
                                        </div>
                                        
                                    </div> 
                                    
                                    <div class="col-sm-12 mb-2">
                                        <textarea class="form-control form-control-solid form-control form-control-solid" id="mail_welcome_message" name="mail_welcome_message"><?php echo isset($preferences->{'mail'}->{'messages'}->{'welcome_message'}) ? base64_decode($preferences->{'mail'}->{'messages'}->{'welcome_message'}) : '';?></textarea>
                                    </div>

                                </div>                                    
                                
                            </div>

                            <!-- Mensagem de recuperação de senha -->
                            <div class="form-group row p-2">

                                <div class="col-sm-12 mb-2">

                                    <div class="col-sm-12 mb-2">
                                        <b>Mensagem de recuperação de senha: </b><br/>
                                        <div class="alert alert-warning" role="alert">Marcações: <br/> 
                                            <ul>
                                                <li><i><[{URL}]></i> Carrega o link de recuperação de senha</li>
                                            </ul>
                                        </div>
                                    </div> 
                                    
                                    <div class="col-sm-12 mb-2">
                                        <textarea class="form-control form-control-solid form-control form-control-solid" id="mail_password_recovery_message" name="mail_password_recovery_message"><?php echo isset($preferences->{'mail'}->{'messages'}->{'new_password'})    ? base64_decode($preferences->{'mail'}->{'messages'}->{'new_password'})    : '';?></textarea>
                                    </div>                                    

                                </div>                                    
                                
                            </div>   
                            
                            <input type="hidden" name="TABLE" value="company" />
                            <input type="hidden" name="ACTION" value="company_preference_save" />
                            <input type="hidden" name="FOLDER" value="action" />
                            <input type="hidden" name="company_id" value="<?php echo $CompanyValidate->getCompanyId();?>" />

                            <div class="col-sm-12">
                                    
                                <label for="btn-save"></label>
                                <a href="#" class="btn btn-primary btn-user w-100" id="btn-save" onclick="sendForm('#frmCompanyPreference', '', true, '', 0, '', '<?php echo $CompanyValidate->getCompanyId() > 0 ? 'Atualizando preferencias' : 'Cadastrando novas preferências';?>', 'random', 'circle', 'sm', true)"><i class="far fa-save"></i> <?php echo ($CompanyValidate->getCompanyId() > 0 ? 'Salvar preferências da empresa' : 'Cadastrar novas preferências empresa') ?></a>
                            </div>                              

                        </form>

                    </div>
                
                </div>

            </div>

        </div>

    </div>

    <script type="text/javascript">

        /** Carrega as mascaras dos campos inputs */
        $(document).ready(function(e) {

            /** Upload files */
            uploadFiles('action', 'company', 'company_preference_upload_file', 0, '', '', '<?php echo $CompanyValidate->getCompanyId();?>');                              

        });        

    </script>    

<?php

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
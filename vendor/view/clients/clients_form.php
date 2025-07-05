<?php

/** Importação de classes  */
use vendor\model\Clients;

try{

    /** Verifica se o token de acesso é válido */
    if($Main->verifyToken()){      

        /** Instânciamento de classes  */
        $Clients = new Clients();

        /** Parametros de entrada */
        $clientsId = isset($_POST['clients_id']) ? $Main->antiInjection($_POST['clients_id']) : 0;

        /** Verifica se o ID do projeto foi informado */
        if($clientsId > 0){

            /** Consulta os dados do controle de acesso */
            $ClientsResult = $Clients->Get($clientsId);

        }else{/** Caso o ID do controle de acesso não tenha sido informado, carrego os campos como null */

            /** Carrega os campos da tabela */
            $ClientsResult = $Clients->Describe();

        }


    ?>

        <div class="col-lg-12">

            <div class="card shadow mb-12">
                    
                <div class="card-header">

                    <div class="row">
                        
                        <div class="col-md-4">
                            
                            <h5 class="card-title"><?php echo $clientsId > 0 ? 'Editando dados do cliente' : 'Cadastrar um novo cliente.';?></h5>
                        
                        </div>

                        <div class="col-md-8 text-end">

                            <button type="button" class="btn btn-outline-primary btn-sm" onclick="request('FOLDER=view&TABLE=clients&ACTION=clients_datagrid', '#loadContent', true, '', '', '', 'Carregando clientes cadastrados', 'blue', 'circle', 'sm', true)" data-toggle="tooltip" data-placement="left" data-bs-title="Voltar">

                                <i class="bi bi-arrow-left-short me-1"></i>Voltar

                            </button>

                        </div>
                    
                    </div>            

                </div>

                <div class="card-body">

                    <form class="user" id="frmClients" autocomplete="off">
                        
                        <div class="form-group row ">


                            <div class="col-md-6 mb-0 pr-0"> <b>Nosso cliente é pessoa jurídica ou física ?</b></div>
                            <div class="col-md-6 mb-0"><label for="client_name"> <b>Razão Social / Nome</b> </label></div>
                            
                            <div class="col-md-2 mt-1 mb-1 pr-0">

                                <div class="custom-control custom-switch">

                                    <input type="radio" class="custom-control-input" id="type_legal" name="type" value="J" <?php echo $ClientsResult->type == 'J' || empty($ClientsResult->type) ? 'checked' : '';?> onclick= maskCpfCnpj('type_legal')>
                                    <label class="custom-control-label" for="type_legal">

                                        Jurídica

                                    </label>

                                </div>

                            </div>

                            <div class="col-md-4 mt-1 mb-1 pr-0 ">

                                <div class="custom-control custom-switch text-center">

                                    <input type="radio" class="custom-control-input" id="type_physics" name="type" value="F" <?php echo $ClientsResult->type == 'F' ? 'checked' : '';?> onclick= maskCpfCnpj('type_physics')>
                                    <label class="custom-control-label" for="type_physics">

                                        Física

                                    </label>

                                </div>

                            </div>

                            <div class="col-md-6 mt-1 mb-1">

                                <input type="text" class="form-control form-control-solid form-control form-control-solid" maxlength="255" id="client_name" name="client_name" value="<?php echo $ClientsResult->client_name;?>">

                            </div>


                        </div>
                        
                        <div class="form-group row">

                            <div class="col-sm-6 mb-2 pr-0">

                                <label for="fantasy_name"> <b>Nome Fantasia</b> </label>
                                <input type="text" class="form-control form-control-solid form-control form-control-solid" maxlength="120" id="fantasy_name" name="fantasy_name" value="<?php echo $ClientsResult->fantasy_name;?>">

                            </div>

                            <div class="col-sm-6 mb-2">

                                <label for="adress"> <b>Endereço</b></label>
                                <input type="text" class="form-control form-control-solid form-control form-control-solid" maxlength="255" id="adress" name="adress" value="<?php echo $ClientsResult->adress;?>">
                            </div>

                        </div> 

                        <div class="form-group row">
                            
                            <div class="col-sm-3 mb-2 pr-0">

                                <label for="document"> <b>CPF/CNPJ</b></label>
                                <div></div>
                                <input type="text" class="form-control form-control-solid form-control form-control-solid <?php echo $ClientsResult->type == 'F' ? 'cpf' : 'cnpj';?>" maxlength="14" id="document" name="document" value="<?php echo $ClientsResult->document;?>">
                            </div> 

                            <div class="col-sm-3 mb-2 pr-0">

                                <label for="zip_code"> <b>CEP</b></label>
                                <input type="text" class="form-control form-control-solid form-control form-control-solid postal_code" maxlength="9" id="zip_code" name="zip_code" value="<?php echo $ClientsResult->zip_code;?>" placeholder="Informe o CEP">
                            </div>

                            <div class="col-sm-3 mb-2 pr-0">

                                <label for="cns"> <b>CNS</b></label>
                                <input type="text" class="form-control form-control-solid form-control form-control-solid number" maxlength="14" id="cns" name="cns" value="<?php echo $ClientsResult->cns;?>" placeholder="Informe o CNS">
                            </div>

                        <div class="col-sm-3 mb-2">

                                <label for="number"> <b>Número</b></label>
                                <input type="text" class="form-control form-control-solid form-control form-control-solid" maxlength="10" id="number" name="number" value="<?php echo $ClientsResult->number;?>" placeholder="Informe o número">
                            </div>
                            
                        </div>
                        <div class="form-group row">
                            
                            <div class="col-sm-3 mb-2 pr-0">

                                <label for="complement"> <b>Complemento</b></label>
                                <input type="text" class="form-control form-control-solid form-control form-control-solid" maxlength="120" id="complement" name="complement" value="<?php echo $ClientsResult->complement;?>" placeholder="Informe o complemento">
                            </div>   
                            
                            <div class="col-sm-3 mb-2 pr-0">

                                <label for="district"> <b>Bairro</b></label>
                                <input type="text" class="form-control form-control-solid form-control form-control-solid" maxlength="120" id="district" name="district" value="<?php echo $ClientsResult->district;?>" placeholder="Informe o bairro">
                            </div> 
                            
                            <div class="col-sm-3 mb-2 pr-0">

                                <label for="city"> <b>Cidade</b></label>
                                <input type="text" class="form-control form-control-solid form-control form-control-solid" maxlength="120" id="city" name="city" value="<?php echo $ClientsResult->city ;?>" placeholder="Informe a cidade">
                            </div> 
                            
                            <div class="col-sm pr-0">

                                <label for="state_initials"> <b>Estado</b></label>

                                <select class="form-control form-control-solid form-control form-control-solid" id="state_initials" name="state_initials">
                                        <option value="" selected>Selecione</option>
                                        <option value="AC" <?php echo $ClientsResult->state_initials === 'AC' ? 'selected' : '';?>>AC</option>
                                        <option value="AL" <?php echo $ClientsResult->state_initials === 'AL' ? 'selected' : '';?>>AL</option>
                                        <option value="AP" <?php echo $ClientsResult->state_initials === 'AP' ? 'selected' : '';?>>AP</option>
                                        <option value="AM" <?php echo $ClientsResult->state_initials === 'AM' ? 'selected' : '';?>>AM</option>
                                        <option value="BA" <?php echo $ClientsResult->state_initials === 'BA' ? 'selected' : '';?>>BA</option>
                                        <option value="CE" <?php echo $ClientsResult->state_initials === 'CE' ? 'selected' : '';?>>CE</option>
                                        <option value="DF" <?php echo $ClientsResult->state_initials === 'DF' ? 'selected' : '';?>>DF</option>
                                        <option value="ES" <?php echo $ClientsResult->state_initials === 'ES' ? 'selected' : '';?>>ES</option>
                                        <option value="GO" <?php echo $ClientsResult->state_initials === 'GO' ? 'selected' : '';?>>GO</option>
                                        <option value="MA" <?php echo $ClientsResult->state_initials === 'MA' ? 'selected' : '';?>>MA</option>
                                        <option value="MT" <?php echo $ClientsResult->state_initials === 'MT' ? 'selected' : '';?>>MT</option>
                                        <option value="MS" <?php echo $ClientsResult->state_initials === 'MS' ? 'selected' : '';?>>MS</option>
                                        <option value="MG" <?php echo $ClientsResult->state_initials === 'MG' ? 'selected' : '';?>>MG</option>
                                        <option value="PA" <?php echo $ClientsResult->state_initials === 'PA' ? 'selected' : '';?>>PA</option>
                                        <option value="PB" <?php echo $ClientsResult->state_initials === 'PB' ? 'selected' : '';?>>PB</option>
                                        <option value="PR" <?php echo $ClientsResult->state_initials === 'PR' ? 'selected' : '';?>>PR</option>
                                        <option value="PE" <?php echo $ClientsResult->state_initials === 'PE' ? 'selected' : '';?>>PE</option>
                                        <option value="PI" <?php echo $ClientsResult->state_initials === 'PI' ? 'selected' : '';?>>PI</option>
                                        <option value="RJ" <?php echo $ClientsResult->state_initials === 'RJ' ? 'selected' : '';?>>RJ</option>
                                        <option value="RN" <?php echo $ClientsResult->state_initials === 'RN' ? 'selected' : '';?>>RN</option>
                                        <option value="RS" <?php echo $ClientsResult->state_initials === 'RS' ? 'selected' : '';?>>RS</option>
                                        <option value="RO" <?php echo $ClientsResult->state_initials === 'RO' ? 'selected' : '';?>>RO</option>
                                        <option value="RR" <?php echo $ClientsResult->state_initials === 'RR' ? 'selected' : '';?>>RR</option>
                                        <option value="SC" <?php echo $ClientsResult->state_initials === 'SC' ? 'selected' : '';?>>SC</option>
                                        <option value="SP" <?php echo $ClientsResult->state_initials === 'SP' ? 'selected' : '';?>>SP</option>
                                        <option value="SE" <?php echo $ClientsResult->state_initials === 'SE' ? 'selected' : '';?>>SE</option>
                                        <option value="TO" <?php echo $ClientsResult->state_initials === 'TO' ? 'selected' : '';?>>TO</option>
                                </select>                        

                            </div>  
                            
                            <div class="col-sm">

                                <label for="active"> <b>Situação</b></label>

                                <select class="form-control form-control-solid form-control form-control-solid" id="situation_id" name="situation_id">
                                        <option value=""  <?php echo $ClientsResult->situation_id  == ''  ? 'selected' : '';?>>Selecione um status</option>
                                        <option value= 1 <?php echo $ClientsResult->situation_id  == '1' ? 'selected' : '';?>>Ativo</option>
                                        <option value= 2 <?php echo $ClientsResult->situation_id  == '2' ? 'selected' : '';?>>Cancelado</option>
                                        <option value= 3 <?php echo $ClientsResult->situation_id  == '3' ? 'selected' : '';?>>Proposta</option>
                                        <option value= 4 <?php echo $ClientsResult->situation_id  == '4' ? 'selected' : '';?>>Candidato</option>
                                </select>

                            </div>                          

                        </div>                    
                        
                        <input type="hidden" name="TABLE" value="clients" />
                        <input type="hidden" name="ACTION" value="clients_save" />
                        <input type="hidden" name="FOLDER" value="action" />
                        <input type="hidden" name="clients_id" value="<?php echo $clientsId;?>" />

                        <div class="col-sm-3 text-end">
                                
                            <label for="btn-save"></label>
                            <a href="#" class="btn btn-primary btn-user w-100" id="btn-save" onclick="sendForm('#frmClients', '', true, '', 0, '', '<?php echo $clientsId > 0 ? 'Atualizando cadastro' : 'Cadastrando novo cliente';?>', 'random', 'circle', 'sm', true)"><i class="far fa-save"></i> <?php echo ((int)$clientsId > 0 ? 'Salvar alterações da empresa' : 'Cadastrar novo cliente') ?></a>
                        </div>                     

                    </form>

                </div>

            </div>

        </div>


        <div class="col-lg-12"> 

            <br/>
            <!-- Content Row -->
            <div class="row" id="loadClients"></div>        

        </div>

        <script type="text/javascript">

        /** Carrega as mascaras dos campos inputs */
        $(document).ready(function(e) {

            /** inputs mask */
            loadMask();

            /** tooltips */
            $('[data-toggle="tooltip"]').tooltip();  

        });

        </script>

        <script>

            function maskCpfCnpj(target){


                if($('#'+ target).val()=='F'){

                    $('#document').removeClass('cnpj');
                    $('#document').addClass('cpf');

                } else if($('#'+ target).val()=='J'){

                    $('#document').removeClass('cpf');
                    $('#document').addClass('cnpj');

                }

                loadMask();

            }

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
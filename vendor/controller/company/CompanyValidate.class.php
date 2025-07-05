<?php

/** Defino o local da classes */
namespace vendor\controller\company;

/** Importação de classes */
use vendor\controller\main\Main;

class CompanyValidate
{

    /** Parâmetros da classes */
    private $Main = null;
    private $errors = array();
	private $companyId = null;
	private $companyName = null;
	private $fantasyName = null;
	private $document = null;
	private $zipCode = null;
	private $adress = null;
	private $number = null;
	private $complement = null;
	private $district = null;
	private $city = null;
	private $stateInitials = null;
    private $info = null;
    private $name = null;
    private $file = null;
	private $base64 = null;
	private $dirTemp = null;
	private $dirUser = null;	
	private $dirPermission;
	private $dirGeral = null;
	private $dirCompany = null;
	private $dirYear = null;
	private $dirMonth = null;	
	private $dirImage = null;
	private $path = null;
	private $ext = null;
	private $archive = null; 
	private $mailUsername = null;
	private $mailPassword = null;
	private $mailInboundServer = null;
	private $mailInboundServerPort = null;
	private $mailOutgoingServer = null;
	private $mailOutgoingServerPort = null;
	private $mailWelcomeMessage = null;
	private $mailPasswordRecoveryMessage = null;
	private $allowed = null;
	private $usersId = null;
    

    /** Método construtor */
    public function __construct()
    {

        /** Instânciamento de classes */
        $this->Main = new Main();

		/** Diretório do usuario */
		$this->dirTemp = "temp";
		$this->dirGeral = "ged";
		$this->dirImage = "image";
		$this->dirFinancial = "financial";
		$this->dirUser = $this->Main->setzeros($_SESSION['USERSID'], 8);		
		$this->dirYear = date('Y');
		$this->dirMonth = date('m');
		$this->dirPermission = 0777;		

    }

	/** Trata o compo ID da empresa */
    public function setCompanyId(int $companyId): void
    {

        /** Tratamento da informação */
        $this->companyId = isset($companyId) ? (int)$this->Main->antiInjection($companyId) : 0;

    }

	/** Trata o campo  companyName*/
	public function setCompanyName(string $companyName) : void
	{

		/** Trata a entrada da informação  */
		$this->companyName = isset($companyName) ? (string)$this->Main->antiInjection($companyName) : null;

		/** Verifica se a informação foi informada */
		if(empty($this->companyName))
		{

			/** Adição de elemento */
			array_push($this->errors, 'O campo "Razão Social", deve ser informado');

		}

	}

	/** Trata o campo  fantasyName*/
	public function setFantasyName(string $fantasyName) : void
	{

		/** Trata a entrada da informação  */
		$this->fantasyName = isset($fantasyName) ? (string)$this->Main->antiInjection($fantasyName) : null;

		/** Verifica se a informação foi informada */
		if(empty($this->fantasyName))
		{

			/** Adição de elemento */
			array_push($this->errors, 'O campo "Nome Fantasia", deve ser informado');

		}

	}	
	
	/** Trata o campo  document*/
	public function setDocument(string $document) : void
	{

		/** Trata a entrada da informação  */
		$this->document = isset($document) ? (string)$this->Main->antiInjection($document) : null;

		/** Verifica se a informação foi informada */
		/*if(empty($this->document))
		{

			/** Adição de elemento */
			/*array_push($this->errors, 'O campo "Documento", deve ser informado');

		}*/

	}	

	/** Trata o campo  zipCode*/
	public function setZipCode(string $zipCode) : void
	{

		/** Trata a entrada da informação  */
		$this->zipCode = isset($zipCode) ? (string)$this->Main->antiInjection($zipCode) : null;

	}	

	/** Trata o campo  Adress*/
	public function setAdress(string $adress) : void
	{

		/** Trata a entrada da informação  */
		$this->adress = isset($adress) ? (string)$this->Main->antiInjection($adress) : null;

	}
	
	/** Trata o campo  Number*/
	public function setNumber(string $number) : void
	{

		/** Trata a entrada da informação  */
		$this->number = isset($number) ? (string)$this->Main->antiInjection($number) : 0;

	}	

	/** Trata o campo  Complement*/
	public function setComplement(string $complement) : void
	{

		/** Trata a entrada da informação  */
		$this->complement = isset($complement) ? (string)$this->Main->antiInjection($complement) : null;

	}	

	/** Trata o campo  District*/
	public function setDistrict(string $district) : void
	{

		/** Trata a entrada da informação  */
		$this->district = isset($district) ? (string)$this->Main->antiInjection($district) : null;

	}	

	/** Trata o campo  City*/
	public function setCity(string $city) : void
	{

		/** Trata a entrada da informação  */
		$this->district = isset($city) ? (string)$this->Main->antiInjection($city) : null;

	}	

	/** Trata o campo  StateInitials*/
	public function setStateInitials(string $stateInitials) : void
	{

		/** Trata a entrada da informação  */
		$this->stateInitials = isset($stateInitials) ? (string)$this->Main->antiInjection($stateInitials) : null;

	}	

	/** Trata o campo  Active*/
	public function setActive(string $active) : void
	{

		/** Trata a entrada da informação  */
		$this->active = isset($active) ? (string)$this->Main->antiInjection($active) : null;

	}	

	/** Método trata campo name, para upload de arquivos */
	public function setName(string $name) : void
	{

		/** Trata a entrada da informação  */
		$this->name = isset($name) ? (string)$this->Main->antiInjection($name) : null;

		/** Verifica se a informação foi informada */
		if(empty($this->name))
		{

			/** Adição de elemento */
			array_push($this->errors, 'Nenhum "Nome de Arquivo" enviado para esta solicitação');

		}

	}
    
	/** Método trata campo file, para upload de arquivos */
	public function setFile(string $file, int $usersId) : void
	{

		/** Trata a entrada da informação  */
		$this->file = isset($file) ? (string)$this->Main->antiInjection($file) : null;
		$this->usersId = $usersId;

		/** Extensões permitidas */
		$this->allowed = ['jpg', 'jpeg', 'png'];

		/** Verifica se a informação foi informada */
		if(!empty($this->file)){

			/** Pega a extensão do arquivo */
			$rev = explode(".", strrev($this->name));

			/** Pega a extensão do arquivo */
			$this->extension = strrev($rev[0]);	
			
			/** Verifica se o arquivo possui extensão permitida */
			if(in_array($this->extension, $this->allowed)){

				/** Pega o base64 do arquivo */
				$this->base64 = explode(",", $this->file);

				/** Diretório do usuario */
				$this->dirUser = $this->Main->setzeros($this->usersId, 6);

				/** Verifica se a pasta do usuário não existe */
				if( !is_dir($this->dirTemp.'/'.$this->dirUser) ){  
					
					/** Cria a pasta do usuário */
					mkdir($this->dirTemp.'/'.$this->dirUser, $this->dirPermission);            

				}

				/** Grava o arquivo na pasta temporária */
				$fp = fopen($this->dirTemp.'/'.$this->dirUser.'/'.$this->name, 'w');
					fwrite($fp, base64_decode($this->base64[1]));
					fclose($fp);


				/** Verifica se o arquivo foi enviado, caso não tenha sido enviado informo */
				if(!is_file($this->dirTemp.'/'.$this->dirUser.'/'.$this->name)){

					/** Adição de elemento */
					array_push($this->errors, 'Não foi possível mover o arquivo para pasta temporaria');				
				}
				
			}else{

				/** Adição de elemento */
				array_push($this->errors, 'Somente são permitidos arquivos do tipo jpg, jpeg, png');				
			}

		}else{

			/** Adição de elemento */
			array_push($this->errors, 'Nenhum "Arquivo" enviado para esta solicitação');			
		}

	}

	/** Método move o arquivo para pasta definitiva da empresa */
	public function moveFile(int $companyid, string $file, int $usersId) : void
	{

		/** Parametros de entrada */
		$this->companyid = $companyid;
		$this->dirCompany = $this->Main->setzeros($companyid, 8);
		$this->file = $file;
		$this->usersId = $usersId;
		$this->dirUser = $this->Main->setzeros($this->usersId, 6); # Diretório do usuario
		$this->path = $this->dirTemp.'/'.$this->dirUser.'/'.$this->file; # Caminho absoluto do arquivo

		/** Verifica se a informação não foi informada */
		if( (!empty($this->file)) && ($this->companyid > 0) )
		{

			/** Verifica se o arquivo existe na pasta temporária */
			if( is_file($this->path) ){
				
				/** Verifica se a pasta image existe */
				if( !is_dir($this->dirGeral.'/'.$this->dirImage) ){

					/** Cria o diretório */
					mkdir($this->dirGeral.'/'.$this->dirImage, $this->dirPermission);

				}

				/** Verifica se a pasta company existe */
				if( !is_dir($this->dirGeral.'/'.$this->dirImage.'/'.$this->dirCompany) ){

					/** Cria o diretório */
					mkdir($this->dirGeral.'/'.$this->dirImage.'/'.$this->dirCompany, $this->dirPermission);

				}
											
				/** Verifica se a pasta de destino existe */
				if( is_dir($this->dirGeral.'/'.$this->dirImage.'/'.$this->dirCompany) ){

					/** Pega a extensão do arquivo */
					$rev = explode(".", strrev($this->file));

					/** Pega a extensão do arquivo */
					$this->extension = strrev($rev[0]);

					/** Gera um nome de arquivo aleatorio com o seu caminho absoluto */
					$this->archive = $this->dirGeral.'/'.$this->dirImage.'/'.$this->dirCompany.'/'.md5($this->Main->NewPassword()).'.'.$this->extension; 
										
					/** Move o arquivo para o diretório de destino */
					rename($this->path, $this->archive); 

					/** Verifica se o arquivo foi enviado corretamente, caso não tenha sido, informo */
					if( !is_file($this->archive) ){

						/** Adição de elemento */
						array_push($this->errors, 'Não foi possível mover o arquivo');						
					}

				}else{

					/** Adição de elemento */
					array_push($this->errors, 'Não foi possível mover o arquivo, diretório não encontrado');					
				}

			}else{

				/** Adição de elemento */
				array_push($this->errors, 'O "Arquivo", deve ser informado');								
			}

		}else{

			/** Adição de elemento */
			array_push($this->errors, 'O "Arquivo" e a empresa devem ser informados');			
		}
	}		
	
	/** Trata o campo  MailUsername*/
	public function setMailUsername(string $mailUsername) : void
	{

		/** Trata a entrada da informação  */
		$this->mailUsername = isset($mailUsername) ? (string)$this->Main->antiInjection($mailUsername) : '';

		/** Verifica se a informação foi informada */
		if(empty($this->mailUsername))
		{

			/** Adição de elemento */
			array_push($this->errors, 'O campo "Usuário" deve ser informado');

		}

	}	

	/** Trata o campo  MailPassword*/
	public function setMailPassword(string $mailPassword) : void
	{

		/** Trata a entrada da informação  */
		$this->mailPassword = isset($mailPassword) ? (string)$this->Main->antiInjection($mailPassword) : '';

		/** Verifica se a informação foi informada */
		if(empty($this->mailPassword))
		{

			/** Adição de elemento */
			array_push($this->errors, 'O campo "Senha" deve ser informado');

		}

	}	

	/** Trata o campo  MailInboundServer*/
	public function setMailInboundServer(string $mailInboundServer) : void
	{

		/** Trata a entrada da informação  */
		$this->mailInboundServer = isset($mailInboundServer) ? (string)$this->Main->antiInjection($mailInboundServer) : '';

		/** Verifica se a informação foi informada */
		if(empty($this->mailInboundServer))
		{

			/** Adição de elemento */
			array_push($this->errors, 'O campo "Servidor de entrada" deve ser informado');

		}

	}	

	/** Trata o campo  MailInboundServerPort*/
	public function setMailInboundServerPort(string $mailInboundServerPort) : void
	{

		/** Trata a entrada da informação  */
		$this->mailInboundServerPort = isset($mailInboundServerPort) ? (string)$this->Main->antiInjection($mailInboundServerPort) : '';

		/** Verifica se a informação foi informada */
		if(empty($this->mailInboundServerPort))
		{

			/** Adição de elemento */
			array_push($this->errors, 'O campo "Servidor de entrada/Porta" deve ser informado');

		}

	}
	
	/** Trata o campo  MailOutgoingServer*/
	public function setMailOutgoingServer(string $mailOutgoingServer) : void
	{

		/** Trata a entrada da informação  */
		$this->mailOutgoingServer = isset($mailOutgoingServer) ? (string)$this->Main->antiInjection($mailOutgoingServer) : '';

		/** Verifica se a informação foi informada */
		if(empty($this->mailOutgoingServer))
		{

			/** Adição de elemento */
			array_push($this->errors, 'O campo "Servidor de saída" deve ser informado');

		}

	}
	
	/** Trata o campo  MailOutgoingServerPort*/
	public function setMailOutgoingServerPort(string $mailOutgoingServerPort) : void
	{

		/** Trata a entrada da informação  */
		$this->mailOutgoingServerPort = isset($mailOutgoingServerPort) ? (string)$this->Main->antiInjection($mailOutgoingServerPort) : '';

		/** Verifica se a informação foi informada */
		if(empty($this->mailOutgoingServerPort))
		{

			/** Adição de elemento */
			array_push($this->errors, 'O campo "Servidor de saída/Porta" deve ser informado');

		}

	}	

	/** Trata o campo  MailWelcomeMessage*/
	public function setMailWelcomeMessage(string $MailWelcomeMessage) : void
	{

		/** Trata a entrada da informação  */
		$this->mailWelcomeMessage = isset($MailWelcomeMessage) ? (string)$this->Main->antiInjection($MailWelcomeMessage, 'S') : '';

		/** Verifica se a informação foi informada */
		if(empty($this->mailWelcomeMessage))
		{

			/** Adição de elemento */
			array_push($this->errors, 'O campo "Mensagem de boas vindas" deve ser informado');

		}

	}
	
	/** Trata o campo  MailPasswordRecoveryMessage */
	public function setMailPasswordRecoveryMessage(string $MailPasswordRecoveryMessage) : void
	{

		/** Trata a entrada da informação  */
		$this->mailPasswordRecoveryMessage = isset($MailPasswordRecoveryMessage) ? (string)$this->Main->antiInjection($MailPasswordRecoveryMessage, 'S') : '';

		/** Verifica se a informação foi informada */
		if(empty($this->mailPasswordRecoveryMessage))
		{

			/** Adição de elemento */
			array_push($this->errors, 'O campo "Mensagem de recuperação de senha" deve ser informado');

		}

	}	
	
	
	/** Trata o retorno companyId*/
    public function getCompanyId(): int
    {

        /** Retorno da informação */
        return (int)$this->companyId;
    }

	/** Trata o retorno companyName*/
	public function getCompanyName() : ? string
	{

		/** Trata o retorno da informação  */
		return (string)$this->companyName;
	}

	/** Trata o retorno do campo  fantasyName*/
	public function getFantasyName() : ? string
	{

		/** Trata a entrada da informação  */
		return (string)$this->fantasyName;
	}	
	
	/** Trata o retorno campo  document*/
	public function getDocument() : ? string
	{

		/** Trata o retorno da informação  */
		return (string)$this->document;
	}	

	/** Retorna o campo  ZipCode */
	public function getZipCode() : ? string
	{

		/** Trata o retorno da informação  */
		return (string)$this->zipCode;
	}	

	/** Retorna o campo  Adress*/
	public function getAdress() : ? string
	{

		/** Trata o retorno da informação  */
		return (string)$this->adress;
	}
	
	/** Retorna o campo  Number*/
	public function getNumber() : ? string
	{

		/** Trata o retorno da informação  */
		return (string)$this->number;
	}	

	/** Trata o retorno do campo  Complement*/
	public function getComplement() : ? string
	{

		/** Trata o retorno da informação  */
		return (string)$this->complement;
	}	

	/** Trata o retorno campo  District*/
	public function getDistrict() : ? string
	{

		/** Trata o retorno da informação  */
		return (string)$this->district;
	}	

	/** Trata o retorno campo  City*/
	public function getCity() : ? string
	{

		/** Trata o retorno da informação  */
		return (string)$this->city;

	}	

	/** Trata o retorno campo  StateInitials*/
	public function getStateInitials() : ? string
	{

		/** Trata o retorno da informação  */
		return (string)$this->stateInitials;
	}	

	/** Trata o retorno campo  Active*/
	public function getActive() : ? string
	{

		/** Trata o retorno da informação  */
		return $this->active;

	}		
    
	/** Método retorna campo name do arquivo */
	public function getName() : ? string
	{

		/** Retorno da informação */
		return (string)$this->name;

	}

	/** Método retorna o diretório temporário do arquivo */
	public function getDirTemp() : ? string
	{

		/** Retorno da informação */
		return (string)$this->dirTemp;

	}	

	/** Método retorna o diretório temporário do arquivo */
	public function getDirUser() : ? string
	{

		/** Retorno da informação */
		return (string)$this->dirUser;

	}
	
	/** Método retorna campo Servidor de entrada */
	public function getMailInboundServer() : ? string
	{

		/** Retorno da informação */
		return (string)$this->mailInboundServer;

	}	

	/** Método retorna campo Username */
	public function getMailUsername() : ? string
	{

		/** Retorno da informação */
		return (string)$this->mailUsername;

	}	

	/** Método retorna campo MailPassword */
	public function getMailPassword() : ? string
	{

		/** Retorno da informação */
		return (string)$this->mailPassword;

	}	

	/** Método retorna campo MailInboundServerPort */
	public function getMailInboundServerPort() : ? string
	{

		/** Retorno da informação */
		return (string)$this->mailInboundServerPort;

	}

	/** Método retorna campo MailOutgoingServer */
	public function getMailOutgoingServer() : ? string
	{

		/** Retorno da informação */
		return (string)$this->mailOutgoingServer;

	}
	
	/** Método retorna campo MailOutgoingServerPort */
	public function getMailOutgoingServerPort() : ? string
	{

		/** Retorno da informação */
		return (string)$this->mailOutgoingServerPort;

	}	
	
	/** Método retorna campo PasswordRecoveryMessage */
	public function getMailPasswordRecoveryMessage() : ? string
	{

		/** Retorno da informação */
		return (string)$this->mailPasswordRecoveryMessage;

	}	

	/** Método retorna campo PasswordRecoveryMessage */
	public function getMailWelcomeMessage() : ? string
	{

		/** Retorno da informação */
		return (string)$this->mailWelcomeMessage;

	}
	
	/** Método retorna o arquivo/imagem da empresa */
	public function getArchive() : ? string
	{

		/** Retorno da informação */
		return (string)$this->archive;

	}	

    public function getErrors(): string
    {

        /** Verifico se deve informar os erros */
        if (count($this->errors)) {

            /** Verifica a quantidade de erros para informar a legenda */
            $this->info = count($this->errors) > 1 ? 'Os seguintes erros foram encontrados:' : 'O seguinte erro foi encontrado:';

            /** Lista os erros  */
            foreach ($this->errors as $keyError => $error) {

                /** Monto a mensagem de erro */
                $this->info .= '</br>' . ($keyError + 1) . ' - ' . $error;

            }

            /** Retorno os erros encontrados */
            return (string)$this->info;

        } else {

            return false;

        }

    }

	/** destrutor da classe */
	public function __destruct(){}    

}
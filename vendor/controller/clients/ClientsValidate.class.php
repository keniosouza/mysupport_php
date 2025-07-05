<?php
/**
* Classe ClientsValidate.class.php
* @filesource
* @autor		Kenio de Souza
* @copyright	Copyright 2022 - Souza Consultoria Tecnológica
* @package		vendor
* @subpackage	controller/clients
* @version		1.0
* @date		 	23/01/2022
*/


/** Defino o local onde esta a classe */
namespace vendor\controller\clients;

/** Importação de classes */
use vendor\controller\main\Main;

class ClientsValidate
{
	/** Declaro as variavéis da classe */
    private $Main = null;
    private $errors = array();
    private $info = null;
	private $clientsId = null;
	private $usersId = null;
	private $companyId = null;
	private $situationId = null;
	private $clientName = null;
	private $fantasyName = null;
	private $document = null;
	private $cns = null;
	private $zipCode = null;
	private $adress = null;
	private $number = null;
	private $complement = null;
	private $district = null;
	private $city = null;
	private $state = null;
	private $stateInitials = null;
	private $country = null;
	private $dateRegister = null;
	private $responsible = null;
	private $type = null;

	/** Construtor da classe */
	function __construct()
	{

		/** Instânciamento da classe de validação */
		$this->Main = new Main();

	}

	/** Método trata campo clients_id */
	public function setClientsId(int $clientsId) : void
	{

		/** Trata a entrada da informação  */
		$this->clientsId = isset($clientsId) ? $this->Main->antiInjection($clientsId) : 0;

		/** Verifica se a informação foi informada */
		if($this->clientsId < 0)
		{

			/** Adição de elemento */
			array_push($this->errors, 'O campo "clients id", deve ser informado');

		}

	}

	/** Método trata campo users_id */
	public function setUsersId(int $usersId) : void
	{

		/** Trata a entrada da informação  */
		$this->usersId = isset($usersId) ? $this->Main->antiInjection($usersId) : 0;

		/** Verifica se a informação foi informada */
		if(empty($this->usersId))
		{

			/** Adição de elemento */
			array_push($this->errors, 'O campo "users id", deve ser informado');

		}

	}

	/** Método trata campo company_id */
	public function setCompanyId(int $companyId) : void
	{

		/** Trata a entrada da informação  */
		$this->companyId = isset($companyId) ? $this->Main->antiInjection($companyId) : 0;

		/** Verifica se a informação foi informada */
		if(empty($this->companyId))
		{

			/** Adição de elemento */
			array_push($this->errors, 'O campo "company id", deve ser informado');

		}

	}

    /** Método trata campo situation_id */
    public function setSituationId(int $situationId) : void
    {

        /** Trata a entrada da informação  */
        $this->situationId = isset($situationId) ? $this->Main->antiInjection($situationId) : 0;

        /** Verifica se a informação foi informada */
        if(empty($this->situationId))
        {

            /** Adição de elemento */
            array_push($this->errors, 'O campo "Situação", deve ser informado');

        }

    }

	/** Método trata campo client_name */
	public function setClientName(string $clientName) : void
	{

		/** Trata a entrada da informação  */
		$this->clientName = isset($clientName) ? $this->Main->antiInjection($clientName) : null;

		/** Verifica se a informação foi informada */
		if(empty($this->clientName))
		{

			/** Adição de elemento */
			array_push($this->errors, 'Informe a razão social da empresa ou nome do cliente');

		}

	}

	/** Método trata campo fantasy_name */
	public function setFantasyName(string $fantasyName) : void
	{

		/** Trata a entrada da informação  */
		$this->fantasyName = isset($fantasyName) ? $this->Main->antiInjection($fantasyName) : null;

		/** Verifica se a informação foi informada */
		if( (empty($this->fantasyName)) && ($this->type == 'J') )
		{

			/** Adição de elemento */
			array_push($this->errors, 'Informe o nome fantasia da empresa / cliente');

		}

	}

	/** Método trata campo document */
	public function setDocument(string $document) : void
	{

		/** Trata a entrada da informação  */
		$this->document = isset($document) ? $this->Main->antiInjection($document) : null;

		/** Verifica se a informação foi informada */
		if(empty($this->document)) {

            /** Adição de elemento */
            array_push($this->errors, 'O campo "CPF/CNPJ" deve ser informado');

        } elseif(!$this->Main->validar_cpf_cnpj($document)) {/** Verifique se o CPF/CNPJ informado é válido! */

                /** Adição de elemento */
                array_push($this->errors, 'O "CPF/CNPJ" informado é inválido');

            }

	}



    /** Método trata campo cns */
    public function setCns(int $cns) : void
    {

        /** Trata a entrada da informação  */
        $this->cns = isset($cns) ? $this->Main->antiInjection($cns) : 0;

        /** Verifica se a informação foi informada */
        if(empty($this->cns))
        {

            /** Adição de elemento */
            array_push($this->errors, 'O campo "Cns", deve ser informado');

        }

    }

	/** Método trata campo zip_code */
	public function setZipCode(string $zipCode) : void
	{

		/** Trata a entrada da informação  */
		$this->zipCode = isset($zipCode) ? $this->Main->antiInjection($zipCode) : null;

		/** Verifica se a informação foi informada */
		if(empty($this->zipCode))
		{

			/** Adição de elemento */
			array_push($this->errors, 'O campo "CEP", deve ser informado');

		}

	}

	/** Método trata campo adress */
	public function setAdress(string $adress) : void
	{

		/** Trata a entrada da informação  */
		$this->adress = isset($adress) ? $this->Main->antiInjection($adress) : null;

		/** Verifica se a informação foi informada */
		if(empty($this->adress))
		{

			/** Adição de elemento */
			array_push($this->errors, 'O campo "Endereço", deve ser informado');

		}

	}

	/** Método trata campo number */
	public function setNumber(string $number) : void
	{

		/** Trata a entrada da informação  */
		$this->number = isset($number) ? $this->Main->antiInjection($number) : null;

		/** Verifica se a informação foi informada */
		if(empty($this->number))
		{

			/** Adição de elemento */
			array_push($this->errors, 'O campo "Número", deve ser informado');

		}

	}

	/** Método trata campo complement */
	public function setComplement(string $complement) : void
	{

		/** Trata a entrada da informação  */
		$this->complement = isset($complement) ? $this->Main->antiInjection($complement) : null;

		/** Verifica se a informação foi informada */
		if(empty($this->complement))
		{

			/** Adição de elemento */
			array_push($this->errors, 'O campo "Complemento", deve ser informado');

		}

	}

	/** Método trata campo district */
	public function setDistrict(string $district) : void
	{

		/** Trata a entrada da informação  */
		$this->district = isset($district) ? $this->Main->antiInjection($district) : null;

		/** Verifica se a informação foi informada */
		if(empty($this->district))
		{

			/** Adição de elemento */
			array_push($this->errors, 'O campo "Bairro", deve ser informado');

		}

	}

	/** Método trata campo city */
	public function setCity(string $city) : void
	{

		/** Trata a entrada da informação  */
		$this->city = isset($city) ? $this->Main->antiInjection($city) : null;

		/** Verifica se a informação foi informada */
		if(empty($this->city))
		{

			/** Adição de elemento */
			array_push($this->errors, 'O campo "Cidade", deve ser informado');

		}

	}

	/** Método trata campo state */
	public function setState(string $state) : void
	{

		/** Trata a entrada da informação  */
		$this->state = isset($state) ? $this->Main->antiInjection($state) : null;

		/** Verifica se a informação foi informada */
		if(empty($this->state))
		{

			/** Adição de elemento */
			array_push($this->errors, 'O campo "state", deve ser informado');

		}

	}

	/** Método trata campo state_initials */
	public function setStateInitials(string $stateInitials) : void
	{

		/** Trata a entrada da informação  */
		$this->stateInitials = isset($stateInitials) ? $this->Main->antiInjection($stateInitials) : null;

		/** Verifica se a informação foi informada */
		if(empty($this->stateInitials))
		{

			/** Adição de elemento */
			array_push($this->errors, 'O campo "Estado", deve ser informado');

		}

	}

	/** Método trata campo country */
	public function setCountry(string $country) : void
	{

		/** Trata a entrada da informação  */
		$this->country = isset($country) ? $this->Main->antiInjection($country) : null;

		/** Verifica se a informação foi informada */
		if(empty($this->country))
		{

			/** Adição de elemento */
			array_push($this->errors, 'O campo "country", deve ser informado');

		}

	}

	/** Método trata campo date_register */
	public function setDateRegister(string $dateRegister) : void
	{

		/** Trata a entrada da informação  */
		$this->dateRegister = isset($dateRegister) ? $this->Main->antiInjection($dateRegister) : null;

		/** Verifica se a informação foi informada */
		if(empty($this->dateRegister))
		{

			/** Adição de elemento */
			array_push($this->errors, 'O campo "date register", deve ser informado');

		}

	}

	/** Método trata campo responsible */
	public function setResponsible(int $responsible) : void
	{

		/** Trata a entrada da informação  */
		$this->responsible = isset($responsible) ? $this->Main->antiInjection($responsible) : 0;

		/** Verifica se a informação foi informada */
		if(empty($this->responsible))
		{

			/** Adição de elemento */
			array_push($this->errors, 'O campo "responsible", deve ser informado');

		}

	}


	/** Método trata campo type */
	public function setType(string $type) : void
	{

		/** Trata a entrada da informação  */
		$this->type = isset($type) ? $this->Main->antiInjection($type) : null;

		/** Verifica se a informação foi informada */
		if(empty($this->type))
		{
			
			/** Adição de elemento */
			array_push($this->errors, 'Informe o tipo do cliente - Jurídica / Física');

		}

	}


	/** Método retorna campo clients_id */
	public function getClientsId() : ? int
	{

		/** Retorno da informação */
		return (int)$this->clientsId;

	}

	/** Método retorna campo users_id */
	public function getUsersId() : ? int
	{

		/** Retorno da informação */
		return $this->usersId;

	}

	/** Método retorna campo company_id */
	public function getCompanyId() : ? int
	{

		/** Retorno da informação */
		return $this->companyId;

	}

    /** Método retorna campo situation_id */
    public function getSituationId() : ? int
    {

        /** Retorno da informação */
        return (int)$this->situationId;

    }

	/** Método retorna campo client_name */
	public function getClientName() : ? string
	{

		/** Retorno da informação */
		return $this->clientName;

	}

	/** Método retorna campo fantasy_name */
	public function getFantasyName() : ? string
	{

		/** Retorno da informação */
		return $this->fantasyName;

	}

	/** Método retorna campo document */
	public function getDocument() : ? string
	{

		/** Retorno da informação */
		return $this->document;

	}

    /** Método retorna campo cns */
    public function getCns() : ? int
    {

        /** Retorno da informação */
        return (int)$this->cns;

    }

	/** Método retorna campo zip_code */
	public function getZipCode() : ? string
	{

		/** Retorno da informação */
		return $this->zipCode;

	}

	/** Método retorna campo adress */
	public function getAdress() : ? string
	{

		/** Retorno da informação */
		return $this->adress;

	}

	/** Método retorna campo number */
	public function getNumber() : ? string
	{

		/** Retorno da informação */
		return $this->number;

	}

	/** Método retorna campo complement */
	public function getComplement() : ? string
	{

		/** Retorno da informação */
		return $this->complement;

	}

	/** Método retorna campo district */
	public function getDistrict() : ? string
	{

		/** Retorno da informação */
		return $this->district;

	}

	/** Método retorna campo city */
	public function getCity() : ? string
	{

		/** Retorno da informação */
		return $this->city;

	}

	/** Método retorna campo state */
	public function getState() : ? string
	{

		/** Retorno da informação */
		return $this->state;

	}

	/** Método retorna campo state_initials */
	public function getStateInitials() : ? string
	{

		/** Retorno da informação */
		return $this->stateInitials;

	}

	/** Método retorna campo country */
	public function getCountry() : ? string
	{

		/** Retorno da informação */
		return $this->country;

	}

	/** Método retorna campo date_register */
	public function getDateRegister() : ? string
	{

		/** Retorno da informação */
		return $this->dateRegister;

	}

	/** Método retorna campo responsible */
	public function getResponsible() : ? int
	{

		/** Retorno da informação */
		return $this->responsible;

	}


	/** Método retorna campo type */
	public function getType() : ? string
	{

		/** Retorno da informação */
		return $this->type;

	}



	public function getErrors(): ? string
	{

		/** Verifico se deve informar os erros */
		if (count($this->errors)) {

	   		/** Verifica a quantidade de erros para informar a legenda */
	   		$this->info = count($this->errors) > 1 ? '<center>Os seguintes erros foram encontrados</center>' : '<center>O seguinte erro foi encontrado</center>';

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

<?php
/**
* Classe CallsClientsValidate.class.php
* @filesource
* @autor		Kenio de Souza
* @copyright	Copyright 2022 - Souza Consultoria Tecnológica
* @package		vendor
* @subpackage	controller/calls_clients
* @version		1.0
* @date		 	08/03/2022
*/


/** Defino o local onde esta a classe */
namespace vendor\controller\calls_clients;

/** Importação de classes */
use vendor\controller\main\Main;

class CallsClientsValidate
{
	/** Declaro as variavéis da classe */
    private $Main = null;
    private $errors = array();
    private $info = null;
	private $callClientId = null;
	private $callId = null;
	private $clientId = null;
	private $companyId = null;
	private $history = null;

	/** Construtor da classe */
	function __construct()
	{

		/** Instânciamento da classe de validação */
		$this->Main = new Main();

	}

	/** Método trata campo call_client_id */
	public function setCallClientId(int $callClientId) : void
	{

		/** Trata a entrada da informação  */
		$this->callClientId = isset($callClientId) ? $this->Main->antiInjection($callClientId) : null;

		/** Verifica se a informação foi informada */
		if($this->callClientId < 0)
		{

			/** Adição de elemento */
			array_push($this->errors, 'O campo "call_client_id", deve ser informado');

		}

	}

	/** Método trata campo call_id */
	public function setCallId(int $callId) : void
	{

		/** Trata a entrada da informação  */
		$this->callId = isset($callId) ? $this->Main->antiInjection($callId) : null;

		/** Verifica se a informação foi informada */
		if($this->callId <= 0)
		{

			/** Adição de elemento */
			array_push($this->errors, 'O campo "call_id", deve ser informado');

		}

	}

	/** Método trata campo client_id */
	public function setClientId(int $clientId) : void
	{

		/** Trata a entrada da informação  */
		$this->clientId = isset($clientId) ? $this->Main->antiInjection($clientId) : null;

		/** Verifica se a informação foi informada */
		if($this->clientId <= 0)
		{

			/** Adição de elemento */
			array_push($this->errors, 'O campo "client_id", deve ser informado');

		}

	}

	/** Método trata campo company_id */
	public function setCompanyId(int $companyId) : void
	{

		/** Trata a entrada da informação  */
		$this->companyId = isset($companyId) ? $this->Main->antiInjection($companyId) : null;

		/** Verifica se a informação foi informada */
		if($this->companyId <= 0)
		{

			/** Adição de elemento */
			array_push($this->errors, 'O campo "company_id", deve ser informado');

		}

	}

	/** Método trata campo history */
	public function setHistory(string $history) : void
	{

		/** Trata a entrada da informação  */
		$this->history = isset($history) ? $this->Main->antiInjection($history, 'S') : null;

		/** Verifica se a informação foi informada */
		if(empty($this->history))
		{

			/** Adição de elemento */
			array_push($this->errors, 'O campo "history", deve ser informado');

		}

	}

	/** Método retorna campo call_client_id */
	public function getCallClientId() : ? int
	{

		/** Retorno da informação */
		return (int)$this->callClientId;

	}

	/** Método retorna campo call_id */
	public function getCallId() : ? int
	{

		/** Retorno da informação */
		return (int)$this->callId;

	}

	/** Método retorna campo client_id */
	public function getClientId() : ? int
	{

		/** Retorno da informação */
		return (int)$this->clientId;

	}

	/** Método retorna campo company_id */
	public function getCompanyId() : ? int
	{

		/** Retorno da informação */
		return (int)$this->companyId;

	}

	/** Método retorna campo history */
	public function getHistory() : ? string
	{

		/** Retorno da informação */
		return (string)$this->history;

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

	function __destruct(){}

}

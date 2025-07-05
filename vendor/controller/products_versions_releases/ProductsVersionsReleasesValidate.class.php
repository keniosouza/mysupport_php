<?php
/**
* Classe ProductsVersionsReleasesValidate.class.php
* @filesource
* @autor		Kenio de Souza
* @copyright	Copyright 2022 - Souza Consultoria Tecnológica
* @package		vendor
* @subpackage	controller/products_versions_releases
* @version		1.0
* @date		 	18/04/2022
*/


/** Defino o local onde esta a classe */
namespace vendor\controller\products_versions_releases;

/** Importação de classes */
use vendor\controller\main\Main;

class ProductsVersionsReleasesValidate
{
	/** Declaro as variavéis da classe */
    private $Main = null;
    private $errors = array();
    private $info = null;
	private $productVersionReleaseId = null;
	private $productVersionId = null;
	private $description = null;
	private $number = null;
	private $status = null;
	private $history = null;

	/** Construtor da classe */
	function __construct()
	{

		/** Instânciamento da classe de validação */
		$this->Main = new Main();

	}

	/** Método trata campo product_version_release_id */
	public function setProductVersionReleaseId(int $productVersionReleaseId) : void
	{

		/** Trata a entrada da informação  */
		$this->productVersionReleaseId = isset($productVersionReleaseId) ? $this->Main->antiInjection($productVersionReleaseId) : null;

		/** Verifica se a informação foi informada */
		if($this->productVersionReleaseId < 0)
		{

			/** Adição de elemento */
			array_push($this->errors, 'O campo "product_version_release_id", deve ser informado');

		}

	}

	/** Método trata campo product_version_id */
	public function setProductVersionId(int $productVersionId) : void
	{

		/** Trata a entrada da informação  */
		$this->productVersionId = isset($productVersionId) ? $this->Main->antiInjection($productVersionId) : null;

		/** Verifica se a informação foi informada */
		if($this->productVersionId <= 0)
		{

			/** Adição de elemento */
			array_push($this->errors, 'O campo "product_version_id", deve ser informado');

		}

	}

	/** Método trata campo description */
	public function setDescription(string $description) : void
	{

		/** Trata a entrada da informação  */
		$this->description = isset($description) ? $this->Main->antiInjection($description, 'S') : null;

		/** Verifica se a informação foi informada */
		if(empty($this->description))
		{

			/** Adição de elemento */
			array_push($this->errors, 'O campo "description", deve ser informado');

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
			array_push($this->errors, 'O campo "number", deve ser informado');

		}

	}

	/** Método trata campo status */
	public function setStatus(string $status) : void
	{

		/** Trata a entrada da informação  */
		$this->status = isset($status) ? $this->Main->antiInjection($status) : null;

		/** Verifica se a informação foi informada */
		if(empty($this->status))
		{

			/** Adição de elemento */
			array_push($this->errors, 'O campo "status", deve ser informado');

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

	/** Método retorna campo product_version_release_id */
	public function getProductVersionReleaseId() : ? int
	{

		/** Retorno da informação */
		return (int)$this->productVersionReleaseId;

	}

	/** Método retorna campo product_version_id */
	public function getProductVersionId() : ? int
	{

		/** Retorno da informação */
		return (int)$this->productVersionId;

	}

	/** Método retorna campo description */
	public function getDescription() : ? string
	{

		/** Retorno da informação */
		return (string)$this->description;

	}

	/** Método retorna campo number */
	public function getNumber() : ? string
	{

		/** Retorno da informação */
		return (string)$this->number;

	}

	/** Método retorna campo status */
	public function getStatus() : ? string
	{

		/** Retorno da informação */
		return (string)$this->status;

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

<?php

/** Defino o local onde esta a classe */
namespace vendor\controller\clients_logs;

/** Importação de Classe */
use vendor\controller\main\Main;

class ClientsLogsValidate
{
	/** Declaro as variavéis da classe */
    private $Main = null;
    private $errors = array();
    private $info = null;

    private $clientErrorLogId;
    private $clientId;
    private $productId;
    private $logTypeId;
    private $data;
    private $dateRegister;

    public function __construct()
    {

        /** Instânciamento de classe */
        $this->Main = new Main();

    }

    /** Tratamento do valor informado */
    public function setClientErrorLogId(int $clientErrorLogId) : void
    {

        /** Trata a entrada da informação  */
        $this->clientErrorLogId = $this->Main->antiInjection($clientErrorLogId);

    }

    /** Obteno o valor tratado */
    public function getClientErrorLogId() : int
    {

        /** Retorno da informação */
        return (int)$this->clientErrorLogId;

    }

    /** Tratamento do valor informado */
    public function setClientId(int $clientId) : void
    {

        /** Trata a entrada da informação  */
        $this->clientId = $this->Main->antiInjection($clientId);

        /** Verifica se a informação foi informada */
        if ($this->clientId <= 0) {

            /** Adição de elemento */
            array_push($this->errors, 'O campo "cliente", deve ser informado');

        }

    }

    /** Obteno o valor tratado */
    public function getClientId() : int
    {

        /** Retorno da informação */
        return (int)$this->clientId;

    }

    public function setProductId(int $productId) : void
    {

        $this->productId = $this->Main->antiInjection($productId);

        /** Verifica se a informação foi informada */
        if ($this->productId <= 0) {

            /** Adição de elemento */
            array_push($this->errors, 'O campo "produto", deve ser informado');

        }

    }

    /** Obteno o valor tratado */
    public function getProductId() : int
    {

        /** Retorno da informação */
        return (int)$this->productId;

    }

    public function setLogTypeId(int $logTypeId) : void
    {

        $this->logTypeId = $this->Main->antiInjection($logTypeId);

        /** Verifica se a informação foi informada */
        if ($this->logTypeId <= 0) {

            /** Adição de elemento */
            array_push($this->errors, 'O campo "produto", deve ser informado');

        }

    }

    /** Obteno o valor tratado */
    public function getLogTypeId() : int
    {

        /** Retorno da informação */
        return (int)$this->logTypeId;

    }

    /** Tratamento do valor informado */
    public function setData(string $data) : void
    {

        /** Tratamento da informação */
        $this->data = $this->Main->antiInjection($data, 'S');

        /** Verifica se a informação foi informada */
        if (empty($this->data)) {

            /** Adição de elemento */
            array_push($this->errors, 'O campo "daddos", deve ser informado');

        }

    }

    /** Obteno o valor tratado */
    public function getData() : string
    {

        /** Retorno da informação */
        return (string)$this->data;

    }

    /** Tratamento do valor informado */
    public function setDateRegister(string $dateRegister) : void
    {

        /** Tratamento da informação */
        $this->dateRegister = $this->Main->antiInjection($dateRegister);

        /** Verifica se a informação foi informada */
        if (empty($this->dateRegister)) {

            /** Adição de elemento */
            array_push($this->errors, 'O campo "data de registro", deve ser informado');

        }

    }

    /** Obteno o valor tratado */
    public function getDateRegister() : string
    {

        /** Retorno da informação */
        return (string)$this->dateRegister;

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

}

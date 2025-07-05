<?php

/** Defino o local onde esta a classe */
namespace vendor\controller\clients_backups_logs;

class ClientsBackupsLogsValidate
{
	/** Declaro as variavéis da classe */
    private $errors = array();
    private $info = null;

    private $clientBackupLogId;
    private $clientId;
    private $path;
    private $name;
    private $size;
    private $dateRegister;
    private $dateModified;

    // Getter para client_backup_log_id
    public function getClientBackupLogId() {
        return $this->clientBackupLogId;
    }

    // Setter para client_backup_log_id
    public function setClientBackupLogId($clientBackupLogId) {

        $this->clientBackupLogId = $clientBackupLogId;

    }

    // Getter para client_id
    public function getClientId() {
        return $this->clientId;
    }

    // Setter para client_id
    public function setClientId($clientId) {
        // Verifica se a variável está preenchida antes de atribuir o valor
        if (!empty($clientId)) {
            $this->clientId = $clientId;
        } else {

            /** Adição de elemento */
            array_push($this->errors, 'O campo client_id não pode ser vazio.');

        }
    }

    // Getter para path
    public function getPath() {
        return $this->path;
    }

    // Setter para path
    public function setPath($path) {
        // Verifica se a variável está preenchida antes de atribuir o valor
        if (!empty($path)) {
            $this->path = $path;
        } else {
            /** Adição de elemento */
            array_push($this->errors, 'O campo client_id não pode ser vazio.');
        }
    }

    // Getter para name
    public function getName() {
        return $this->name;
    }

    // Setter para name
    public function setName($name) {
        // Verifica se a variável está preenchida antes de atribuir o valor
        if (!empty($name)) {
            $this->name = $name;
        } else {
            /** Adição de elemento */
            array_push($this->errors, 'O campo client_id não pode ser vazio.');
        }
    }

    // Getter para size
    public function getSize() {
        return $this->size;
    }

    // Setter para size
    public function setSize($size) {
        // Verifica se a variável está preenchida antes de atribuir o valor
        if (!empty($size)) {
            $this->size = $size;
        } else {
            /** Adição de elemento */
            array_push($this->errors, 'O campo client_id não pode ser vazio.');
        }
    }

    // Getter para date_register
    public function getDateRegister() {
        return $this->dateRegister;
    }

    // Setter para date_register
    public function setDateRegister($dateRegister) {
        // Verifica se a variável está preenchida antes de atribuir o valor
        if (!empty($dateRegister)) {
            $this->dateRegister = $dateRegister;
        } else {
            /** Adição de elemento */
            array_push($this->errors, 'O campo client_id não pode ser vazio.');
        }
    }

    // Getter para date_modified
    public function getDateModified() {
        return $this->dateModified;
    }

    // Setter para date_modified
    public function setDateModified($dateModified) {
        // Verifica se a variável está preenchida antes de atribuir o valor
        if (!empty($dateModified)) {
            $this->dateModified = $dateModified;
        } else {
            /** Adição de elemento */
            array_push($this->errors, 'O campo client_id não pode ser vazio.');
        }
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

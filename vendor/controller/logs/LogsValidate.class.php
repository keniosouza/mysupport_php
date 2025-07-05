<?php

/** Defino o local da classes */
namespace vendor\controller\logs;

/** Importação de classes */
use vendor\controller\main\Main;

class LogsValidate
{

    /** Parâmetros da classes */
    private $Main = null;
    private $errors = array();
    private $info = null;

    private $logId;
    private $logTypeId;
    private $companyId;
    private $userId;
    private $table;
    private $registerId;
    private $hash;
    private $data;
    private $dateRegister;

    /** Método construtor */
    public function __construct()
    {

        /** Instânciamento de classes */
        $this->Main = new Main();

    }

    public function setLogId(int $logId): void
    {

        /** Tratamento da informação */
        $this->logId = isset($logId) ? $this->Main->antiInjection($logId) : 0;

    }

    public function getLogId(): int
    {

        /** Retorno da informação */
        return (int)$this->logId;

    }

    public function setLogTypeId(int $logTypeId): void
    {

        /** Tratamento da informação */
        $this->logTypeId = isset($logTypeId) ? $this->Main->antiInjection($logTypeId) : 0;

        /** Verifica se a informação foi informada */
        if ($this->logTypeId === 0) {

            /** Adição de elemento */
            array_push($this->errors, 'O campo "Tipo de Log", deve ser informado');

        }

    }

    public function getLogTypeId(): int
    {

        /** Retorno da informação */
        return (int)$this->logTypeId;

    }

    public function setCompanyId(int $companyId): void
    {

        /** Tratamento da informação */
        $this->companyId = isset($companyId) ? $this->Main->antiInjection($companyId) : 0;

        /** Verifica se a informação foi informada */
        if ($this->companyId === 0) {

            /** Adição de elemento */
            array_push($this->errors, 'O campo "Empresa", deve ser informado');

        }

    }

    public function getCompanyId(): int
    {

        /** Retorno da informação */
        return (int)$this->companyId;

    }

    public function setUserId(int $userId): void
    {

        /** Tratamento da informação */
        $this->userId = isset($userId) ? $this->Main->antiInjection($userId) : 0;

        /** Verifica se a informação foi informada */
        if ($this->userId === 0) {

            /** Adição de elemento */
            array_push($this->errors, 'O campo "Usuário", deve ser informado');

        }

    }

    public function getUserId(): int
    {

        /** Retorno da informação */
        return (int)$this->userId;

    }

    public function setTable(string $table): void
    {

        /** Tratamento da informação */
        $this->table = isset($table) ? $this->Main->antiInjection($table) : null;

        /** Verifica se a informação foi informada */
        if (empty($this->table)) {

            /** Adição de elemento */
            array_push($this->errors, 'O campo "Tabela", deve ser informado');

        }

    }

    public function getTable(): string
    {

        /** Retorno da informação */
        return (string)$this->table;

    }

    public function setRegisterId(? int $registerId): void
    {

        /** Tratamento da informação */
        $this->registerId = isset($registerId) ? $this->Main->antiInjection($registerId) : 0;

    }

    public function getRegisterId(): ? int
    {

        /** Retorno da informação */
        return (int)$this->registerId;

    }

    public function setHash(? string $hash): void
    {

        /** Tratamento da informação */
        $this->hash = isset($hash) ? $this->Main->antiInjection($hash) : 0;

    }

    public function getHash(): ? string
    {

        /** Retorno da informação */
        return (string)$this->hash;

    }

    public function setData(string $data): void
    {

        /** Tratamento da informação */
        $this->data = isset($data) ? $this->Main->antiInjection($data, 'S') : null;

        /** Verifica se a informação foi informada */
        if (empty($this->data)) {

            /** Adição de elemento */
            array_push($this->errors, 'O campo "ID do Registro", deve ser informado');

        }

    }

    public function getData(): string
    {

        /** Retorno da informação */
        return (string)$this->data;

    }

    public function setDateRegister(string $dateRegister): void
    {

        /** Tratamento da informação */
        $this->dateRegister = isset($dateRegister) ? $this->Main->antiInjection($dateRegister) : null;

        /** Verifica se a informação foi informada */
        if (empty($this->dateRegister)) {

            /** Adição de elemento */
            array_push($this->errors, 'O campo "Data de Registro", deve ser informado');

        }

    }

    public function getDateRegister(): string
    {

        /** Retorno da informação */
        return (string)$this->dateRegister;

    }

    public function getErrors(): ?string
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
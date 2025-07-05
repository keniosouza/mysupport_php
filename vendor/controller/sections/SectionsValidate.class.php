<?php

/** Defino o local onde esta a classe */
namespace vendor\controller\sections;

/** Importação de classes */
use vendor\controller\main\Main;

class SectionsValidate
{
    /** Declaro as variavéis da classe */
    private $Main = null;
    private $errors = array();
    private $info = null;

    private $sectionId = null;
    private $registerId = null;
    private $table = null;
    private $name = null;
    private $position = null;
    private $preferences = null;

    /** Construtor da classe */
    function __construct()
    {

        /** Instânciamento da classe de validação */
        $this->Main = new Main();

    }

    /** Método trata campo file_id */
    public function setSectionId(int $sectionId): void
    {

        /** Trata a entrada da informação  */
        $this->sectionId = isset($sectionId) ? $this->Main->antiInjection($sectionId) : null;

        /** Verifica se a informação foi informada */
        if ($this->sectionId < 0) {

            /** Adição de elemento */
            array_push($this->errors, 'O campo "sectionId", deve ser informado');

        }

    }

    /** Método trata campo register_id */
    public function setRegisterId(int $registerId): void
    {

        /** Trata a entrada da informação  */
        $this->registerId = isset($registerId) ? $this->Main->antiInjection($registerId) : null;

        /** Verifica se a informação foi informada */
        if ($this->registerId <= 0) {

            /** Adição de elemento */
            array_push($this->errors, 'O campo "register_id", deve ser informado');

        }

    }

    /** Método trata campo table */
    public function setTable(string $table): void
    {

        /** Trata a entrada da informação  */
        $this->table = isset($table) ? $this->Main->antiInjection($table) : null;

        /** Verifica se a informação foi informada */
        if (empty($this->table)) {

            /** Adição de elemento */
            array_push($this->errors, 'O campo "table", deve ser informado');

        }

    }

    /**
     * Método setName
     * Define o valor para o campo 'name' após tratamento e validação.
     *
     * @param string $name - Valor a ser atribuído ao campo 'name'.
     *
     * @return void
     */
    public function setName(string $name): void
    {

        // Trata a entrada da informação usando o método antiInjection de $this->Main
        $this->name = isset($name) ? $this->Main->antiInjection($name) : null;

        // Verifica se a informação foi informada
        if (empty($this->name)) {

            // Adição de elemento ao array de erros se o campo 'name' não foi informado
            array_push($this->errors, 'O campo "name" deve ser informado');

        }

    }

    /** Método trata campo path */
    public function setPosition(string $position): void
    {

        /** Trata a entrada da informação  */
        $this->position = isset($position) ? $this->Main->antiInjection($position) : null;

    }

    /** Método trata campo history */
    public function setPreferences(string $preferences): void
    {

        /** Trata a entrada da informação  */
        $this->preferences = isset($preferences) ? $this->Main->antiInjection($preferences, 'S') : null;

    }

    /** Método retorna campo file_id */
    public function getSectionId(): ?int
    {

        /** Retorno da informação */
        return (int)$this->sectionId;

    }

    /** Método retorna campo register_id */
    public function getRegisterId(): ?int
    {

        /** Retorno da informação */
        return (int)$this->registerId;

    }

    /** Método retorna campo table */
    public function getTable(): ?string
    {

        /** Retorno da informação */
        return (string)$this->table;

    }

    /** Método retorna campo name */
    public function getName(): ?string
    {

        /** Retorno da informação */
        return (string)$this->name;

    }

    /** Método retorna campo path */
    public function getPosition(): ?string
    {

        /** Retorno da informação */
        return (string)$this->position;

    }

    /** Método retorna campo history */
    public function getPreferences(): ?string
    {

        /** Retorno da informação */
        return (string)$this->preferences;

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

    function __destruct()
    {
    }

}

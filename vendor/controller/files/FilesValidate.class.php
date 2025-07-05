<?php
/**
 * Classe FilesValidate.class.php
 * @filesource
 * @autor        Kenio de Souza
 * @copyright    Copyright 2022 - Souza Consultoria Tecnológica
 * @package        vendor
 * @subpackage    controller/files
 * @version        1.0
 * @date            25/04/2022
 */


/** Defino o local onde esta a classe */

namespace vendor\controller\files;

/** Importação de classes */
use vendor\controller\main\Main;

class FilesValidate
{
    /** Declaro as variavéis da classe */
    private $Main = null;
    private $errors = array();
    private $info = null;
    private $fileId = null;
    private $registerId = null;
    private $table = null;
    private $name = null;
    private $path = null;
    private $history = null;
    private $base64 = null;
    private $extension = null;
    private $crop = null;

    /** Construtor da classe */
    function __construct()
    {

        /** Instânciamento da classe de validação */
        $this->Main = new Main();

    }

    /** Método trata campo file_id */
    public function setFileId(int $fileId): void
    {

        /** Trata a entrada da informação  */
        $this->fileId = isset($fileId) ? $this->Main->antiInjection($fileId) : null;

        /** Verifica se a informação foi informada */
        if ($this->fileId < 0) {

            /** Adição de elemento */
            array_push($this->errors, 'O campo "file_id", deve ser informado');

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

        } else {

            // Formatação do nome removendo caracteres especiais usando o método RemoveSpecialChars de $this->Main
            $this->name = $this->Main->RemoveSpecialChars($this->name);

        }

    }

    /** Método trata campo path */
    public function setPath(string $path): void
    {

        /** Trata a entrada da informação  */
        $this->path = isset($path) ? $this->Main->antiInjection($path) : null;

        /** Verifica se a informação foi informada */
        if (empty($this->path)) {

            /** Adição de elemento */
            array_push($this->errors, 'O campo "path", deve ser informado');

        }

    }

    /** Método trata campo history */
    public function setHistory(string $history): void
    {

        /** Trata a entrada da informação  */
        $this->history = isset($history) ? $this->Main->antiInjection($history, 'S') : null;

        /** Verifica se a informação foi informada */
        if (empty($this->history)) {

            /** Adição de elemento */
            array_push($this->errors, 'O campo "history", deve ser informado');

        }

    }

    /** Método trata campo history dinâmico */
    public function setGenerateHistory(): void
    {

        /** Defino o histórico do registro de mensagem */
        $history[0]['title'] = 'Cadastro';
        $history[0]['description'] = 'Novo arquivo vinculado';
        $history[0]['date'] = date('d-m-Y');
        $history[0]['time'] = date('H:i:s');
        $history[0]['class'] = 'rounded-pill text-bg-warning';
        $history[0]['user'] = $_SESSION['USERSNAMEFIRST'];

        /** Defino o histórico */
        $this->history = json_encode($history, JSON_PRETTY_PRINT);

    }

    /** Método trata campo base64 */
    public function setBase64(string $base64): void
    {

        /** Trata a entrada da informação  */
        $this->base64 = isset($base64) ? $this->Main->antiInjection($base64, 'S') : null;

        /** Verifica se a informação foi informada */
        if (empty($this->base64)) {

            /** Adição de elemento */
            array_push($this->errors, 'O campo "base64", deve ser informado');

        }

    }

    /** Método trata campo base64 */
    public function setExtension(string $extension): void
    {

        /** Trata a entrada da informação  */
        $this->extension = isset($extension) ? $this->Main->antiInjection($extension) : null;

        /** Verifica se a informação foi informada */
        if (empty($this->extension)) {

            /** Adição de elemento */
            array_push($this->errors, 'O campo "Extensão", deve ser informado');

        }

    }

    /** Método trata campo base64 */
    public function setCrop(object $crop): void
    {

        /** Trata a entrada da informação  */
        $this->crop = $crop;

    }

    /** Método retorna campo file_id */
    public function getFileId(): ?int
    {

        /** Retorno da informação */
        return (int)$this->fileId;

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
    public function getPath(): ?string
    {

        /** Retorno da informação */
        return (string)$this->path;

    }

    /** Método retorna campo history */
    public function getHistory(): ?string
    {

        /** Retorno da informação */
        return (string)$this->history;

    }

    /** Método retorna campo history */
    public function getGenerateHistory(): ?string
    {

        /** Retorno da informação */
        return (string)$this->history;

    }

    /** Método retorna campo base53 */
    public function getBase64(): ?string
    {

        /** Retorno da informação */
        return (string)$this->base64;

    }

    /** Método retorna campo base53 */
    public function getExtension(): ?string
    {

        /** Retorno da informação */
        return (string)$this->extension;

    }

    /** Método retorna campo base53 */
    public function getCrop(): ?object
    {

        /** Retorno da informação */
        return (object)$this->crop;

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

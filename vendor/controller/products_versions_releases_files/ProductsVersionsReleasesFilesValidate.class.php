<?php
/**
 * Classe ProductsVersionsReleasesFilesValidate.class.php
 * @filesource
 * @autor        Kenio de Souza
 * @copyright    Copyright 2022 - Souza Consultoria Tecnológica
 * @package        vendor
 * @subpackage    controller/products_versions_releases_files
 * @version        1.0
 * @date            19/04/2022
 */


/** Defino o local onde esta a classe */

namespace vendor\controller\products_versions_releases_files;

/** Importação de classes */
use vendor\controller\main\Main;

class ProductsVersionsReleasesFilesValidate
{
    /** Declaro as variavéis da classe */
    private $Main = null;
    private $errors = array();
    private $info = null;
    private $base64 = null;

    private $productVersionReleaseFileId = null;
    private $productVersionReleaseId = null;
    private $name = null;
    private $path = null;
    private $history = null;

    /** Construtor da classe */
    function __construct()
    {

        /** Instânciamento da classe de validação */
        $this->Main = new Main();

    }

    /** Método trata campo product_version_release_file_id */
    public function setBase64(string $base64): void
    {

        /** Trata a entrada da informação  */
        $this->base64 = isset($base64) ? $this->Main->antiInjection($base64, 'S') : null;

        /** Verifica se a informação foi informada */
        if (empty($this->base64)) {

            /** Adição de elemento */
            array_push($this->errors, 'O campo "bas64", deve ser informado');

        }

    }

    /** Método trata campo product_version_release_file_id */
    public function setProductVersionReleaseFileId(int $productVersionReleaseFileId): void
    {

        /** Trata a entrada da informação  */
        $this->productVersionReleaseFileId = isset($productVersionReleaseFileId) ? $this->Main->antiInjection($productVersionReleaseFileId) : null;

        /** Verifica se a informação foi informada */
        if (empty($this->productVersionReleaseFileId)) {

            /** Adição de elemento */
            array_push($this->errors, 'O campo "product_version_release_file_id", deve ser informado');

        }

    }

    /** Método trata campo product_version_release_id */
    public function setProductVersionReleaseId(int $productVersionReleaseId): void
    {

        /** Trata a entrada da informação  */
        $this->productVersionReleaseId = isset($productVersionReleaseId) ? $this->Main->antiInjection($productVersionReleaseId) : null;

        /** Verifica se a informação foi informada */
        if (empty($this->productVersionReleaseId)) {

            /** Adição de elemento */
            array_push($this->errors, 'O campo "product_version_release_id", deve ser informado');

        }

    }

    /** Método trata campo name */
    public function setName(string $name): void
    {

        /** Trata a entrada da informação  */
        $this->name = isset($name) ? $this->Main->antiInjection($name) : null;

        /** Verifica se a informação foi informada */
        if (empty($this->name)) {

            /** Adição de elemento */
            array_push($this->errors, 'O campo "name", deve ser informado');

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

    /** Método retorna campo product_version_release_file_id */
    public function getBase64(): ?string
    {

        /** Retorno da informação */
        return (string)$this->base64;

    }

    /** Método retorna campo product_version_release_file_id */
    public function getProductVersionReleaseFileId(): ?int
    {

        /** Retorno da informação */
        return (int)$this->productVersionReleaseFileId;

    }

    /** Método retorna campo product_version_release_id */
    public function getProductVersionReleaseId(): ?int
    {

        /** Retorno da informação */
        return (int)$this->productVersionReleaseId;

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

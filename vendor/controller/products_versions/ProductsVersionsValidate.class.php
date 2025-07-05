<?php
/**
 * Classe ProductsVersionsValidate.class.php
 * @filesource
 * @autor        Kenio de Souza
 * @copyright    Copyright 2022 - Souza Consultoria Tecnológica
 * @package        vendor
 * @subpackage    controller/products_versions
 * @version        1.0
 * @date            18/04/2022
 */


/** Defino o local onde esta a classe */

namespace vendor\controller\products_versions;

/** Importação de classes */
use vendor\controller\main\Main;

class ProductsVersionsValidate
{
    /** Declaro as variavéis da classe */
    private $Main = null;
    private $errors = array();
    private $info = null;
    private $productVersionId = null;
    private $productId = null;
    private $description = null;
    private $number = null;
    private $history = null;

    /** Construtor da classe */
    function __construct()
    {

        /** Instânciamento da classe de validação */
        $this->Main = new Main();

    }

    /** Método trata campo product_version_id */
    public function setProductVersionId(int $productVersionId): void
    {

        /** Trata a entrada da informação  */
        $this->productVersionId = isset($productVersionId) ? $this->Main->antiInjection($productVersionId) : null;

        /** Verifica se a informação foi informada */
        if ($this->productVersionId < 0) {

            /** Adição de elemento */
            array_push($this->errors, 'O campo "product_version_id", deve ser informado');

        }

    }

    /** Método trata campo product_id */
    public function setProductId(int $productId): void
    {

        /** Trata a entrada da informação  */
        $this->productId = isset($productId) ? $this->Main->antiInjection($productId) : null;

        /** Verifica se a informação foi informada */
        if (empty($this->productId)) {

            /** Adição de elemento */
            array_push($this->errors, 'O campo "product_id", deve ser informado');

        }

    }

    /** Método trata campo descritpion */
    public function setDescription(string $description): void
    {

        /** Trata a entrada da informação  */
        $this->description = isset($description) ? $this->Main->antiInjection($description, 'S') : null;

        /** Verifica se a informação foi informada */
        if (empty($this->description)) {

            /** Adição de elemento */
            array_push($this->errors, 'O campo "descritpion", deve ser informado');

        }

    }

    /** Método trata campo number */
    public function setNumber(string $number): void
    {

        /** Trata a entrada da informação  */
        $this->number = isset($number) ? $this->Main->antiInjection($number) : null;

        /** Verifica se a informação foi informada */
        if (empty($this->number)) {

            /** Adição de elemento */
            array_push($this->errors, 'O campo "number", deve ser informado');

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

    /** Método retorna campo product_version_id */
    public function getProductVersionId(): ?int
    {

        /** Retorno da informação */
        return (int)$this->productVersionId;

    }

    /** Método retorna campo product_id */
    public function getProductId(): ?int
    {

        /** Retorno da informação */
        return (int)$this->productId;

    }

    /** Método retorna campo descritpion */
    public function getDescription(): ?string
    {

        /** Retorno da informação */
        return (string)$this->description;

    }

    /** Método retorna campo number */
    public function getNumber(): ?string
    {

        /** Retorno da informação */
        return (string)$this->number;

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

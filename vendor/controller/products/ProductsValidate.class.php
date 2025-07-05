<?php
/**
 * Classe ProductsValidate.class.php
 * @filesource
 * @autor        Kenio de Souza
 * @copyright    Copyright 2022 - Souza Consultoria Tecnológica
 * @package        vendor
 * @subpackage    controller/products
 * @version        1.0
 * @date            18/04/2022
 */

/** Defino o local onde esta a classe */

namespace vendor\controller\products;

/** Importação de classes */
use vendor\controller\main\Main;

class ProductsValidate
{
    /** Declaro as variavéis da classe */
    private $Main = null;
    private $errors = array();
    private $info = null;
    private $productsId = null;
    private $companyId = null;
    private $productsTypeId = null;
    private $name = null;
    private $description = null;

    /** Construtor da classe */
    function __construct()
    {

        /** Instânciamento da classe de validação */
        $this->Main = new Main();

    }

    /** Método trata campo products_id */
    public function setProductsId(int $productsId): void
    {

        /** Trata a entrada da informação  */
        $this->productsId = isset($productsId) ? $this->Main->antiInjection($productsId) : null;

        /** Verifica se a informação foi informada */
        if ($this->productsId < 0) {

            /** Adição de elemento */
            array_push($this->errors, 'O campo "products_id", deve ser informado');

        }

    }

    /** Método trata campo company_id */
    public function setCompanyId(int $companyId): void
    {

        /** Trata a entrada da informação  */
        $this->companyId = isset($companyId) ? $this->Main->antiInjection($companyId) : null;

        /** Verifica se a informação foi informada */
        if (empty($this->companyId)) {

            /** Adição de elemento */
            array_push($this->errors, 'O campo "company_id", deve ser informado');

        }

    }

    /** Método trata campo products_type_id */
    public function setProductsTypeId(int $productsTypeId): void
    {

        /** Trata a entrada da informação  */
        $this->productsTypeId = isset($productsTypeId) ? $this->Main->antiInjection($productsTypeId) : null;

        /** Verifica se a informação foi informada */
        if (empty($this->productsTypeId)) {

            /** Adição de elemento */
            array_push($this->errors, 'O campo "products_type_id", deve ser informado');

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

    /** Método trata campo description */
    public function setDescription(string $description): void
    {

        /** Trata a entrada da informação  */
        $this->description = isset($description) ? $this->Main->antiInjection($description, 'S') : null;

        /** Verifica se a informação foi informada */
        if (empty($this->description)) {

            /** Adição de elemento */
            array_push($this->errors, 'O campo "description", deve ser informado');

        }

    }

    /** Método retorna campo products_id */
    public function getProductsId(): ? int
    {

        /** Retorno da informação */
        return (int)$this->productsId;

    }

    /** Método retorna campo company_id */
    public function getCompanyId(): ? int
    {

        /** Retorno da informação */
        return (int)$this->companyId;

    }

    /** Método retorna campo products_type_id */
    public function getProductsTypeId(): ? int
    {

        /** Retorno da informação */
        return (int)$this->productsTypeId;

    }

    /** Método retorna campo name */
    public function getName(): ? string
    {

        /** Retorno da informação */
        return (string)$this->name;

    }

    /** Método retorna campo description */
    public function getDescription(): ? string
    {

        /** Retorno da informação */
        return (string)$this->description;

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

    function __destruct()
    {
    }

}

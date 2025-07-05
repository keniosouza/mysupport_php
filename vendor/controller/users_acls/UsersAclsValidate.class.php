<?php
/**
 * Classe UsersAclsValidate.class.php
 * @filesource
 * @autor        Kenio de Souza
 * @copyright    Copyright 2022 - Souza Consultoria Tecnológica
 * @package        vendor
 * @subpackage    controller/users_acls
 * @version        1.0
 * @date            10/04/2022
 */


/** Defino o local onde esta a classe */

namespace vendor\controller\users_acls;

/** Importação de classes */
use vendor\controller\main\Main;

class UsersAclsValidate
{
    /** Declaro as variavéis da classe */
    private $Main = null;
    private $errors = array();
    private $info = null;
    private $usersAclsId = null;
    private $modulesAclsId = null;
    private $usersId = null;

    /** Construtor da classe */
    function __construct()
    {

        /** Instânciamento da classe de validação */
        $this->Main = new Main();

    }

    /** Método trata campo users_acls_id */
    public function setUsersAclsId(int $usersAclsId): void
    {

        /** Trata a entrada da informação  */
        $this->usersAclsId = isset($usersAclsId) ? $this->Main->antiInjection($usersAclsId) : null;

        /** Verifica se a informação foi informada */
        if ($this->usersAclsId < 0) {

            /** Adição de elemento */
            array_push($this->errors, 'O campo "users_acls_id", deve ser informado');

        }

    }

    /** Método trata campo modules_acls_id */
    public function setModulesAclsId(int $modulesAclsId): void
    {

        /** Trata a entrada da informação  */
        $this->modulesAclsId = isset($modulesAclsId) ? $this->Main->antiInjection($modulesAclsId) : null;

        /** Verifica se a informação foi informada */
        if ($this->modulesAclsId <= 0) {

            /** Adição de elemento */
            array_push($this->errors, 'O campo "modules_acls_id", deve ser informado');

        }

    }

    /** Método trata campo users_id */
    public function setUsersId(int $usersId): void
    {

        /** Trata a entrada da informação  */
        $this->usersId = isset($usersId) ? $this->Main->antiInjection($usersId) : null;

        /** Verifica se a informação foi informada */
        if ($this->usersId <= 0) {

            /** Adição de elemento */
            array_push($this->errors, 'O campo "users_id", deve ser informado');

        }

    }

    /** Método retorna campo users_acls_id */
    public function getUsersAclsId(): ?int
    {

        /** Retorno da informação */
        return (int)$this->usersAclsId;

    }

    /** Método retorna campo modules_acls_id */
    public function getModulesAclsId(): ?int
    {

        /** Retorno da informação */
        return (int)$this->modulesAclsId;

    }

    /** Método retorna campo users_id */
    public function getUsersId(): ?int
    {

        /** Retorno da informação */
        return (int)$this->usersId;

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

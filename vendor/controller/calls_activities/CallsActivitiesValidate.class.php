<?php
/**
 * Classe CallsActivitiesValidate.class.php
 * @filesource
 * @autor        Kenio de Souza
 * @copyright    Copyright 2022 - Souza Consultoria Tecnológica
 * @package        vendor
 * @subpackage    controller/calls_activities
 * @version        1.0
 * @date            03/04/2022
 */


/** Defino o local onde esta a classe */
namespace vendor\controller\calls_activities;

/** Importação de classes */
use vendor\controller\main\Main;

class CallsActivitiesValidate
{
    /** Declaro as variavéis da classe */
    private $Main = null;
    private $errors = array();
    private $info = null;
    private $callActivityId = null;
    private $callId = null;
    private $callActivityTypeId = null;
    private $callActivityPriorityId = null;
    private $callActivityLevelId = null;
    private $callActivityProgressId = null;
    private $sectionId = null;
    private $companyId = null;
    private $name = null;
    private $description = null;
    private $keywords = null;
    private $dateExpected = null;
    private $dateStart = null;
    private $dateClose = null;
    private $history = null;

    /** Construtor da classe */
    function __construct()
    {

        /** Instânciamento da classe de validação */
        $this->Main = new Main();

    }

    /** Método trata campo call_activity_id */
    public function setCallActivityId(int $callActivityId): void
    {

        /** Trata a entrada da informação  */
        $this->callActivityId = isset($callActivityId) ? $this->Main->antiInjection($callActivityId) : null;

        /** Verifica se a informação foi informada */
        if ($this->callActivityId < 0) {

            /** Adição de elemento */
            array_push($this->errors, 'O campo "call_activity_id", deve ser informado');

        }

    }

    /** Método trata campo call_id */
    public function setCallId(int $callId): void
    {

        /** Trata a entrada da informação  */
        $this->callId = isset($callId) ? $this->Main->antiInjection($callId) : null;

        /** Verifica se a informação foi informada */
        if ($this->callId <= 0) {

            /** Adição de elemento */
            array_push($this->errors, 'O campo "call_id", deve ser informado');

        }

    }

    public function setCallActivityTypeId(int $callActivityTypeId): void
    {

        /** Trata a entrada da informação  */
        $this->callActivityTypeId = isset($callActivityTypeId) ? $this->Main->antiInjection($callActivityTypeId) : null;

    }

    public function setCallActivityPriorityId(int $callActivityPriorityId): void
    {

        /** Trata a entrada da informação  */
        $this->callActivityPriorityId = isset($callActivityPriorityId) ? $this->Main->antiInjection($callActivityPriorityId) : null;

    }

    public function setCallActivityLevelId(int $callActivityLevelId): void
    {

        /** Trata a entrada da informação  */
        $this->callActivityLevelId = isset($callActivityLevelId) ? $this->Main->antiInjection($callActivityLevelId) : null;

    }

    /** Método trata campo company_id */
    public function setSectionId(int $sectionId): void
    {

        /** Trata a entrada da informação  */
        $this->sectionId = isset($sectionId) ? $this->Main->antiInjection($sectionId) : null;

        /** Verifica se a informação foi informada */
        if ($this->sectionId <= 0) {

            /** Adição de elemento */
            array_push($this->errors, 'O campo "seção", deve ser informado');

        }

    }

    /** Método trata campo company_id */
    public function setCompanyId(int $companyId): void
    {

        /** Trata a entrada da informação  */
        $this->companyId = isset($companyId) ? $this->Main->antiInjection($companyId) : null;

        /** Verifica se a informação foi informada */
        if ($this->companyId <= 0) {

            /** Adição de elemento */
            array_push($this->errors, 'O campo "company_id", deve ser informado');

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

    /** Método trata campo description */
    public function setKeywords(string $keywords): void
    {

        /** Trata a entrada da informação  */
        $this->keywords = isset($keywords) ? $this->Main->antiInjection($keywords) : null;

    }

    /** Método trata campo date_expected */
    public function setDateExpected(string $dateExpected): void
    {

        /** Trata a entrada da informação  */
        $this->dateExpected = isset($dateExpected) ? $this->Main->antiInjection($dateExpected) : null;

    }

    /** Método trata campo date_close */
    public function setDateClose(string $dateClose): void
    {

        /** Trata a entrada da informação  */
        $this->dateClose = isset($dateClose) ? $this->Main->antiInjection($dateClose) : null;

        /** Verifica se a informação foi informada */
        if (empty($this->dateClose)) {

            /** Adição de elemento */
            array_push($this->errors, 'O campo "date_close", deve ser informado');

        }

    }

    /** Método retorna campo call_activity_id */
    public function getCallActivityId(): ?int
    {

        /** Retorno da informação */
        return (int)$this->callActivityId;

    }

    /** Método retorna campo call_id */
    public function getCallId(): ?int
    {

        /** Retorno da informação */
        return (int)$this->callId;

    }

    /** Método retorna campo call_activity_id */
    public function getCallActivityTypeId(): ?int
    {

        /** Retorno da informação */
        return (int)$this->callActivityTypeId;

    }

    /** Método retorna campo call_activity_id */
    public function getCallActivityPriorityId(): ?int
    {

        /** Retorno da informação */
        return (int)$this->callActivityPriorityId;

    }

    /** Método retorna campo call_activity_id */
    public function getCallActivityLevelId(): ?int
    {

        /** Retorno da informação */
        return (int)$this->callActivityLevelId;

    }

    /** Método retorna campo company_id */
    public function getSectionId(): ?int
    {

        /** Retorno da informação */
        return (int)$this->sectionId;

    }

    /** Método retorna campo company_id */
    public function getCompanyId(): ?int
    {

        /** Retorno da informação */
        return (int)$this->companyId;

    }

    /** Método retorna campo name */
    public function getName(): ?string
    {

        /** Retorno da informação */
        return (string)$this->name;

    }

    /** Método retorna campo description */
    public function getDescription(): ?string
    {

        /** Retorno da informação */
        return (string)$this->description;

    }

    /** Método retorna campo description */
    public function getKeywords(): ?string
    {

        /** Retorno da informação */
        return (string)$this->keywords;

    }

    /** Método retorna campo date_expected */
    public function getDateExpected(): ? string
    {

        /** Retorno da informação */
        return (string)$this->dateExpected;

    }
    /** Método retorna campo date_close */
    public function getDateClose(): ?string
    {

        /** Retorno da informação */
        return (string)$this->dateClose;

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

}

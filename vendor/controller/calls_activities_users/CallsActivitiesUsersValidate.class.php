<?php
/**
 * Classe CallsActivitiesUsersValidate.class.php
 * @filesource
 * @autor        Kenio de Souza
 * @copyright    Copyright 2022 - Souza Consultoria Tecnológica
 * @package        vendor
 * @subpackage    controller/calls_activities_users
 * @version        1.0
 * @date            03/04/2022
 */

/** Defino o local onde esta a classe */
namespace vendor\controller\calls_activities_users;

/** Importação de classes */
use vendor\controller\main\Main;

class CallsActivitiesUsersValidate
{
    /** Declaro as variavéis da classe */
    private $Main = null;
    private $errors = array();
    private $info = null;

    private $callActivityUserId = null;
    private $callActivityId = null;
    private $callId = null;
    private $callActivityUsersProgressId = null;
    private $userId = null;
    private $companyId = null;
    private $dateExpected = null;
    private $dateStart = null;
    private $dateClose = null;
    private $description = null;
    private $history = null;

    /** Construtor da classe */
    function __construct()
    {

        /** Instânciamento da classe de validação */
        $this->Main = new Main();

    }

    /** Método trata campo call_activity_user_id */
    public function setCallActivityUserId(int $callActivityUserId): void
    {

        /** Trata a entrada da informação  */
        $this->callActivityUserId = isset($callActivityUserId) ? $this->Main->antiInjection($callActivityUserId) : null;

        /** Verifica se a informação foi informada */
        if ($this->callActivityUserId < 0) {

            /** Adição de elemento */
            array_push($this->errors, 'O campo "call_activity_user_id", deve ser informado');

        }

    }

    /** Método trata campo call_activity_id */
    public function setCallActivityId(int $callActivityId): void
    {

        /** Trata a entrada da informação  */
        $this->callActivityId = isset($callActivityId) ? $this->Main->antiInjection($callActivityId) : null;

        /** Verifica se a informação foi informada */
        if ($this->callActivityId <= 0) {

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

    /** Método trata campo call_id */
    public function setCallActivityUsersProgressId(int $callActivityUsersProgressId): void
    {

        /** Trata a entrada da informação  */
        $this->callActivityUsersProgressId = isset($callActivityUsersProgressId) ? $this->Main->antiInjection($callActivityUsersProgressId) : null;

        /** Verifica se a informação foi informada */
        if ($this->callActivityUsersProgressId <= 0) {

            /** Adição de elemento */
            array_push($this->errors, 'O campo "Andamento", deve ser informado');

        }

    }

    /** Método trata campo user_id */
    public function setUserId(int $userId): void
    {

        /** Trata a entrada da informação  */
        $this->userId = isset($userId) ? $this->Main->antiInjection($userId) : null;

        /** Verifica se a informação foi informada */
        if ($this->userId <= 0) {

            /** Adição de elemento */
            array_push($this->errors, 'O campo "user_id", deve ser informado');

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

    /** Método trata campo date_expected */
    public function setDateExpected(? string $dateExpected): void
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

    /** Método trata campo date_close */
    public function setDescription(string $description): void
    {

        /** Trata a entrada da informação  */
        $this->description = isset($description) ? $this->Main->antiInjection($description, 'S') : null;

        /** Verifica se a informação foi informada */
        if (empty($this->description)) {

            /** Adição de elemento */
            array_push($this->errors, 'O campo "Descrição", deve ser informado');

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
    public function setGenerateHistory(string $history): void
    {

        /** Trata a entrada da informação  */
        $this->history = isset($history) ? $this->Main->antiInjection($history, 'S') : null;

        /** Defino o histórico do chamado */
        $history = null;
        $history[0]['title'] = 'Interação';
        $history[0]['description'] = 'Iniciando Participação';
        $history[0]['date'] = date('d-m-Y');
        $history[0]['time'] = date('H:i:s');
        $history[0]['class'] = 'rounded-pill text-bg-warning';
        $history[0]['user'] = $_SESSION['USERSNAMEFIRST'];

        /** Verifico se já existe histórico */
        if (!empty($this->history)) {

            /** Pego o histórico existente */
            $resultHistory = json_decode($this->history, true);

            /** Unifico os históricos */
            $this->history = array_merge($resultHistory, $history);

        }

        /** Defino o histórico */
        $this->history = json_encode($this->history, JSON_PRETTY_PRINT);

    }

    /** Método retorna campo call_activity_user_id */
    public function getCallActivityUserId(): ?int
    {

        /** Retorno da informação */
        return (int)$this->callActivityUserId;

    }

    /** Método retorna campo call_activity_user_id */
    public function getCallActivityUsersProgressId(): ?int
    {

        /** Retorno da informação */
        return (int)$this->callActivityUsersProgressId;

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

    /** Método retorna campo user_id */
    public function getUserId(): ?int
    {

        /** Retorno da informação */
        return (int)$this->userId;

    }

    /** Método retorna campo company_id */
    public function getCompanyId(): ?int
    {

        /** Retorno da informação */
        return (int)$this->companyId;

    }

    /** Método retorna campo date_expected */
    public function getDateExpected(): ?string
    {

        /** Retorno da informação */
        return (string)$this->dateExpected;

    }

    /** Método retorna campo date_start */
    public function getDateStart(): ?string
    {

        /** Retorno da informação */
        return (string)$this->dateStart;

    }

    /** Método retorna campo date_close */
    public function getDateClose(): ?string
    {

        /** Retorno da informação */
        return (string)$this->dateClose;

    }

    /** Método retorna campo date_close */
    public function getDescription(): ?string
    {

        /** Retorno da informação */
        return (string)$this->description;

    }

    /** Método retorna campo history */
    public function getHistory(): ?string
    {

        /** Retorno da informação */
        return (string)$this->history;

    }

    /** Método retorna campo history gerado dinâmico*/
    public function getGenerateHistory(): ?string
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

        /** Instânciamento da classe de validação */
        $this->Main = null;

    }

}

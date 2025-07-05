<?php

/** Defino o local onde esta a classe */
namespace vendor\controller\history;

/** Importação de classes */
use vendor\controller\main\Main;

class HistoryValidate
{
    /** Declaro as variavéis da classe */
    private $Main = null;

    private $history = null;
    private $title = null;
    private $description = null;
    private $class = null;
    private $user = null;
    private $text = null;

    /** Construtor da classe */
    function __construct()
    {

        /** Instânciamento da classe de validação */
        $this->Main = new Main();

    }

    /** Método trata campo history dinâmico */
    public function generate(?string $history, string $title, string $description, string $class, string $user): string
    {

        /** Trata a entrada da informação  */
        $this->history = $history;
        $this->title = isset($title) ? $this->Main->antiInjection($title) : null;
        $this->description = isset($description) ? $this->Main->antiInjection($description) : null;
        $this->class = isset($class) ? $this->Main->antiInjection($class) : null;
        $this->user = isset($user) ? $this->Main->antiInjection($user) : null;

        /** Defino o histórico do registro */
        $date = date('d-m-Y');
        $hour = date('H:i:s');
        $history = array();
        $history[$date][$hour]['title'] = $this->title;
        $history[$date][$hour]['description'] = $this->description;
        $history[$date][$hour]['date'] = date('d-m-Y');
        $history[$date][$hour]['time'] = date('H:i:s');
        $history[$date][$hour]['class'] = $this->class;
        $history[$date][$hour]['user'] = $this->user;

        /** Verifico se já existe histórico */
        if (!empty($this->history)) {

            /** Pego o histórico existente */
            $this->history = json_decode($this->history, true);

            /** Unifico os históricos */
            $this->history = array_merge($this->history, $history);

        }
        else{

            /** Guardo o Histórico */
            $this->history = $history;

        }

        /** Retorno do Histórico em formato JSON */
        return $this->text = json_encode($this->history, JSON_PRETTY_PRINT);

    }

    function __destruct()
    {
    }

}

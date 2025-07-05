<?php

/** Defino o local da classes */
namespace vendor\controller\notifications;

/** Importação de classes */
use vendor\controller\main\Main;

class NotificationsHandling
{

    /** Parâmetros da classes */
    private $Main = null;

    private $data = null;

    /** Método construtor */
    public function __construct()
    {

        /** Instânciamento de classes */
        $this->Main = new Main();

    }

    /**
     * Retorna um JSON padrão para ser armazenado no banco de dados, baseado nos parâmetros fornecidos.
     *
     * Esta função cria um array associativo com as chaves 'title', 'message' e 'class' e, em seguida, converte
     * as chaves para maiúsculas usando array_change_key_case. O resultado é codificado em formato JSON utilizando
     * JSON_PRETTY_PRINT para facilitar a leitura e compreensão.
     *
     * @param string $title    Título a ser incluído no JSON.
     * @param string $message  Mensagem a ser incluída no JSON.
     * @param string $class    Classe a ser incluída no JSON.
     * @param string $icon     Icone a ser incluída no JSON.
     *
     * @return string          Retorna uma string JSON formatada.
     */
    public function setData(string $title, string $message, string $class, string $icon): void
    {

        // Define os dados de respostas
        $this->data = [

            'title' => $title,
            'message' => $message,
            'class' => $class,
            'icon' => $icon,

        ];

    }

    /**
     * Retorna um JSON padrão para ser armazenado no banco de dados, baseado nos parâmetros fornecidos.
     *
     * Esta função cria um array associativo com as chaves 'title', 'message' e 'class' e, em seguida, converte
     * as chaves para maiúsculas usando array_change_key_case. O resultado é codificado em formato JSON utilizando
     * JSON_PRETTY_PRINT para facilitar a leitura e compreensão.
     *
     * @param string $title    Título a ser incluído no JSON.
     * @param string $message  Mensagem a ser incluída no JSON.
     * @param string $class    Classe a ser incluída no JSON.
     * @param string $icon     Icone a ser incluída no JSON.
     *
     * @return string          Retorna uma string JSON formatada.
     */
    public function getData(): string
    {

        // Retorna a informação em JSON
        return json_encode($this->data, JSON_PRETTY_PRINT);

    }

}
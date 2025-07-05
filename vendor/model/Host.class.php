<?php

/**
 * Classe Host
 *
 * Esta classe é responsável por gerenciar as configurações de conexão com o banco de dados,
 * determinando as preferências com base no ambiente de execução da aplicação.
 *
 * @package vendor\model
 */
namespace vendor\model;

use \vendor\controller\main\Main;

class Host
{
    /**
     * @var object $preferences Objeto contendo as preferências de configuração do banco de dados.
     */
    private $preferences;

    /**
     * Método construtor
     *
     * Inicializa uma nova instância da classe Host e determina as preferências de configuração
     * do banco de dados com base no ambiente de execução da aplicação.
     */
    public function __construct()
    {

        // Instancia um objeto Main para carregar as configurações públicas da aplicação
        $Main = new Main();

        // Carrega as configurações públicas da aplicação
        $MainLoadConfigPublicResult = $Main->LoadConfigPublic();

        // Determina as preferências de configuração com base no ambiente de execução da aplicação
        if ($MainLoadConfigPublicResult->app->environment === 'development') {

            // Configurações para ambiente de desenvolvimento
            $this->preferences = $MainLoadConfigPublicResult->app->database->development;

        } else {

            // Configurações para ambiente de produção
            $this->preferences = $MainLoadConfigPublicResult->app->database->production;

        }

    }

    /**
     * Método getDsn
     *
     * Retorna a string DSN (Data Source Name) para conexão com o banco de dados.
     *
     * @return string DSN para conexão com o banco de dados.
     */
    public function getDsn() : string
    {

        return "mysql:host={$this->preferences->host};dbname={$this->preferences->name};port={$this->preferences->port};charset={$this->preferences->charset}";

    }

    /**
     * Método getUser
     *
     * Retorna o usuário de acesso ao banco de dados.
     *
     * @return string Usuário de acesso ao banco de dados.
     */
    public function getUser()
    {

        return $this->preferences->user;

    }

    /**
     * Método getPassword
     *
     * Retorna a senha de acesso ao banco de dados.
     *
     * @return string Senha de acesso ao banco de dados.
     */
    public function getPassword()
    {

        return $this->preferences->password;

    }

}

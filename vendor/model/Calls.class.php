<?php

/** Defino o local da classe */
namespace vendor\model;

class Calls
{

    /** Declaro as vaiavéis da classe */
    private $connection = null;
    private $sql = null;
    private $stmt = null;
    private $callId = null;
    private $companyId = null;
    private $name = null;
    private $description = null;
    private $preferences = null;
    private $dateClose = null;
    private $history = null;

    /** Construtor da classe */
    public function __construct()
    {

        /** Instanciamento da classe */
        $this->connection = new Mysql();

    }

    /**
     * Recupera todos os registros de chamados fechados para uma empresa específica.
     *
     * @param int $companyId O ID da empresa para a qual os chamados serão recuperados.
     *
     * @return array Retorna um array contendo objetos representando os chamados fechados.
     */
    public function AllCalendar(int $companyId)
    {
        /** Define o ID da empresa para a qual os chamados serão recuperados. */
        $this->companyId = $companyId;

        /** Monta a consulta SQL para recuperar os chamados fechados da empresa. */
        $this->sql = 'SELECT
                      c.call_id,
                      c.company_id,
                      c.name,
                      c.description,
                      c.date_close
                    FROM calls c
                    WHERE c.company_id = :companyId
                    AND c.date_close is not null
                    ORDER BY c.call_id DESC';

        /** Prepara a consulta SQL utilizando a conexão estabelecida. */
        $this->stmt = $this->connection->connect()->prepare($this->sql);

        /** Vincula o parâmetro companyId à consulta SQL. */
        $this->stmt->bindParam(':companyId', $this->companyId);

        /** Executa a consulta SQL. */
        $this->stmt->execute();

        /** Retorna o resultado da consulta como um array de objetos. */
        return $this->stmt->fetchAll(\PDO::FETCH_OBJ);

    }

    /**
     * Recupera todos os registros de chamados abertos para uma empresa específica.
     *
     * @param int $companyId O ID da empresa para a qual os chamados abertos serão recuperados.
     *
     * @return array Retorna um array contendo objetos representando os chamados abertos.
     */
    public function All(int $companyId)
    {
        /** Define o ID da empresa para a qual os chamados abertos serão recuperados. */
        $this->companyId = $companyId;

        /** Monta a consulta SQL para recuperar os chamados abertos da empresa. */
        $this->sql = 'SELECT
                      c.call_id,
                      c.company_id,
                      c.name,
                      c.description,
                      c.preferences,
                      c.date_close
                  FROM calls c
                  WHERE c.company_id = :companyId
                    ORDER BY c.call_id DESC';

        /** Prepara a consulta SQL utilizando a conexão estabelecida. */
        $this->stmt = $this->connection->connect()->prepare($this->sql);

        /** Vincula o parâmetro companyId à consulta SQL. */
        $this->stmt->bindParam(':companyId', $this->companyId);

        /** Executa a consulta SQL. */
        $this->stmt->execute();

        /** Retorna o resultado da consulta como um array de objetos. */

        return $this->stmt->fetchAll(\PDO::FETCH_OBJ);
    }

    /**
     * Recupera todos os registros de chamados abertos para uma empresa específica.
     *
     * @param int $companyId O ID da empresa para a qual os chamados abertos serão recuperados.
     *
     * @return array Retorna um array contendo objetos representando os chamados abertos.
     */
    public function AllOpened(int $companyId)
    {
        /** Define o ID da empresa para a qual os chamados abertos serão recuperados. */
        $this->companyId = $companyId;

        /** Monta a consulta SQL para recuperar os chamados abertos da empresa. */
        $this->sql = 'SELECT
                      c.call_id,
                      c.company_id,
                      c.name,
                      c.description,
                      c.preferences,
                      c.date_close
                  FROM calls c
                  WHERE c.company_id = :companyId
                    AND date_close is null
                    ORDER BY c.call_id DESC';

        /** Prepara a consulta SQL utilizando a conexão estabelecida. */
        $this->stmt = $this->connection->connect()->prepare($this->sql);

        /** Vincula o parâmetro companyId à consulta SQL. */
        $this->stmt->bindParam(':companyId', $this->companyId);

        /** Executa a consulta SQL. */
        $this->stmt->execute();

        /** Retorna o resultado da consulta como um array de objetos. */

        return $this->stmt->fetchAll(\PDO::FETCH_OBJ);
    }

    /**
     * Recupera todos os registros de chamados fechados para uma empresa específica.
     *
     * @param int $companyId O ID da empresa para a qual os chamados fechados serão recuperados.
     *
     * @return array Retorna um array contendo objetos representando os chamados fechados.
     */
    public function AllClosed(int $companyId)
    {
        /** Define o ID da empresa para a qual os chamados fechados serão recuperados. */
        $this->companyId = $companyId;

        /** Monta a consulta SQL para recuperar os chamados fechados da empresa. */
        $this->sql = 'SELECT
                      c.call_id,
                      c.company_id,
                      c.name,
                      c.description,
                      c.preferences,
                      c.date_close
                    FROM calls c
                    WHERE c.company_id = :companyId
                        AND date_close is not null
                        ORDER BY c.call_id DESC';

        /** Prepara a consulta SQL utilizando a conexão estabelecida. */
        $this->stmt = $this->connection->connect()->prepare($this->sql);

        /** Vincula o parâmetro companyId à consulta SQL. */
        $this->stmt->bindParam(':companyId', $this->companyId);

        /** Executa a consulta SQL. */
        $this->stmt->execute();

        /** Retorna o resultado da consulta como um array de objetos. */
        return $this->stmt->fetchAll(\PDO::FETCH_OBJ);
    }

    /**
     * Insere um novo registro de chamado no banco de dados ou atualiza um existente se houver um conflito de chave única.
     *
     * @param int $callId O ID do chamado.
     * @param string $companyId O ID da empresa relacionada ao chamado.
     * @param string $name O nome do chamado.
     * @param string $description A descrição do chamado.
     *
     * @return bool Retorna true se a operação de inserção/atualização for bem-sucedida, ou false caso contrário.
     */
    public function Save(int $callId, string $companyId, string $name, string $description): bool
    {
        /** Define os parâmetros para a inserção/atualização do chamado. */
        $this->callId = $callId;
        $this->companyId = $companyId;
        $this->name = $name;
        $this->description = $description;

        /** Consulta SQL para inserção/atualização usando a cláusula ON DUPLICATE KEY UPDATE. */
        $this->sql = 'INSERT INTO calls (call_id,
                                     company_id,
                                     name,
                                     description) VALUES(:call_id,
                                                         :company_id,
                                                         :name,
                                                         :description)
                    ON DUPLICATE KEY UPDATE company_id = :company_id,
                                            name = :name,
                                            description = :description;';

        /** Prepara a consulta SQL para receber os valores. */
        $this->stmt = $this->connection->connect()->prepare($this->sql);

        /** Preenche os parâmetros da consulta SQL. */
        $this->stmt->bindParam('call_id', $this->callId);
        $this->stmt->bindParam('company_id', $this->companyId);
        $this->stmt->bindParam('name', $this->name);
        $this->stmt->bindParam('description', $this->description);

        /** Executa a consulta SQL e retorna o resultado da operação. */
        return $this->stmt->execute();
    }

    /** Insere um novo registro no banco */
    public function SaveClose(int $callId, string $dateClose): bool
    {

        /** Parametros */
        $this->callId = $callId;
        $this->dateClose = $dateClose;

        /** Consulta SQL */
        $this->sql = 'update calls set date_close = :dateClose where call_id = :callId';

        /** Preparo o sql para receber os valores */
        $this->stmt = $this->connection->connect()->prepare($this->sql);

        /** Preencho os parâmetros do SQL */
        $this->stmt->bindParam('callId', $this->callId);
        $this->stmt->bindParam('dateClose', $this->dateClose);

        /** Executo o SQL */
        return $this->stmt->execute();

    }

    /** Insere um novo registro no banco */
    public function SaveOpen(int $callId): bool
    {

        /** Parametros */
        $this->callId = $callId;

        /** Consulta SQL */
        $this->sql = 'update calls set date_close = null where call_id = :callId';

        /** Preparo o sql para receber os valores */
        $this->stmt = $this->connection->connect()->prepare($this->sql);

        /** Preencho os parâmetros do SQL */
        $this->stmt->bindParam('callId', $this->callId);

        /** Executo o SQL */
        return $this->stmt->execute();

    }

    /** Insere um novo registro no banco */
    public function SavePreferences(int $callId, string $preferences): bool
    {

        /** Parametros */
        $this->callId = $callId;
        $this->preferences = $preferences;

        /** Consulta SQL */
        $this->sql = 'update calls set preferences = :preferences where call_id = :callId';

        /** Preparo o sql para receber os valores */
        $this->stmt = $this->connection->connect()->prepare($this->sql);

        /** Preencho os parâmetros do SQL */
        $this->stmt->bindParam('callId', $this->callId);
        $this->stmt->bindParam('preferences', $this->preferences);

        /** Executo o SQL */
        return $this->stmt->execute();

    }

    public function delete(int $callId)
    {

        /** Parâmetros de entrada */
        $this->callId = $callId;

        /** Sql de inserção */
        $this->sql = 'DELETE FROM calls WHERE call_id = :callId';

        /** Preparo o sql */
        $this->stmt = $this->connection->connect()->prepare($this->sql);

        /** Preencho os parâmetro do sql */
        $this->stmt->bindParam(':callId', $this->callId);

        /** Retorno a execução */
        return $this->stmt->execute();

    }

    public function GetLast()
    {

        /** Sql de busca */
        $this->sql = 'SELECT * FROM calls c
                      ORDER BY c.call_id DESC
                      LIMIT 1';

        /** Preparo o sql */
        $this->stmt = $this->connection->connect()->prepare($this->sql);

        /** Retorno a execução */
        $this->stmt->execute();

        /** Retorno o resultado*/
        return $this->stmt->fetchObject();

    }

    public function get(int $call_id)
    {

        /** Parâmetros de entrada */
        $this->callId = $call_id;

        /** Sql de busca */
        $this->sql = 'SELECT
                        c.*
                      FROM calls c 
                      WHERE call_id = :callId';

        /** Preparo o sql */
        $this->stmt = $this->connection->connect()->prepare($this->sql);

        /** Preencho os parâmetro do sql */
        $this->stmt->bindParam(':callId', $this->callId);

        /** Retorno a execução */
        $this->stmt->execute();

        /** Retorno o resultado*/
        return $this->stmt->fetchObject();

    }

    public function load(int $call_id)
    {

        /** Parâmetros de entrada */
        $this->callId = $call_id;

        /** Sql de busca */
        $this->sql = 'SELECT
						  c.call_id,
						  c.company_id,
						  c.name,
						  c.description,
						  c.date_close
						  FROM calls c
                      WHERE c.call_id = :callId';

        /** Preparo o sql */
        $this->stmt = $this->connection->connect()->prepare($this->sql);

        /** Preencho os parâmetro do sql */
        $this->stmt->bindParam(':callId', $this->callId);

        /** Retorno a execução */
        $this->stmt->execute();

        /** Retorno o resultado*/
        return $this->stmt->fetchObject();

    }

    /** Destrutor da classe */
    public function __destruct()
    {

        /** Instanciamento da classe */
        $this->connection = null;

    }

}
<?php

/** Defino o local da classe */
namespace vendor\model;

class ClientsLogs
{

    /** Declaro as vaiavéis da classe */
    private $connection = null;
    private $sql = null;
    private $stmt = null;

    private $clientErrorLogId;
    private $clientId;
    private $productId;
    private $logTypeId;
    private $data;
    private $dateRegister;

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
    public function GetLast()
    {

        /** Monta a consulta SQL para recuperar os chamados fechados da empresa. */
        $this->sql = 'SELECT cl.*, c.client_name  
                      FROM clients_logs cl
                      join clients c on cl.client_id = clients_id
                      order by cl.client_error_log_id DESC
                      LIMIT 1';

        /** Prepara a consulta SQL utilizando a conexão estabelecida. */
        $this->stmt = $this->connection->connect()->prepare($this->sql);

        /** Executa a consulta SQL. */
        $this->stmt->execute();

        /** Retorna o resultado da consulta como um array de objetos. */
        return $this->stmt->fetchObject();

    }

    /**
     * Recupera todos os registros de chamados fechados para uma empresa específica.
     *
     * @param int $companyId O ID da empresa para a qual os chamados serão recuperados.
     *
     * @return array Retorna um array contendo objetos representando os chamados fechados.
     */
    public function All($dateStart, $dateEnd)
    {

        /** ParÂmetros de entrada */
        $dateStart = $dateStart . ' 00:00:00';
        $dateEnd = $dateEnd . ' 23:59:59';

        /** Monta a consulta SQL para recuperar os chamados fechados da empresa. */
        $this->sql = 'SELECT cl.*, c.client_name FROM clients_logs cl
                      join clients c on cl.client_id = clients_id
                      where cl.date_register BETWEEN :dateStart AND :dateEnd
                      order by cl.client_error_log_id DESC';

        /** Prepara a consulta SQL utilizando a conexão estabelecida. */
        $this->stmt = $this->connection->connect()->prepare($this->sql);

        /** Preenchimento dos parâmetros */
        $this->stmt->bindParam(':dateStart', $dateStart);
        $this->stmt->bindParam(':dateEnd', $dateEnd);

        /** Executa a consulta SQL. */
        $this->stmt->execute();

        /** Retorna o resultado da consulta como um array de objetos. */
        return $this->stmt->fetchAll(\PDO::FETCH_OBJ);

    }

    /**
     * Recupera todos os registros de chamados fechados para uma empresa específica.
     *
     * @param int $companyId O ID da empresa para a qual os chamados serão recuperados.
     *
     * @return array Retorna um array contendo objetos representando os chamados fechados.
     */
    public function AllByClientId(int $clientId)
    {
        /** Define o ID da empresa para a qual os chamados serão recuperados. */
        $this->clientId = $clientId;

        /** Monta a consulta SQL para recuperar os chamados fechados da empresa. */
        $this->sql = 'SELECT * FROM clients_logs where client_id = :clientId 
                      order by client_error_log_id DESC';

        /** Prepara a consulta SQL utilizando a conexão estabelecida. */
        $this->stmt = $this->connection->connect()->prepare($this->sql);

        /** Vincula o parâmetro companyId à consulta SQL. */
        $this->stmt->bindParam(':clientId', $this->clientId);

        /** Executa a consulta SQL. */
        $this->stmt->execute();

        /** Retorna o resultado da consulta como um array de objetos. */
        return $this->stmt->fetchAll(\PDO::FETCH_OBJ);

    }

    /**
     * Recupera todos os registros de chamados fechados para uma empresa específica.
     *
     * @param int $companyId O ID da empresa para a qual os chamados serão recuperados.
     *
     * @return array Retorna um array contendo objetos representando os chamados fechados.
     */
    public function AllGraphByLogTypeId($logTypeId, $dateStart, $dateEnd)
    {

        /** Parâmetros de Entrada */
        $this->logTypeId = $logTypeId;
        $dateStart = $dateStart . ' 00:00:00';
        $dateEnd = $dateEnd . ' 23:59:59';

        /** Monta a consulta SQL para recuperar os chamados fechados da empresa. */
        $this->sql = "select 
                        count(client_error_log_id) as value, 
                        DATE_FORMAT(cl.date_register, '%d-%m-%Y %H:00') as date_register 
                      from clients_logs cl
                        where cl.log_type_id = :logTypeId
                      and cl.date_register BETWEEN :dateStart AND :dateEnd
                        GROUP BY DATE_FORMAT(cl.date_register, '%d-%m-%Y %H:00')";

        /** Prepara a consulta SQL utilizando a conexão estabelecida. */
        $this->stmt = $this->connection->connect()->prepare($this->sql);

        /** Vincula o parâmetro companyId à consulta SQL. */
        $this->stmt->bindParam(':logTypeId', $this->logTypeId);
        $this->stmt->bindParam(':dateStart', $dateStart);
        $this->stmt->bindParam(':dateEnd', $dateEnd);

        /** Executa a consulta SQL. */
        $this->stmt->execute();

        /** Retorna o resultado da consulta como um array de objetos. */
        return $this->stmt->fetchAll(\PDO::FETCH_OBJ);

    }

    /**
     * Recupera todos os registros de chamados fechados para uma empresa específica.
     *
     * @param int $companyId O ID da empresa para a qual os chamados serão recuperados.
     *
     * @return array Retorna um array contendo objetos representando os chamados fechados.
     */
    public function AllLegendsGraphByLogTypeId($logTypeId, $dateStart, $dateEnd)
    {

        /** Parâmetros de Entrada */
        $this->logTypeId = $logTypeId;
        $dateStart = $dateStart . ' 00:00:00';
        $dateEnd = $dateEnd . ' 23:59:59';

        /** Monta a consulta SQL para recuperar os chamados fechados da empresa. */
        $this->sql = "select 
                        DATE_FORMAT(cl.date_register, '%d-%m-%Y %H:00') as date_register 
                      from clients_logs cl
                        where cl.log_type_id = :logTypeId
                      and cl.date_register BETWEEN :dateStart AND :dateEnd
                        GROUP BY DATE_FORMAT(cl.date_register, '%d-%m-%Y %H:00')";

        /** Prepara a consulta SQL utilizando a conexão estabelecida. */
        $this->stmt = $this->connection->connect()->prepare($this->sql);

        /** Vincula o parâmetro companyId à consulta SQL. */
        $this->stmt->bindParam(':logTypeId', $this->logTypeId);
        $this->stmt->bindParam(':dateStart', $dateStart);
        $this->stmt->bindParam(':dateEnd', $dateEnd);

        /** Executa a consulta SQL. */
        $this->stmt->execute();

        /** Retorna o resultado da consulta como um array de objetos. */
        return $this->stmt->fetchAll(\PDO::FETCH_COLUMN);

    }

    /**
     * Recupera todos os registros de chamados fechados para uma empresa específica.
     *
     * @param int $companyId O ID da empresa para a qual os chamados serão recuperados.
     *
     * @return array Retorna um array contendo objetos representando os chamados fechados.
     */
    public function CountByProductId($productId, $dateStart, $dateEnd)
    {

        /** ParÂmetros de entrada */
        $this->productId = $productId;
        $dateStart = $dateStart . ' 00:00:00';
        $dateEnd = $dateEnd . ' 23:59:59';

        /** Monta a consulta SQL para recuperar os chamados fechados da empresa. */
        $this->sql = 'select 
                      count(cl.client_error_log_id) as quantity 
                      from clients_logs cl
                      where cl.date_register BETWEEN :dateStart AND :dateEnd
                      and cl.product_id = :productId';

        /** Prepara a consulta SQL utilizando a conexão estabelecida. */
        $this->stmt = $this->connection->connect()->prepare($this->sql);

        /** Vincula o parâmetro companyId à consulta SQL. */
        $this->stmt->bindParam(':productId', $this->productId);
        $this->stmt->bindParam(':dateStart', $dateStart);
        $this->stmt->bindParam(':dateEnd', $dateEnd);

        /** Executa a consulta SQL. */
        $this->stmt->execute();

        /** Retorna o resultado da consulta como um array de objetos. */
        return $this->stmt->fetchObject();

    }

    /**
     * Recupera todos os registros de chamados fechados para uma empresa específica.
     *
     * @param int $companyId O ID da empresa para a qual os chamados serão recuperados.
     *
     * @return array Retorna um array contendo objetos representando os chamados fechados.
     */
    public function GroupByClientId()
    {

        /** Monta a consulta SQL para recuperar os chamados fechados da empresa. */
        $this->sql = 'select 
                        c.client_name,
                        count(cl.client_error_log_id) as quantity
                      from clients_logs cl
                        join clients c on cl.client_id = clients_id
                        group by cl.client_id';

        /** Prepara a consulta SQL utilizando a conexão estabelecida. */
        $this->stmt = $this->connection->connect()->prepare($this->sql);

        /** Executa a consulta SQL. */
        $this->stmt->execute();

        /** Retorna o resultado da consulta como um array de objetos. */
        return $this->stmt->fetchAll(\PDO::FETCH_OBJ);

    }

    /**
     * Recupera todos os registros de chamados fechados para uma empresa específica.
     *
     * @param int $companyId O ID da empresa para a qual os chamados serão recuperados.
     *
     * @return array Retorna um array contendo objetos representando os chamados fechados.
     */
    public function GroupByProductId($dateStart, $dateEnd)
    {

        /** Parâmetros de Entrada */
        $dateStart = $dateStart . ' 00:00:00';
        $dateEnd = $dateEnd . ' 23:59:59';

        /** Monta a consulta SQL para recuperar os chamados fechados da empresa. */
        $this->sql = 'select 
                        p.name,
                        count(cl.client_error_log_id) as value
                      from clients_logs cl
                        join products p on cl.product_id = p.products_id
                      where cl.date_register BETWEEN :dateStart AND :dateEnd
                      group by cl.product_id';

        /** Prepara a consulta SQL utilizando a conexão estabelecida. */
        $this->stmt = $this->connection->connect()->prepare($this->sql);

        /** Vincula o parâmetro companyId à consulta SQL. */
        $this->stmt->bindParam(':dateStart', $dateStart);
        $this->stmt->bindParam(':dateEnd', $dateEnd);

        /** Executa a consulta SQL. */
        $this->stmt->execute();

        /** Retorna o resultado da consulta como um array de objetos. */
        return $this->stmt->fetchAll(\PDO::FETCH_OBJ);

    }

    /** Destrutor da classe */
    public function __destruct()
    {

        /** Instanciamento da classe */
        $this->connection = null;

    }

}
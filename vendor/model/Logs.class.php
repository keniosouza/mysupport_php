<?php

/** Defino o local da classe */
namespace vendor\model;

class Logs{

    /** Variaveis da classe */
    private $connection = null;
    private $sql = null;
    private $stmt = null;

    private $logId;
    private $logTypeId;
    private $companyId;
    private $userId;
    private $table;
    private $registerId;
    private $hash;
    private $data;
    private $dateRegister;

    /** Construtor da classe */
    public function __construct()
    {

        /** Instanciamento da classe */
        $this->connection = new Mysql();

    }

    /** Método para salvar um registro */
    public function Save(int $logId, int $logTypeId, int $companyId, int $userId, string $table, ? int $registerId, ? string $hash, string $data, string $dateRegister)
    {

        /** Parâmetros de entrada */
        $this->logId = $logId;
        $this->logTypeId = $logTypeId;
        $this->companyId = $companyId;
        $this->userId = $userId;
        $this->table = $table;
        $this->registerId = $registerId;
        $this->hash = $hash;
        $this->data = $data;
        $this->dateRegister = $dateRegister;

        /** Sql para inserção */
        $this->sql = 'INSERT INTO logs(`log_id`, `log_type_id`, `company_id`, `user_id`, `table`, `register_id`, `hash`, `data`, `date_register`) 
                      VALUES(:logId, :logTypeId, :companyId, :userId, :table, :registerId, :hash, :data, :dateRegister)';

        /** Preparo o SQL */
        $this->stmt = $this->connection->connect()->prepare($this->sql);

        /** Preencho os valores do sql */
        $this->stmt->bindParam(':logId', $this->logId, \PDO::PARAM_INT);
        $this->stmt->bindParam(':logTypeId', $this->logTypeId, \PDO::PARAM_INT);
        $this->stmt->bindParam(':companyId', $this->companyId, \PDO::PARAM_INT);
        $this->stmt->bindParam(':userId', $this->userId, \PDO::PARAM_INT);
        $this->stmt->bindParam(':table', $this->table);
        $this->stmt->bindParam(':registerId', $this->registerId, $this->registerId > 0 ? \PDO::PARAM_INT : \PDO::PARAM_NULL);
        $this->stmt->bindParam(':hash', $this->hash);
        $this->stmt->bindParam(':data', $this->data);
        $this->stmt->bindParam(':dateRegister', $this->dateRegister);

        /** Execução do sql */
        return $this->stmt->execute();

    }

    /** Método para salvar um registro */
    public function All()
    {

        /** Sql para inserção */
        $this->sql = "SELECT l.*, 
                             u.name_first, 
                             u.name_last 
                      FROM logs l 
                      JOIN users u on l.user_id = u.users_id
                      ORDER BY l.log_id DESC";

        /** Preparo o SQL */
        $this->stmt = $this->connection->connect()->prepare($this->sql);

        /** Executo o SQL */
        $this->stmt->execute();

        /** Retorno o resultado */
        return $this->stmt->fetchAll(\PDO::FETCH_OBJ);

    }

    /** Método para salvar um registro */
    public function AllByUser(int $userId)
    {

        /** Parâmetros de entrada */
        $this->userId = $userId;

        /** Sql para inserção */
        $this->sql = "SELECT l.*, 
                             u.name_first, 
                             u.name_last 
                      FROM logs l 
                      JOIN users u on l.user_id = u.users_id
                        WHERE l.user_id = :userId
                      ORDER BY l.log_id DESC";

        /** Preparo o SQL */
        $this->stmt = $this->connection->connect()->prepare($this->sql);

        /** Preencho os valores do sql */
        $this->stmt->bindParam(':userId', $this->userId);

        /** Executo o SQL */
        $this->stmt->execute();

        /** Retorno o resultado */
        return $this->stmt->fetchAll(\PDO::FETCH_OBJ);

    }

    /** Método para salvar um registro */
    public function AllByHash(string $hash)
    {

        /** Parâmetros de entrada */
        $this->hash = $hash;

        /** Sql para inserção */
        $this->sql = "SELECT l.*, 
                             u.name_first, 
                             u.name_last 
                      FROM logs l 
                      JOIN users u on l.user_id = u.users_id
                        WHERE l.hash = :hash
                      ORDER BY l.log_id DESC";

        /** Preparo o SQL */
        $this->stmt = $this->connection->connect()->prepare($this->sql);

        /** Preencho os valores do sql */
        $this->stmt->bindParam(':hash', $this->hash);

        /** Executo o SQL */
        $this->stmt->execute();

        /** Retorno o resultado */
        return $this->stmt->fetchAll(\PDO::FETCH_OBJ);

    }

    /** Destrutor da classe */
    public function __destruct()
    {

        /** Instanciamento da classe */
        $this->connection = null;

    }

}
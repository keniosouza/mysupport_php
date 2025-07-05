<?php

/** Defino o local da classe */
namespace vendor\model;

class Messages{

    /** Variaveis da classe */
    private $connection = null;
    private $sql = null;
    private $stmt = null;

    private $messageId;
    private $userId;
    private $table;
    private $registerId;
    private $data;
    private $dateRegister;

    /** Construtor da classe */
    public function __construct()
    {

        /** Instanciamento da classe */
        $this->connection = new Mysql();

    }

    /** Método para salvar um registro */
    public function Save(int $messageId, $userId, $table, $registerId, $data, $dateRegister)
    {

        /** Parâmetros de entrada */
        $this->messageId = $messageId;
        $this->userId = $userId;
        $this->table = $table;
        $this->registerId = $registerId;
        $this->data = $data;
        $this->dateRegister = $dateRegister;

        /** Sql para inserção */
        $this->sql = 'INSERT INTO messages(`message_id`, `user_id`, `table`, `register_id`, `data`, `date_register`) 
                             VALUES(:messageId, :userId, :table, :registerId, :data, :dateRegister)';

        /** Preparo o SQL */
        $this->stmt = $this->connection->connect()->prepare($this->sql);

        /** Preencho os valores do sql */
        $this->stmt->bindParam(':messageId', $this->messageId);
        $this->stmt->bindParam(':userId', $this->userId);
        $this->stmt->bindParam(':table', $this->table);
        $this->stmt->bindParam(':registerId', $this->registerId);
        $this->stmt->bindParam(':data', $this->data);
        $this->stmt->bindParam(':dateRegister', $this->dateRegister);

        /** Execução do sql */
        return $this->stmt->execute();

    }

    /** Método para salvar um registro */
    public function All(string $table, int $registerId)
    {

        $this->table = $table;
        $this->registerId = $registerId;

        /** Sql para inserção */
        $this->sql = "SELECT
                        m.user_id,
                        m.data,
                        m.date_register,
                        u.name_first,
                        u.name_last
                      FROM messages m
                      JOIN users u on m.user_id = u.users_id
                        WHERE m.table = :table
                        AND m.register_id = :registerId";

        /** Preparo o SQL */
        $this->stmt = $this->connection->connect()->prepare($this->sql);

        $this->stmt->bindParam(':table', $this->table);
        $this->stmt->bindParam(':registerId', $this->registerId);

        /** Executo o SQL */
        $this->stmt->execute();

        /** Retorno o resultado */
        return $this->stmt->fetchAll(\PDO::FETCH_OBJ);

    }

    /** Método para salvar um registro */
    public function GetLast(string $table, int $registerId)
    {

        $this->table = $table;
        $this->registerId = $registerId;

        /** Sql para inserção */
        $this->sql = "SELECT
                        m.message_id,
                        m.user_id,
                        m.data,
                        m.date_register,
                        u.name_first,
                        u.name_last
                      FROM messages m
                      JOIN users u on m.user_id = u.users_id
                        WHERE m.table = :table
                        AND m.register_id = :registerId
                      ORDER BY m.message_id DESC
                      LIMIT 1";

        /** Preparo o SQL */
        $this->stmt = $this->connection->connect()->prepare($this->sql);

        $this->stmt->bindParam(':table', $this->table);
        $this->stmt->bindParam(':registerId', $this->registerId);

        /** Executo o SQL */
        $this->stmt->execute();

        /** Retorno o resultado */
        return $this->stmt->fetchObject();

    }

    /** Destrutor da classe */
    public function __destruct()
    {

        /** Instanciamento da classe */
        $this->connection = null;

    }

}
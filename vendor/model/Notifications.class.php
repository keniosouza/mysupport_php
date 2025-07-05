<?php

/** Defino o local da classe */
namespace vendor\model;

class Notifications{

    /** Variaveis da classe */
    private $connection = null;
    private $sql = null;
    private $stmt = null;

    private $notificationId;
    private $companyId;
    private $userId;
    private $destinyUserId;
    private $table;
    private $registerId;
    private $status;
    private $data;
    private $dateRegister;

    /** Construtor da classe */
    public function __construct()
    {

        /** Instanciamento da classe */
        $this->connection = new Mysql();

    }

    /** Método para salvar um registro */
    public function Save($notificationId, $companyId, $userId, $destinyUserId, $table, $registerId, $status, $data, $dateRegister)
    {

        /** Parâmetros de entrada */
        $this->notificationId = $notificationId;
        $this->companyId = $companyId;
        $this->userId = $userId;
        $this->destinyUserId = $destinyUserId;
        $this->table = $table;
        $this->registerId = $registerId;
        $this->data = $data;
        $this->status = $status;
        $this->dateRegister = $dateRegister;

        /** Sql para inserção */
        $this->sql = 'INSERT INTO notifications(`notification_id`, `company_id`, `user_id`, `destiny_user_id`, `table`, `register_id`, `status`, `data`, `date_register`) 
                             VALUES(:notificationId, :companyId, :userId, :destinyUserId, :table, :registerId, :status, :data, :dateRegister)';

        /** Preparo o SQL */
        $this->stmt = $this->connection->connect()->prepare($this->sql);

        /** Preencho os valores do sql */
        $this->stmt->bindParam(':notificationId', $this->notificationId);
        $this->stmt->bindParam(':companyId', $this->companyId);
        $this->stmt->bindParam(':userId', $this->userId);
        $this->stmt->bindParam(':destinyUserId', $this->destinyUserId);
        $this->stmt->bindParam(':table', $this->table);
        $this->stmt->bindParam(':registerId', $this->registerId);
        $this->stmt->bindParam(':status', $this->status);
        $this->stmt->bindParam(':data', $this->data);
        $this->stmt->bindParam(':dateRegister', $this->dateRegister);

        /** Execução do sql */
        return $this->stmt->execute();

    }

    /** Método para salvar um registro */
    public function SaveStatus($notificationId, $destinyUserId, $status)
    {

        /** Parâmetros de entrada */
        $this->notificationId = $notificationId;
        $this->destinyUserId = $destinyUserId;
        $this->status = $status;

        /** Sql para inserção */
        $this->sql = 'UPDATE notifications SET status = :status
                      WHERE notification_id = :notificationId and destiny_user_id = :destinyUserId';

        /** Preparo o SQL */
        $this->stmt = $this->connection->connect()->prepare($this->sql);

        /** Preencho os valores do sql */
        $this->stmt->bindParam(':notificationId', $this->notificationId);
        $this->stmt->bindParam(':destinyUserId', $this->destinyUserId);
        $this->stmt->bindParam(':status', $this->status);

        /** Execução do sql */
        return $this->stmt->execute();

    }

    /** Método para salvar um registro */
    public function All()
    {

        /** Sql para inserção */
        $this->sql = "SELECT
                        n.notification_id,
                        n.user_id,
                        n.destiny_user_id,
                        n.data,
                        u.name_first
                      FROM notifications n
                      JOIN users u on n.user_id = u.users_id";

        /** Preparo o SQL */
        $this->stmt = $this->connection->connect()->prepare($this->sql);

        /** Executo o SQL */
        $this->stmt->execute();

        /** Retorno o resultado */
        return $this->stmt->fetchAll(\PDO::FETCH_OBJ);

    }

    /** Método para salvar um registro */
    public function AllByUserId(int $userId)
    {

        /** ParÂmetros de entrada */
        $this->userId = $userId;

        /** Sql para inserção */
        $this->sql = "SELECT
                        n.notification_id,
                        n.user_id,
                        n.destiny_user_id,
                        n.data,
                        n.register_id,
                        n.date_register,
                        u.name_first
                      FROM notifications n
                        JOIN users u on n.user_id = u.users_id
                      WHERE u.users_id = :userId
                        ORDER BY n.notification_id DESC";

        /** Preparo o SQL */
        $this->stmt = $this->connection->connect()->prepare($this->sql);

        /** Preenchimento dos parâmetros */
        $this->stmt->bindParam('userId', $this->userId);

        /** Executo o SQL */
        $this->stmt->execute();

        /** Retorno o resultado */
        return $this->stmt->fetchAll(\PDO::FETCH_OBJ);

    }

    /** Método para salvar um registro */
    public function AllGroupedByUserId(int $userId)
    {

        /** ParÂmetros de entrada */
        $this->userId = $userId;
        $this->table = 'calls_activities';

        /** Sql para inserção */
        $this->sql = "SELECT
                       DISTINCT 
                        n.table,
                        n.register_id,
                        n.destiny_user_id
                      FROM notifications n
                        JOIN users u on n.user_id = u.users_id
                      WHERE n.destiny_user_id = :userId
                        AND n.table = :table
                      ORDER BY n.register_id DESC";

        /** Preparo o SQL */
        $this->stmt = $this->connection->connect()->prepare($this->sql);

        /** Preenchimento dos parâmetros */
        $this->stmt->bindParam('userId', $this->userId);
        $this->stmt->bindParam('table', $this->table);

        /** Executo o SQL */
        $this->stmt->execute();

        /** Retorno o resultado */
        return $this->stmt->fetchAll(\PDO::FETCH_OBJ);

    }

    /** Método para salvar um registro */
    public function GetLastByTableAndRegisterId(string $table, int $registerId, int $destinyUserId)
    {

        /** ParÂmetros de entrada */
        $this->table = $table;
        $this->registerId = $registerId;
        $this->destinyUserId = $destinyUserId;

        /** Sql para inserção */
        $this->sql = "SELECT
                       *
                      FROM notifications n
                      where n.table = :table
                        and n.register_id = :registerId
                        and n.destiny_user_id = :destinyUserId
                      order by n.notification_id desc
                      limit 1";

        /** Preparo o SQL */
        $this->stmt = $this->connection->connect()->prepare($this->sql);

        /** Preenchimento dos parâmetros */
        $this->stmt->bindParam('table', $this->table);
        $this->stmt->bindParam('registerId', $this->registerId);
        $this->stmt->bindParam('destinyUserId', $this->destinyUserId);

        /** Executo o SQL */
        $this->stmt->execute();

        /** Retorno o resultado */
        return $this->stmt->fetchObject();

    }

    /** Método para salvar um registro */
    public function AllByStatus(int $status)
    {

        /** ParÂmetros de entrada */
        $this->status = $status;

        /** Sql para inserção */
        $this->sql = "SELECT
                        n.notification_id,
                        n.user_id,
                        n.destiny_user_id,
                        n.data,
                        u.name_first
                      FROM notifications n
                        JOIN users u on n.user_id = u.users_id
                      WHERE n.status = :status";

        /** Preparo o SQL */
        $this->stmt = $this->connection->connect()->prepare($this->sql);

        /** Preenchimento dos parâmetros */
        $this->stmt->bindParam('status', $this->status);

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
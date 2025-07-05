<?php

/** Defino o local da classe */
namespace vendor\model;

class ClientsBackupsLogs
{

    /** Declaro as vaiavéis da classe */
    private $connection = null;
    private $sql = null;
    private $stmt = null;

    private $clientBackupLogId = null;
    private $clientId = null;
    private $path = null;
    private $name = null;
    private $size = null;
    private $dateModified = null;


    /** Construtor da classe */
    public function __construct()
    {

        /** Instanciamento da classe */
        $this->connection = new Mysql();

    }

    /** Insere um novo registro no banco */
    public function Save(int $clientBackupLogId, string $clientId, string $path, string $name, string $size, string $dateModified): bool
    {

        /** Parametros */
        $this->clientBackupLogId = $clientBackupLogId;
        $this->clientId = $clientId;
        $this->path = $path;
        $this->name = $name;
        $this->size = $size;
        $this->dateModified = $dateModified;

        /** Consulta SQL */
        $this->sql = 'INSERT INTO clients_backups_logs (client_backup_log_id,
                                                        client_id,
                                                        path,
                                                        name,
                                                        size,
                                                        date_modified) VALUES(:clientBackupLogId,
                                                                              :clientId,
                                                                              :path,
                                                                              :name,
                                                                              :size,
                                                                              :dateModified)';

        /** Preparo o sql para receber os valores */
        $this->stmt = $this->connection->connect()->prepare($this->sql);

        /** Preencho os parâmetros do SQL */
        $this->stmt->bindParam('clientBackupLogId', $this->clientBackupLogId);
        $this->stmt->bindParam('clientId', $this->clientId);
        $this->stmt->bindParam('path', $this->path);
        $this->stmt->bindParam('name', $this->name);
        $this->stmt->bindParam('size', $this->size);
        $this->stmt->bindParam('dateModified', $this->dateModified);

        /** Executo o SQL */
        return $this->stmt->execute();

    }

    /** Insere um novo registro no banco */
    public function All(int $clientId)
    {

        /** Parametros */
        $this->clientId = $clientId;

        /** Consulta SQL */
        $this->sql = 'select * from clients_backups_logs where client_id = :clientId';

        /** Preparo o sql para receber os valores */
        $this->stmt = $this->connection->connect()->prepare($this->sql);

        /** Preencho os parâmetros do SQL */
        $this->stmt->bindParam('clientId', $this->clientId);

        /** Executo o SQL */
        $this->stmt->execute();

        /** Retorno o resultado */
        return $this->stmt->fetchAll(\PDO::FETCH_OBJ);

    }

    /** Insere um novo registro no banco */
    public function Get(int $clientBackupLogId)
    {

        /** Parametros */
        $this->clientBackupLogId = $clientBackupLogId;

        /** Consulta SQL */
        $this->sql = 'select * from clients_backups_logs where client_backup_log_id = :clientBackupLogId';

        /** Preparo o sql para receber os valores */
        $this->stmt = $this->connection->connect()->prepare($this->sql);

        /** Preencho os parâmetros do SQL */
        $this->stmt->bindParam('clientBackupLogId', $this->clientBackupLogId);

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
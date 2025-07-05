<?php
/**
 * Classe Users.class.php
 * @filesource
 * @autor        Kenio de Souza
 * @copyright    Copyright 2021 - Souza Consultoria Tecnológica
 * @package        model
 * @subpackage    model.class
 * @version        1.0
 */

/** Defino o local onde esta a classe */
namespace vendor\model;

class Users
{
    /** Declaro as vaiavéis da classe */
    private $connection = null;
    private $sql = null;
    private $stmt = null;
    private $start = null;
    private $max = null;
    private $limit = null;
    private $usersId = null;
    private $companyId = null;
    private $usersAclId = null;
    private $nameFirst = null;
    private $nameLast = null;
    private $email = null;
    private $password = null;
    private $active = null;
    private $birthDate = null;
    private $genre = null;
    private $dateRegister = null;
    private $accessFirst = null;
    private $accessLast = null;
    private $administrator = null;
    private $passwordTemp = null;
    private $access = null;
    private $resultDescribe = null;
    private $firstAccess = null;
    private $hash = null;
    private $cost = null;
    private $passwordTempConfirm = null;
    private $usersIdCreate = null;
    private $usersIdUpdate = null;
    private $and = null;
    private $where = null;

    /** Construtor da classe */
    function __construct()
    {
        /** Cria o objeto de conexão com o banco de dados */
        $this->connection = new Mysql();

    }

    /** Carrega os campos de uma tabela */
    public function Describe()
    {

        /** Consulta SQL */
        $this->sql = "describe users";

        /** Preparo o SQL para execução */
        $this->stmt = $this->connection->connect()->prepare($this->sql);

        /** Executo o SQL */
        $this->stmt->execute();

        /** Retorno o resultado */
        $this->field = $this->stmt->fetchAll(\PDO::FETCH_OBJ);

        /** Declara o objeto */
        $resultDescribe = new \stdClass();
        $Field = '';

        /** Lista os campos da tabela para objetos */
        foreach ($this->field as $UsersKey => $Result) {

            /** Pega o nome do Field/Campo */
            $Field = $Result->Field;

            /** Carrega os objetos como null */
            $resultDescribe->$Field = null;

        }

        /** Retorna os campos declarados como vazios */
        return $resultDescribe;

    }

    /** Localiza um registro especifico pela chave primária */
    public function Get(int $usersId)
    {

        /** Parametros de entrada */
        $this->usersId = $usersId;

        /** Consulta SQL */
        $this->sql = 'select  u.*, 
		                     c.company_id,
                             c.company_name,
                             c.fantasy_name
					  from users u
					  left join company c on u.company_id = c.company_id
					  where u.users_id = :users_id';

        /** Preparo o SQL para execução */
        $this->stmt = $this->connection->connect()->prepare($this->sql);

        /** Preencho os parâmetros do SQL */
        $this->stmt->bindParam(':users_id', $this->usersId);

        /** Executo o SQL */
        $this->stmt->execute();

        /** Retorno o resultado */
        return $this->stmt->fetchObject();

    }

    public function Get_last_id()
    {


        /** Consulta SQL */
        $this->sql = 'SELECT users_id
                      FROM users
                      ORDER BY users_id DESC
                      LIMIT 1';


        /** Preparo o SQL para execução */
        $this->stmt = $this->connection->connect()->prepare($this->sql);

        /** Executo o SQL */
        $this->stmt->execute();

        /** Retorno o resultado */
        return $this->stmt->fetchObject();

    }


    /** Localiza um registro especifico pelo e-mail informado */
    public function checkMail(string $email)
    {

        /** Parametros de entrada */
        $this->email = $email;

        /** Consulta SQL */
        $this->sql = 'select u.users_id,
                             u.name_first, 
		                     u.email 
					  from users u
					  where u.email = :email';

        /** Preparo o SQL para execução */
        $this->stmt = $this->connection->connect()->prepare($this->sql);

        /** Preencho os parâmetros do SQL */
        $this->stmt->bindParam(':email', $this->email);

        /** Executo o SQL */
        $this->stmt->execute();

        /** Retorno o resultado */
        return $this->stmt->fetchAll(\PDO::FETCH_OBJ);

    }

    /** Contabiliza a quantidade de usuers cadastrados */
    public function Count(int $companyId)
    {

        /** Parametros de entrada */
        $this->companyId = ($companyId > 0 ? $companyId : (isset($_SESSION['USERSCOMPANYID']) ? $_SESSION['USERSCOMPANYID'] : 0));

        /** Verifica se a empresa foi informada */
        if ($this->companyId > 0) {

            $this->where = " where company_id = {$this->companyId} ";
        }

        /** Consulta SQL */
        $this->sql = 'select count(users_id) as qtde
					  from users ' . $this->where;

        /** Preparo o SQL para execução */
        $this->stmt = $this->connection->connect()->prepare($this->sql);

        /** Executo o SQL */
        $this->stmt->execute();

        /** Retorno o resultado */
        return $this->stmt->fetchObject();
    }

    /** Lista todos os egistros do banco com ou sem paginação*/
    public function All(int $companyId)
    {
        /** Parametros de entrada */
        $this->companyId = $companyId;

        /** Consulta SQL */
        $this->sql = 'select * from users where company_id = :companyId';

        /** Preparo o SQL para execução */
        $this->stmt = $this->connection->connect()->prepare($this->sql);

        /** Preenchimento de parâmetros */
        $this->stmt->bindParam(':companyId', $this->companyId);

        /** Executo o SQL */
        $this->stmt->execute();

        /** Retorno o resultado */
        return $this->stmt->fetchAll(\PDO::FETCH_OBJ);

    }

    public function AllLeadBoard(int $companyId, string $dateInitial, string $dateFinal)
    {

        /** Parametros de entrada */
        $this->companyId = $companyId;
        $this->dateInitial = $dateInitial;
        $this->dateFinal = $dateFinal;
        $this->table = 'users';

        /** Consulta SQL */
        $this->sql = 'select
                      u.users_id,
                      u.email,
                      u.name_first,
                      u.name_last,
                      (select count(call_activity_id)
                       from calls_activities_users cau
                       where user_id = u.users_id
                             and cau.date_close is not null
                             and cau.date_close between :dateInitial and :dateFinal)                                 as quantity,
                      (select CONCAT(f.path, "/", f.name)
                       from files f
                       where f.table = :table and f.register_id = u.users_id
                       order by file_id desc
                       limit 1)                                                                                      as profile_photo,
                      ((select count(call_activity_user_id)
                        from calls_activities_users
                        where user_id = u.users_id and date_close is not null) / (select count(call_activity_user_id)
                                                                                  from calls_activities_users
                                                                                  where user_id = u.users_id)) * 100 as progress
                    from users u
                    where company_id = :companyId
                    order by quantity DESC';

        /** Preparo o SQL para execução */
        $this->stmt = $this->connection->connect()->prepare($this->sql);

        /** Preenchimento de parâmetros */
        $this->stmt->bindParam(':companyId', $this->companyId);
        $this->stmt->bindParam(':dateInitial', $this->dateInitial);
        $this->stmt->bindParam(':dateFinal', $this->dateFinal);
        $this->stmt->bindParam(':table', $this->table);

        /** Executo o SQL */
        $this->stmt->execute();

        /** Retorno o resultado */
        return $this->stmt->fetchAll(\PDO::FETCH_OBJ);

    }

    public function AllGraphByCount(int $companyId)
    {
        /** Parametros de entrada */
        $this->companyId = $companyId;
        $this->table = 'users';

        /** Consulta SQL */
        $this->sql = 'select
                          u.email,
                          u.name_first,
                          u.name_last,
                          (select count(call_activity_id)
                           from calls_activities_users cau
                           where user_id = u.users_id and cau.date_close is not null) as quantity,
                           (select CONCAT(f.path, "/", f.name)
                           from files f
                           where f.table = :table and f.register_id = u.users_id
                           order by file_id desc
                           limit 1) as profile_photo
                        from users u
                        where company_id = :companyId
                        order by quantity DESC';

        /** Preparo o SQL para execução */
        $this->stmt = $this->connection->connect()->prepare($this->sql);

        /** Preenchimento de parâmetros */
        $this->stmt->bindParam(':companyId', $this->companyId);
        $this->stmt->bindParam(':table', $this->table);

        /** Executo o SQL */
        $this->stmt->execute();

        /** Retorno o resultado */
        return $this->stmt->fetchAll(\PDO::FETCH_OBJ);

    }

    /** Lista todos os egistros do banco com ou sem paginação*/
    public function AllNoLimit(int $companyId, int $callId, string $situation)
    {
        /** Parametros de entrada */
        $this->companyId = $companyId;
        $this->callId = $callId;
        $this->situation = $situation;
        $this->table = 'users';

        /** Consulta SQL */
        $this->sql = 'SELECT 
                        u.*,
                         (select CONCAT(f.path, "/", f.name)
                           from files f
                           where f.table = :table and f.register_id = u.users_id
                           order by file_id desc
                           limit 1) as profile_photo,
                          
                           (select count(call_activity_id)
                           from calls_activities_users cau
                           where user_id = u.users_id) as calls_users_activities,
                           
                          (select count(call_mesage_id)
                           from calls_messages cm
                           where user_id = u.users_id) as calls_messages
                           
                      FROM users u
                      WHERE u.users_id not in
                           (SELECT user_id
                            FROM calls_users
                            WHERE call_id = :callId)
                      AND u.company_id = :companyId
                      AND u.active = :situation';

        /** Preparo o SQL para execução */
        $this->stmt = $this->connection->connect()->prepare($this->sql);

        /** Preenchimento de parâmetros */
        $this->stmt->bindParam(':companyId', $this->companyId);
        $this->stmt->bindParam(':callId', $this->callId);
        $this->stmt->bindParam(':situation', $this->situation);
        $this->stmt->bindParam(':table', $this->table);

        /** Executo o SQL */
        $this->stmt->execute();

        /** Retorno o resultado */
        return $this->stmt->fetchAll(\PDO::FETCH_OBJ);

    }

    /** Localiza um usuário pelo e-mail e senha */
    public function Access_new(string $email)
    {

        /** Parametros de entrada */
        $this->email = $email;
        $this->active = 'S';

        /** Consulta SQL */
        $this->sql = 'select u.users_id,
						     u.company_id,
							 u.name_first,
							 u.name_last,
							 u.email,
							 u.password,
							 u.active,
							 u.date_register,
							 u.access_first,
							 u.access_last,
							 u.password_temp_confirm,
							 c.fantasy_name,
							 c.company_name,
							 c.document
					from users u
					left join company c on u.company_id = c.company_id
					where u.email = :email
					and u.active = :active
					limit 1';

        /** Preparo o SQL para execução */
        $this->stmt = $this->connection->connect()->prepare($this->sql);

        /** Preencho os parâmetros do SQL */
        $this->stmt->bindParam(':email', $this->email);
        $this->stmt->bindParam(':active', $this->active);

        /** Executo o SQL */
        $this->stmt->execute();

        /** Retorno o resultado */
        return $this->stmt->fetchObject();

    }

    /** Localiza um usuário pelo e-mail e senha */
    public function Access(string $email, string $password, string $firstAccess)
    {

        /** Parametros de entrada */
        $this->email = $email;
        $this->password = $password;
        $this->firstAccess = $firstAccess;

        /** Consulta SQL */
        $this->sql = 'select u.users_id,
						     u.company_id,
							 u.name_first,
							 u.name_last,
							 u.email,
							 u.password,
							 u.active,
							 u.date_register,
							 u.access_first,
							 u.access_last,
							 u.password_temp_confirm,
							 c.fantasy_name,
							 c.company_name,
							 c.document
					from users u
					left join company c on u.company_id = c.company_id
					where u.email = :email ';

        /** Verifica se é o primeiro acesso do usuário */
        if ($this->firstAccess == "S") {

            $this->sql .= 'and u.password = :password ';
            $this->sql .= 'and u.access_first is null ';
            $this->sql .= 'and u.password_temp = :password_temp ';

        } else {
            /** Caso não localize que seja o primeiro acesso */

            $this->sql .= 'and u.access_first is not null ';
        }

        /** Verifica se o usuário esta ativo */
        $this->sql .= 'and u.active = "S"; ';

        /** Preparo o sql para receber os valores */
        $this->stmt = $this->connection->connect()->prepare($this->sql);

        /** Preencho os parâmetros do SQL */
        $this->stmt->bindParam(':email', $this->email);

        /** Verifica se é o primeiro acesso do usuário */
        if ($this->firstAccess == "S") {

            $this->stmt->bindParam(':password', $this->password);
            $this->stmt->bindParam(':password_temp', $this->password);

        }

        /** Executo o SQL */
        $this->stmt->execute();

        /** Retorno o resultado */
        return $this->stmt->fetchObject();

    }

    /** Localiza um usuário pelo e-mail e senha */
    public function Access2(string $email)
    {

        /** Parametros de entrada */
        $this->email = $email;
        $this->active = 'S';

        /** Consulta SQL */
        $this->sql = 'select u.users_id,
						     u.company_id,
							 u.name_first,
							 u.name_last,
							 u.email,
							 u.password,
							 u.active,
							 u.date_register,
							 u.access_first,
							 u.access_last,
							 u.password_temp_confirm,
							 c.fantasy_name,
							 c.company_name,
							 c.document
					from users u
					left join company c on u.company_id = c.company_id
					where u.email = :email
					and u.active = :active
					order by u.users_id asc
					limit 1';

        /** Preparo o sql para receber os valores */
        $this->stmt = $this->connection->connect()->prepare($this->sql);

        /** Preencho os parâmetros do SQL */
        $this->stmt->bindParam(':email', $this->email);
        $this->stmt->bindParam(':active', $this->active);

        /** Executo o SQL */
        $this->stmt->execute();

        /** Retorno o resultado */
        return $this->stmt->fetchObject();

    }

    /** Atualiza o acesso do usuário */
    public function AccessInfo(string $access)
    {
        /** Parametros de entrada */
        $this->access = $access;


        /** Verifica qual acesso atualizar */
        switch ($this->access) {

            case 'first':

                /** Consulta SQL */
                $this->sql = "update users set access_first = current_timestamp,
												   access_last = current_timestamp
					              where users_id = :users_id
								  and password is not null";

                /** Preparo o sql para receber os valores */
                $this->stmt = $this->connection->connect()->prepare($this->sql);

                /** Preencho os parâmetros do SQL */
                $this->stmt->bindParam(':users_id', $_SESSION['USERSID']);

                /** Executo o SQL */
                return $this->stmt->execute();

                break;


            case 'new':

                /** Consulta SQL */
                $this->sql = "update users set access_last = current_timestamp where users_id = :users_id";

                /** Preparo o sql para receber os valores */
                $this->stmt = $this->connection->connect()->prepare($this->sql);

                /** Preencho os parâmetros do SQL */
                $this->stmt->bindParam(':users_id', $_SESSION['USERSID']);

                /** Executo o SQL */
                return $this->stmt->execute();

                break;

        }

    }

    /** Insere um novo registro no banco */
    public function Register(int $usersId, int $companyId, string $nameFirst, string $nameLast, string $email, string $active, string $password)
    {

        /** Parametros */
        $this->usersId = $usersId;
        $this->companyId = $companyId;
        $this->nameFirst = $nameFirst;
        $this->nameLast = $nameLast;
        $this->email = $email;
        $this->password = $this->passwordHash($password);
        $this->active = $active;

        /** Consulta SQL */
        $this->sql = 'insert into users(users_id, 
                                        company_id,
                                        name_first, 
                                        name_last, 
                                        email, 
                                        password, 
                                        active
								 	 ) values (:users_id, 
									           :company_id,
									  		   :name_first,
									  		   :name_last,
									  		   :email,
									  		   :password,
									  		   :active)';

        /** Preparo o sql para receber os valores */
        $this->stmt = $this->connection->connect()->prepare($this->sql);

        /** Preencho os parâmetros do SQL */
        $this->stmt->bindParam('users_id', $this->usersId);
        $this->stmt->bindParam('company_id', $this->companyId);
        $this->stmt->bindParam('name_first', $this->nameFirst);
        $this->stmt->bindParam('name_last', $this->nameLast);
        $this->stmt->bindParam('email', $this->email);
        $this->stmt->bindParam('password', $this->password);
        $this->stmt->bindParam('active', $this->active);

        /** Executo o SQL */
        return $this->stmt->execute();

    }

    /** Insere um novo registro no banco */
    public function SaveProfile(int $usersId, string $nameFirst, string $nameLast, string $birthDate, string $genre)
    {

        /** Parametros */
        $this->usersId = $usersId;
        $this->nameFirst = $nameFirst;
        $this->nameLast = $nameLast;
        $this->birthDate = $birthDate;
        $this->genre = $genre;

        /** Consulta SQL */
        $this->sql = 'update users set name_first = :name_first, 
                                       name_last = :name_last, 
                                       birth_date = :birthDate, 
                                       genre = :genre 
					  where users_id = :users_id';

        /** Preparo o sql para receber os valores */
        $this->stmt = $this->connection->connect()->prepare($this->sql);

        /** Preencho os parâmetros do SQL */
        $this->stmt->bindParam('users_id', $this->usersId);
        $this->stmt->bindParam('name_first', $this->nameFirst);
        $this->stmt->bindParam('name_last', $this->nameLast);
        $this->stmt->bindParam('birthDate', $this->birthDate);
        $this->stmt->bindParam('genre', $this->genre);

        /** Executo o SQL */
        return $this->stmt->execute();

    }

    /** Insere um novo registro no banco */
    public function Save(int $usersId, string $nameFirst, string $nameLast, string $email, string $birthDate, string $genre, string $active, string $administrator)
    {

        /** Parametros */
        $this->usersId = $usersId;
        $this->nameFirst = $nameFirst;
        $this->nameLast = $nameLast;
        $this->email = $email;
        $this->active = $active;
        $this->birthDate = $birthDate;
        $this->genre = $genre;
        $this->administrator = $administrator;

        /** Consulta SQL */
        $this->sql = 'update users set name_first = :name_first,
                                       name_last = :name_last,
                                       email = :email,
                                       active = :active,
                                       birth_date = :birth_date,
                                       genre = :genre,
                                       administrator = :administrator
                      where users_id = :users_id';

        /** Preparo o sql para receber os valores */
        $this->stmt = $this->connection->connect()->prepare($this->sql);

        /** Preencho os parâmetros do SQL */
        $this->stmt->bindParam('users_id', $this->usersId);
        $this->stmt->bindParam('name_first', $this->nameFirst);
        $this->stmt->bindParam('name_last', $this->nameLast);
        $this->stmt->bindParam('email', $this->email);
        $this->stmt->bindParam('active', $this->active);
        $this->stmt->bindParam('birth_date', $this->birthDate);
        $this->stmt->bindParam('genre', $this->genre);
        $this->stmt->bindParam('administrator', $this->administrator);

        /** Executo o SQL */
        return $this->stmt->execute();

    }

    /** Atualiza a senha do usuário */
    public function UpdatePassword(string $password, int $usersId)
    {

        /** Parametros de entrada */
        $this->password = $this->passwordHash($password);
        $this->usersId  = $usersId;

        /** Consulta SQL */
        $this->sql = 'update users set password = :password
					  where users_id = :users_id';

        /** Preparo o SQL para execução */
        $this->stmt = $this->connection->connect()->prepare($this->sql);

        /** Preencho os parâmetros do SQL */
        $this->stmt->bindParam(':users_id', $this->usersId);# Atualiza a senha de acordo com o usuário identificado
        $this->stmt->bindParam(':password', $this->password);# Atualiza a senha de acordo com o usuário identificado

        /** Executo o SQL */
        return $this->stmt->execute();

    }

    /** Gera um password hash */
    public function passwordHash($password)
    {

        /** Parametros de entradas */
        $this->password = $password;

        /** Verifica se a senha foi informada */
        if ($this->password) {

            $hash = PASSWORD_DEFAULT;
            /** Padrão de criptogrfia */
            $cost = array("cost" => 10);
            /** Nível de criptografia */

            /** Gera o hash da senha */
            return password_hash($this->password, $hash, $cost);

        }

    }

    /** Lista todos os egistros do banco com ou sem paginação*/
    public function AllAvailable(int $companyId, int $callActivityId)
    {

        /** Parâmetros de entrada */
        $this->companyId = $companyId;
        $this->callActivityId = $callActivityId;
        $this->active = 'S';
        $this->table = 'users';

        /** Consulta SQL */
        $this->sql = 'select
                            u.*,
                            (select f.path from files f where f.table = :table and f.register_id = u.users_id order by file_id desc limit 1) as file_path,
                            (select f.name from files f where f.table = :table and f.register_id = u.users_id order by file_id desc limit 1) as file_name
                      from users u
		              where u.users_id not in (select user_id from calls_activities_users where call_activity_id = :callActivityId)  
		              and u.company_id = :companyId
		              and u.active = :active';

        /** Preparo o SQL para execução */
        $this->stmt = $this->connection->connect()->prepare($this->sql);

        /** Preencho os parâmetros do SQL */
        $this->stmt->bindParam('companyId', $this->companyId);
        $this->stmt->bindParam('callActivityId', $this->callActivityId);
        $this->stmt->bindParam('active', $this->active);
        $this->stmt->bindParam('table', $this->table);

        /** Executo o SQL */
        $this->stmt->execute();

        /** Retorno o resultado */
        return $this->stmt->fetchAll(\PDO::FETCH_OBJ);

    }

    /** Lista todos os egistros do banco com ou sem paginação*/
    public function AllCallsActivities(int $callId)
    {

        /** Parâmetros de entrada */
        $this->callId = $callId;
        $this->table = 'users';

        /** Consulta SQL */
        $this->sql = 'select u.users_id,
                           u.name_first,
                           u.name_last,
                           (select count(cau.call_activity_user_id) from calls_activities_users cau where cau.user_id = u.users_id) as total_activities,
                           (select count(cam.call_mesage_id) from calls_messages cam where cam.user_id = u.users_id) as total_messages,
                           (select CONCAT(f.path, "/", f.name) from files f where f.table = :table and f.register_id = u.users_id order by file_id desc	limit 1) as profile_photo
                    from users u
                    join calls_activities_users cau on u.users_id = cau.user_id 
                    where cau.call_id = :callId 
                    group by u.users_id';

        /** Preparo o SQL para execução */
        $this->stmt = $this->connection->connect()->prepare($this->sql);

        /** Preencho os parâmetros do SQL */
        $this->stmt->bindParam('callId', $this->callId);
        $this->stmt->bindParam('table', $this->table);

        /** Executo o SQL */
        $this->stmt->execute();

        /** Retorno o resultado */
        return $this->stmt->fetchAll(\PDO::FETCH_OBJ);

    }

    /** Lista todos os egistros do banco com ou sem paginação*/
    public function AllActivityUser(int $callActivityId, int $userId)
    {

        /** Parâmetros de entrada */
        $this->callActivityId = $callActivityId;
        $this->userId = $userId;

        /** Consulta SQL */
        $this->sql = 'select *
                      from users u
                      join calls_activities_users cau on u.users_id = cau.user_id 
                      where cau.call_activity_id = :callActivityId
                      and cau.user_id = :userId';

        /** Preparo o SQL para execução */
        $this->stmt = $this->connection->connect()->prepare($this->sql);

        /** Preencho os parâmetros do SQL */
        $this->stmt->bindParam('callActivityId', $this->callActivityId);
        $this->stmt->bindParam('userId', $this->userId);

        /** Executo o SQL */
        $this->stmt->execute();

        /** Retorno o resultado */
        return $this->stmt->fetchAll(\PDO::FETCH_OBJ);

    }

    /** Fecha uma conexão aberta anteriormente com o banco de dados */
    function __destruct()
    {

        $this->connection = null;

    }

}
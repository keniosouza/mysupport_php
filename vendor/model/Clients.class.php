<?php
/**
* Classe Clients.class.php
* @filesource
* @autor		Kenio de Souza
* @copyright	Copyright 2021 - Souza Consultoria Tecnológica
* @package		vendor
* @subpackage	model
* @version		1.0
* @date		17/09/2021
*/


/** Defino o local onde esta a classe */
namespace vendor\model;

class Clients
{
	/** Declaro as vaiavéis da classe */
	private $connection = null;
	private $sql = null;
	private $stmt = null;
	private $start = null;
	private $max = null;
	private $limit = null;
	private $clientsId = null;
	private $usersId = null;
	private $companyId = null;
	private $clientName = null;
	private $fantasyName = null;
	private $document = null;
	private $zipCode = null;
	private $adress = null;
	private $number = null;
	private $complement = null;
	private $district = null;
	private $city = null;
	private $state = null;
	private $stateInitials = null;
	private $country = null;
	private $dateRegister = null;
	private $responsible = null;
	private $type = null;
	private $situationId = null;
	private $cns = null;
	private $field = null;
	private $callId = null;


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
		$this->sql = "describe clients";

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
		foreach($this->field as $UsersKey => $Result){

			/** Pega o nome do Field/Campo */
			$Field = $Result->Field;

			/** Carrega os objetos como null */
			$resultDescribe->$Field = null;

		}

		/** Retorna os campos declarados como vazios */
		return $resultDescribe;

	}

	/** Lista os registros do banco de dados com limitação */
	public function Get(int $clientsId)
	{

		/** Parametros de entrada */
		$this->clientsId = $clientsId;

		/** Consulta SQL */
		$this->sql = 'select * from clients  
					  where clients_id = :clients_id';

		/** Preparo o SQL para execução */
		$this->stmt = $this->connection->connect()->prepare($this->sql);

		/** Preencho os parâmetros do SQL */
		$this->stmt->bindParam(':clients_id', $this->clientsId);

		/** Executo o SQL */
		$this->stmt->execute();

		/** Retorno o resultado */
		return $this->stmt->fetchObject();

	}

    /** Lista os registros do banco de dados com limitação */
    public function GetSituation(int $clientsId)
    {

        /** Parametros de entrada */
        $this->clientsId = $clientsId;

        /** Consulta SQL */
        $this->sql = 'select  c.* from clients c
    	              where clients_id = :clients_id 
					  order by clients_id asc ';

        /** Preparo o SQL para execução */
        $this->stmt = $this->connection->connect()->prepare($this->sql);

        /** Preencho os parâmetros do SQL */
        $this->stmt->bindParam(':clients_id', $this->clientsId);

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
		$this->sql = 'select  c.* 
					  from clients c
    	              where company_id = :company_id 
					  order by clients_id asc' ;

		/** Preparo o SQL para execução */
		$this->stmt = $this->connection->connect()->prepare($this->sql);

		/** Preencho os parâmetros do SQL */
		$this->stmt->bindParam(':company_id', $this->companyId);

		/** Executo o SQL */
		$this->stmt->execute();

		/** Retorno o resultado */
		return $this->stmt->fetchAll(\PDO::FETCH_OBJ);

	}

    /** Lista todos os egistros do banco com ou sem paginação*/
    public function AllNoLimit(int $companyId, int $callId)
    {
        /** Parametros de entrada */
        $this->companyId = $companyId;
        $this->callId = $callId;

        /** Consulta SQL */
        $this->sql = 'select * from clients 
                      where clients_id not in (select client_id from calls_clients where call_id = :callId)  
                      and company_id = :companyId';

        /** Preparo o SQL para execução */
        $this->stmt = $this->connection->connect()->prepare($this->sql);

        /** Preenchimento de parâmetros */
        $this->stmt->bindParam(':callId', $this->callId);
        $this->stmt->bindParam(':companyId', $this->companyId);

        /** Executo o SQL */
        $this->stmt->execute();

        /** Retorno o resultado */
        return $this->stmt->fetchAll(\PDO::FETCH_OBJ);

    }

	/** Conta a quantidades de registros */
	public function Count()
	{
		/** Consulta SQL */
		$this->sql = 'select count(clients_id) as qtde
					  from clients 
					  where company_id = :company_id ';

		/** Preparo o SQL para execução */
		$this->stmt = $this->connection->connect()->prepare($this->sql);

		/** Preencho os parâmetros do SQL */
		$this->stmt->bindParam(':company_id', $_SESSION['USERSCOMPANYID']);			

		/** Executo o SQL */
		$this->stmt->execute();

		/** Retorno o resultado */
		return $this->stmt->fetchObject();

	}

	/** Insere um novo registro no banco */
	public function Save(int $clientsId, int $situationId, string $clientName, string $fantasyName, string $document, int $cns, string $zipCode, string $adress, string $number, string $complement, string $district, string $city, string $stateInitials,  string $type)
	{


		/** Parametros */
		$this->clientsId = $clientsId;
        $this->situationId = $situationId;
		$this->clientName = $clientName;
		$this->fantasyName = $fantasyName;
		$this->document = $document;
		$this->cns = $cns;
		$this->zipCode = $zipCode;
		$this->adress = $adress;
		$this->number = $number;
		$this->complement = $complement;
		$this->district = $district;
		$this->city = $city;
		$this->stateInitials = $stateInitials;
		$this->type = $type;

		/** Verifica se o ID do registro foi informado */
		if($this->clientsId > 0){

			/** Consulta SQL */
			$this->sql = 'update clients set situation_id = :situation_id,
                                             client_name = :client_name,
									   	     fantasy_name = :fantasy_name,
									   	     document = :document,
									   	     cns = :cns,
									   	     zip_code = :zip_code,
									   	     adress = :adress,
									   	     number = :number,
									   	     complement = :complement,
									   	     district = :district,
									   	     city = :city,
									   	     state_initials = :state_initials,
									   	     type = :type
					  	  where clients_id = :clients_id';

			/** Preparo o sql para receber os valores */
			$this->stmt = $this->connection->connect()->prepare($this->sql);

			/** Preencho os parâmetros do SQL */
			$this->stmt->bindParam('situation_id', $this->situationId);
			$this->stmt->bindParam('client_name', $this->clientName);
			$this->stmt->bindParam('fantasy_name', $this->fantasyName);
			$this->stmt->bindParam('document', $this->document);
			$this->stmt->bindParam('cns', $this->cns);
			$this->stmt->bindParam('zip_code', $this->zipCode);
			$this->stmt->bindParam('adress', $this->adress);
			$this->stmt->bindParam('number', $this->number);
			$this->stmt->bindParam('complement', $this->complement);
			$this->stmt->bindParam('district', $this->district);
			$this->stmt->bindParam('city', $this->city);
			$this->stmt->bindParam('state_initials', $this->stateInitials);
			$this->stmt->bindParam('type', $this->type);
			$this->stmt->bindParam('clients_id', $this->clientsId);

		}else{//Se o ID não foi informado, grava-se um novo registro

			/** Consulta SQL */
			$this->sql = 'insert into clients(users_id,
											  company_id,
											  situation_id, 
				                              client_name,
											  fantasy_name, 
											  document,
											  cns, 
											  zip_code, 
											  adress, 
											  number, 
											  complement, 
											  district, 
											  city, 				
											  state_initials, 
											  type 
								 	 ) values (:users_id,
									           :company_id,
									           :situation_id,
										       :client_name,
									  		   :fantasy_name,
									  		   :document,
									  		   :cns,
									  		   :zip_code,
									  		   :adress,
									  		   :number,
									  		   :complement,
									  		   :district,
									  		   :city,
									  		   :state_initials,
									  		   :type)';

			/** Preparo o sql para receber os valores */
			$this->stmt = $this->connection->connect()->prepare($this->sql);

			/** Preencho os parâmetros do SQL */
			$this->stmt->bindParam('users_id', $_SESSION['USERSID']);/** Informa o usuário responsável pelo novo cliente cadastrado */
			$this->stmt->bindParam('company_id', $_SESSION['USERSCOMPANYID']);/** Informa a qual empresa pertence o cliente */
			$this->stmt->bindParam('situation_id', $this->situationId);
			$this->stmt->bindParam('client_name', $this->clientName);
			$this->stmt->bindParam('fantasy_name', $this->fantasyName);
			$this->stmt->bindParam('document', $this->document);
			$this->stmt->bindParam('cns', $this->cns);
			$this->stmt->bindParam('zip_code', $this->zipCode);
			$this->stmt->bindParam('adress', $this->adress);
			$this->stmt->bindParam('number', $this->number);
			$this->stmt->bindParam('complement', $this->complement);
			$this->stmt->bindParam('district', $this->district);
			$this->stmt->bindParam('city', $this->city);
			$this->stmt->bindParam('state_initials', $this->stateInitials);
			$this->stmt->bindParam('type', $this->type);

		}

		/** Executo o SQL */
		return $this->stmt->execute();		

	}

	/** Deleta um determinado registro no banco de dados */
	function Delete(int $clientsId)
	{
		/** Parametros de entrada */
		$this->clientsId = $clientsId;

		/** Consulta SQL */
		$this->sql = 'delete from clients
					  where  clients_id = :clients_id';

		/** Preparo o sql para receber os valores */
		$this->stmt = $this->connection->connect()->prepare($this->sql);

		/** Preencho os parâmetros do SQL */
		$this->stmt->bindParam('clients_id', $this->clientsId);

		/** Executo o SQL */
		return $this->stmt->execute();

	}

	/** Fecha uma conexão aberta anteriormente com o banco de dados */
	function __destruct()
	{
		$this->connection = null;
    }
}

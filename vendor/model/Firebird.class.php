<?php
/**
* Classe Firebird.class.php
* @filesource
* @autor		Kenio de Souza
* @copyright	Copyright 2022 - Souza Consultoria Tecnológica
* @package		vendor
* @subpackage	model
* @version		1.0
* @date		 	31/05/2022
*/

/** Defino o local onde a classe esta localizada **/
namespace vendor\model;

use PDO;

class Firebird
{

    /** Declaro as variaveis que irei utilizar na classe **/
    public static $pdo;
    private $host = null; 
    private $user = null;
    private $pass = null;

    function __construct(string $host, string $user, string $pass, string $path, int $port, string $name)
    {

        /** Prepara os parametros do banco de dados */
        $this->host = 'firebird:dbname='.$host.'/'.$port.':'.$path.$name;
        $this->user = $user; 
        $this->pass = $pass; 
        
    }


    /** Método para conectar ao banco de dados **/
    public function connect()
    {
                
        if (!isset(self::$pdo)) {

            /** Inicio a conexão com o banco de dados **/
            self::$pdo = new PDO($this->host, $this->user, $this->pass);

            /** Habilito a listagem de erros ao executar o sql **/
            self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }

        /** Retorno minha conexão **/
        return self::$pdo;
    }

    function __destruct(){}
}

<?php

namespace Ptbf\Database;

use Ptbf\Database\AbstractDriver,
 \PDO;

/**
 * Description of MySql
 *
 * @author Angel Koilov
 */
class Mysql extends AbstractDriver{
	
	function __construct($name, $options) {
		$username = $options['user'];
		$password = $options['password'];
		$host = $options['host'];
		$database = $options['database'];
		
		if (isset($options['port'])) {
			$port = ';port=' . $options['port'];
		} else {
			$port = '';
		}
		
		$dsn = 'mysql:dbname=' . $database . ';host=' . $host . $port;
		
		$pdoOptions = array(
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
		);
		if (isset($options['initCommand'])) {
			$pdoOptions[PDO::MYSQL_ATTR_INIT_COMMAND] = $options['initCommand'];
		}
		
		
		$pdo = new PDO($dsn, $username, $password, $pdoOptions);
		
	}
	
	public function reset(){
		throw new Exception('not implemented');
	}

}
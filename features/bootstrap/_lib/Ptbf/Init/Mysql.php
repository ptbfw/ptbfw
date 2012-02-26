<?php

namespace Ptbf\Init;

use Ptbf\Init\Init,
	\PDO,
	\Symfony\Component\Finder\Finder	
		;

/**
 * Description of MySql
 *
 * @author Angel Koilov
 */
class Mysql extends Init {

	private $directory;
	private $pdo;

	function __construct($name, $options) {

		if (isset($options['directory'])) {
			$this->directory = $options['directory'];
		} else {
			$this->directory = $name;
		}

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
		if (isset($options['init_command'])) {
			$pdoOptions[PDO::MYSQL_ATTR_INIT_COMMAND] = $options['init_command'];
		}


		$pdo = new PDO($dsn, $username, $password, $pdoOptions);
		$this->pdo = $pdo;
	}

	public function reset() {
		$sqlDirectory = __DIR__ . '/../../../database/' . $this->getDirectory();

		if (!is_dir($sqlDirectory)) {
			throw new \Exception("$sqlDirectory don't exist");
		}

		$finder = new Finder();
		$sqlCode = '';
		foreach ($finder->files()->name('*.sql')->sortByName()->in($sqlDirectory) as $file) {
			/* @var $file \Symfony\Component\Finder\SplFileInfo */
			$sqlCode .= file_get_contents($file->getRealPath());
		}
		
		$sqlCode = trim($sqlCode);
		if (empty($sqlCode)) {
			return true;
		}
		
		$this->getPdo()->exec($sqlCode);

	}

	public function getDirectory() {
		return $this->directory;
	}

	/**
	 * @return \PDO
	 */
	public function getPdo() {
		return $this->pdo;
	}

}
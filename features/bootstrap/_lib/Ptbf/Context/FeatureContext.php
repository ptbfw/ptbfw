<?php

namespace Ptbf\Context;

use Behat\Behat\Event\SuiteEvent,
	Behat\Behat\Event\FeatureEvent

;

/**
 * Description of FeatureContext
 * Here we will override some mink methods
 * basicly all CSS selectors wich return 1 element, should have founded exaclity 1 element
 * 
 * @author Angel Koilov <angel.koilov@gmail.com>
 */
class FeatureContext extends \Behat\Mink\Behat\Context\BaseMinkContext {

	protected static $mink;
	protected static $options = array();
	private static $databaseDrivers = array();

	function __construct($options) {
		self::$options = $options;
	}

	public function getMink() {
		return self::getMinkStatic();
	}

	public static function getMinkStatic() {
		$mink = self::$mink;
		if ($mink === NULL) {
			$mink = new \Ptbf\Mink\Mink();
//			$mink = new \Behat\Mink\Mink();
			self::$mink = $mink;
		}
		return $mink;
	}

	/**
	 * @BeforeSuite
	 */
	public static function prepareSuite(SuiteEvent $event) {
		self::$options = $event->getContextParameters();
		$options = self::$options;
	}

	/**
	 * override default mink hook
	 * we moved this to before scenario step
	 * becouse you can stop/change some sessions during scenario
	 */
	public function prepareMinkSessions($event){}
	
	/** 
	 * 
	 * Restore mink sessions from config
	 * Restart database
	 * 
	 * @BeforeScenario 
	 */
	public function before($event) {
		$options = $this->getParameters();
		$drivers = array();

		if (isset($options['db_init'])) {
			foreach ($options['db_init'] as $service => $ServiceOptions) {
				$driverName = 'ptbf\\Database\\' . ucfirst($ServiceOptions['type']);
				if (array_key_exists($service, $drivers)) {
					throw new Exception("driver {$service} already registered");
				}
				$drivers[$service] = new $driverName($service, $ServiceOptions);
			}
			self::$databaseDrivers = $drivers;
		}

		$mink = $this->getMink();

		$sessionsOptions = $options['sessions']?:NULL;
		
			/**
			 * Mink session if session name contains
			 * 
			 * mink
			 * IE, internet, explorer
			 * safari
			 * chrom(e|ium)
			 * opera
			 * firefox
			 */
			if (preg_match('/(?:(mink|ie|firefox|chrom||safari|internet|explorer|opera))/i', $options['default_session'])) {
				$client = null;
				
				if (isset($sessionsOptions[$options['default_session']])) {
					$currentSessionOptions = $sessionsOptions[$options['default_session']];
					if (isset($currentSessionOptions['port'])) {
						$port = $currentSessionOptions['port'];
					} else {
						$port = 9999;
					}
					
					$connection = new \Behat\SahiClient\Connection(null, $currentSessionOptions['host'], $port);
					$client = new \Behat\SahiClient\Client($connection);
				} else {
					$client = null;
				}
				
				$driver = new \Behat\Mink\Driver\SahiDriver($options['default_session'], $client);
				$session = new \Behat\Mink\Session($driver);
				$session->start();
				$session->visit($options['base_url']);
				$mink->registerSession($options['default_session'], $session);
			} else {
				throw new Exception('goutte session not implemented');
				// @TODO
				$driver = new \Behat\Mink\Driver\GoutteDriver();
			}
		$mink->setDefaultSessionName($options['default_session']);
		
		$this->databaseReset();
		
	}

	public function databaseReset() {
		foreach ($this->getDatabaseDrivers() as $d) {
			$d->reset();
		}
	}

	public function getDatabaseDrivers() {
		return self::$databaseDrivers;
	}

	/**
	 * used by Mink
	 * 
	 * @param type $name
	 * @return type 
	 */
	public function getParameter($name) {
		return self::$options[$name];
	}

	/**
	 * used by Mink
	 */
	public function getParameters() {
		return self::$options;
	}

}
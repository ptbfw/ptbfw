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
class FeatureContext extends \Behat\Mink\Behat\Context\MinkContext {

	private static $defaultSession;
	protected static $mink;

	protected static $options = array();
	
	function __construct($options) {
		
	}

	/**
	 * @BeforeSuite
	 */
	public static function prepare(SuiteEvent $event) {
		self::$options = $event->getContextParameters();
	}

	/** @BeforeScenario */
	public function before($event) {
 		$options = self::$options;
		$drivers = array();

		if (isset($options['dbInit'])) {
			foreach ($options['dbInit'] as $service => $ServiceOptions) {
				$driverName = 'ptbf\\Database\\' . ucfirst($ServiceOptions['type']);
				if (array_key_exists($service, $drivers)) {
					throw new Exception("driver {$service} already registered");
				}
				$drivers[$service] = new $driverName($service, $ServiceOptions);
			}
		}

		$mink = $this->getMink();
		
		switch ($options['default_session']) {
			case 'chrome':
				$driver = new \Behat\Mink\Driver\SahiDriver($options['default_session']);
				$session = new \Behat\Mink\Session($driver);
				$session->start();
				$session->visit($options['baseUrl']);
				$mink->registerSession($options['default_session'], $session);
				$mink->setDefaultSessionName($options['default_session']);
				self::$defaultSession = $options['default_session'];
				break;

			default:
				throw new Exception("driver {$options['default_session']} not implemented");
				break;
		}
	}

	/** @BeforeFeature */
	public static function setupFeature(FeatureEvent $event) {









//		$mink = self::$mink;
//		/*@var $mink \Behat\Mink\Mink*/
//		$mink->setDefaultSessionName(self::$defaultSession);
	}

	public function databaseReset() {
		foreach ($this->getDatabaseDrivers() as $d) {
			$d->reset();
		}
	}

	public function getDatabaseDrivers() {
		return $this->databaseDrivers;
	}

}
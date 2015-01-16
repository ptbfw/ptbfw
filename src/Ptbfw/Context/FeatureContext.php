<?php

namespace Ptbfw\Context;

use Behat\Testwork\Hook\Scope\BeforeSuiteScope;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;

/**
 * Description of FeatureContext
 * Here we will override some mink methods
 * basicly all CSS selectors wich return 1 element, should have founded exaclity 1 element
 * 
 * @author Angel Koilov <angel.koilov@gmail.com>
 */
class FeatureContext extends \Behat\MinkExtension\Context\MinkContext implements \Ptbfw\Initializer\InitializerAwareInterface {

	protected static $mink;
	protected static $options = array();

	function __construct($options) {
		self::$options = $options;
	}
    
	public function getMink() {
		return self::getMinkStatic();
	}

	public static function getMinkStatic() {
		$mink = self::$mink;
		if ($mink === NULL) {
			$mink = new \Ptbfw\Mink\Mink();
			self::$mink = $mink;
		}
		return $mink;
	}

	/**
	 * @BeforeSuite
	 */
	public static function prepareSuite(BeforeSuiteScope $scope) {
        $event = $scope->getSuite()->getSettings();
		self::$options = $event;
		$options = self::$options;
	}

	/**
	 * 
	 * Restore mink sessions from config
	 * 
	 * @BeforeScenario
	 */
	public function before(BeforeScenarioScope $scope) {
		$this->sessionRestart();
	}

	/**
	 * restart sessoins
	 */
	private function sessionRestart() {

		$options = self::$options;
		$mink = $this->getMink();
		$mink->resetSessions();

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
            
			if (false == $mink->hasSession($options['default_session'])) {
				if (isset($sessionsOptions[$options['default_session']])) {
					$currentSessionOptions = $sessionsOptions[$options['default_session']];
					if (isset($currentSessionOptions['port'])) {
						$port = $currentSessionOptions['port'];
					} else {
						$port = 4444;
					}

					$client = new \Selenium\Client($currentSessionOptions['host'], $port);
				} else {
					$client = null;
				}

				$driver = new \Ptbfw\Selenium2Driver\Selenium2Driver();
				$session = new \Ptbfw\Mink\Session($driver);
				$session->start();
				$mink->registerSession($options['default_session'], $session);
			}
		} else {
			throw new Exception('goutte session not implemented');
			// @TODO
		}
        
		$mink->setDefaultSessionName($options['default_session']);
        $mink->getSession()->visit($options['base_url']);
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
	 *
	 * @return Behat\Mink\Element\DocumentElement
	 */
	public function getPage() {
		return $this->getSession()->getPage();
	}

	/**
	 * used by Mink
	 */
	public function getParameters() {
		return self::$options;
	}

	/*
	 * overriden for ajax-save
	 * @TODO WTF IS THIS !??
	 */
	public function assertPageContainsText($text) {
		try {
			parent::assertPageContainsText($text);
		} catch (\Exception $e) {
			$this->getSession()->wait(3000);
			parent::assertPageContainsText($text);
		}
	}

}
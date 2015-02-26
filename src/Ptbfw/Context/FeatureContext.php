<?php

namespace Ptbfw\Context;

use Behat\Testwork\Hook\Scope\BeforeSuiteScope;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;

/**
 * Description of FeatureContext
 * 
 * @author Angel Koilov <angel.koilov@gmail.com>
 */
class FeatureContext extends \Behat\MinkExtension\Context\MinkContext implements \Ptbfw\Initializer\InitializerAwareInterface {

	protected static $mink;
	protected $options;

	public function __construct($options = array()) {
		$this->options = $options;
	}
    
	/**
	 * @BeforeSuite
	 */
	public static function prepareSuite(BeforeSuiteScope $scope) {
        // nothing to do
        // $event = $scope->getSuite()->getSettings();
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

		$mink = $this->getMink();
		$mink->resetSessions();
	}



	/**
	 * used by Mink
	 * 
	 * @param type $name
	 * @return type 
	 */
	public function getParameter($name) {
		return $this->options[$name];
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
		return $this->options;
	}

}
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
	 * 
	 * Restore mink sessions from config
	 * 
	 * @BeforeScenario
	 */
	public function before(BeforeScenarioScope $scope) {
		$mink = $this->getMink();
		$mink->resetSessions();
	}

	/**
	 *
	 * @return Behat\Mink\Element\DocumentElement
	 */
	public function getPage() {
		return $this->getSession()->getPage();
	}

}